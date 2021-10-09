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
