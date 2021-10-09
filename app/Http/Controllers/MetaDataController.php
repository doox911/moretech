<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataOperationRequest;
use App\Http\Requests\DataSourceRequest;
use App\Http\Resources\DataOperationResource;
use App\Models\DataOperation;
use App\Services\MetaDataService;
use App\Classes\DataSetsGetter;
use App\Classes\MetaDataGetter;
use App\Http\Requests\DataSetQueryRequest;
use App\Http\Resources\DataSourceResource;
use App\Models\DataSource;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;
use CommandService;

class MetaDataController {

  private $user = null;


  public function __construct() {
    $this->user = Auth::user();
  }

  /**
   *
   * @param DataSourceRequest $request
   * @return JsonResponse
   * @throws Throwable
   */
  public function storeDataSource(DataSourceRequest $request): JsonResponse {
    $data = $request->validated();

    return response()->json([
      'messages' => ['Источник датасета успешно сохранён'],
      'content' => [
        'new_data_source' => DataSource::create($data),
      ]
    ]);
  }

  /**
   *
   * @return JsonResponse
   * @description Возврващает список датасетов
   */
  public function getDataSources(): JsonResponse {
    return response()->json([
      'content' => [
        'data_sources' => DataSourceResource::collection(MetaDataService::getDataSources()),
      ]
    ]);
  }

  /**
   *
   * @param string $name
   * @param string $url
   * @return JsonResponse
   * @description Возвращает список датасетов
   */
  public function addDataSource(string $name, string $url): JsonResponse {
    $data_source = DataSource::create([
      'name' => $name,
      'url' => $url,
    ]);

    return response()->json([
      'content' => [
        'data_source' => DataSourceResource::make($data_source),
      ]
    ]);
  }



  /**
   * Сохраняет операцию на данными
   *
   * @param DataOperationRequest $request
   * @return JsonResponse
   * @throws Throwable
   */
  public function storeDataOperation(DataOperationRequest $request): JsonResponse {
    $data = $request->validated();
    $data['user_id'] = $this->user->id ?? null;

    return response()->json([
      'messages' => ['Операция успешно сохранена'],
      'content' => [
        'new_data_operation' => DataOperation::create($data),
      ]
    ]);
  }

  /**
   *
   * @return JsonResponse
   * @description Возвращает список операций над данными датасетов
   */
  public function getDataOperations(): JsonResponse {
    return response()->json([
      'content' => [
        'data_operations' => DataOperationResource::collection(MetaDataService::getDataOperations()),
      ]
    ]);
  }

  /**
   *
   * @param string $name
   * @param string $formula
   * @return JsonResponse
   * @description Добавляет операцию над данными датасетов
   */
  public function addDataOperation(string $name, string $formula): JsonResponse {
    $data_process = DataOperation::create([
      'name' => $name,
      'formula' => $formula,
      'user_id' => $this->user->id ?? null,
    ]);

    return response()->json([
      'content' => [
        'data_process' => DataOperationResource::make($data_process),
      ]
    ]);
  }



  /**
   *
   * @return JsonResponse
   * @description Возврващает список датасетов
   * @throws GuzzleException
   */
  public function getDatasets(): JsonResponse {
    $http_client_params = [
      'timeout' => 30.0,
      'cookie' => true,
      'verify' => false,
      'request.options' => [],
    ];

    $client = new Client($http_client_params);

    $datasets = collect();

    foreach (MetaDataService::getDataSources() as $url) {
      $res = $client->request('GET', $url);
      $response_json = json_decode($res->getBody());

      $datasets->push($response_json);
    }

    return response()->json([
      'content' => [
        'datasets' => $datasets,
      ]
    ]);
  }


  /**
   *
   * @return JsonResponse
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
