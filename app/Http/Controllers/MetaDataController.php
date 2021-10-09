<?php

namespace App\Http\Controllers;

use App\Class\MetaDataGetter;
use App\Classes\DataSetsGetter;
use App\Http\Requests\DataSetQueryRequest;

class MetaDataController {

  /**
   *
   * @return \Illuminate\Http\JsonResponse
   * @deprecated пока не работает
   */
  public function getCatalogs(): \Illuminate\Http\JsonResponse {
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
      if (!isset($queries[$select_field['dataset_name']])) {
        $queries[$select_field['dataset_name']] = "select {$select_field['field_name']}";
      } else {
        $queries[$select_field['dataset_name']] .= ",{$select_field['field_name']}";
      }
    }

    dd($queries);

    // todo where
    $where = $data['where'];

    // todo sort
    $sort = $data['sort'];


    return $query;
  }
}
