<?php

namespace App\Http\Controllers;

use App\Classes\MetaDataGetter;
use App\Classes\DataSetsGetter;
use App\Http\Requests\DataSetQueryRequest;
use CommandService;
use Illuminate\Http\JsonResponse;

class MetaDataController {

  /**
   *
   * @return \Illuminate\Http\JsonResponse
   * @deprecated пока не работает
   */
  public function getCatalogs(): JsonResponse {
    $dsg = new DataSetsGetter;


    $catalogs = [];
    foreach ($dsg->data() as $dataset) {
      $meta_data = new MetaDataGetter($dataset['urn']);
      $catalogs[] = $meta_data->data();
    }

    return response()->json([
      'content' => [
        'catalogs' => $catalogs,
      ]
    ]);
  }

  public function runQuery(DataSetQueryRequest $request) {
    $data = $request->validated();

    $select_fields = $data['select'];

    $queries = [];
    foreach ($select_fields as $select_field) {
      $field = $select_field['dataset_name'] . '.' . $select_field['field_name'];
      if (!isset($queries[$select_field['dataset_name']])) {
        $queries[$select_field['dataset_name']] = "select $field";
      } else {
        $queries[$select_field['dataset_name']] .= ",$field";
      }
    }


    // todo where
    $where_fields = $data['where'];
    foreach ($where_fields as $where_field) {
      $query = &$queries[$where_field['field']['dataset_name']];
      if (!isset($query) || ($query && !strstr($query, 'where'))) {

        if (!strstr($query, 'select')) {
          $query = "select *";
        }

        $query .= " from {$where_field['field']['dataset_name']} where ";
      } else {
        $query .= " and ";
      }
      $field = $where_field['field']['dataset_name'] . '.' . $where_field['field']['field_name'];

      $query .= "$field {$where_field['condition']} {$where_field['value']}";
    }

    unset($query);

    // todo sort
    $sort_fields = $data['sort'];

    foreach ($sort_fields as $sort_field) {
      $query = &$queries[$sort_field['dataset_name']];

      if (!$query || !strstr($query, 'select')) {
        $query = "select *";
      }

      if (!strstr($query, 'from')) {
        $query .= " from {$sort_field['dataset_name']}";
      }

      $field = $sort_field['dataset_name'] . '.' . $sort_field['field_name'];

      if (!strstr($query, 'order by')) {
        $query .= " ORDER BY $field";
      } else {
        $query .= ", $field";
      }
    }


    $cs = (new CommandService($queries))->run();


    return response()->json([
      'message' => 'Все запросы успешно отправлены в очередь',
      'content' => [
        'queries' => $cs
      ]
    ]);
  }
}
