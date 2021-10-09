<?php

namespace App\Http\Resources;

use App\Models\DataOperation;
use Illuminate\Http\Resources\Json\JsonResource;

class DataOperationResource extends JsonResource {

  public function toArray($request): array {

    /**
     * @var DataOperation $operation
     */
    $data_operation = $this->resource;

    return [
      'name' => $data_operation->name,
      'formula' => $data_operation->formula,
      'canonical_name' => $data_operation->canonical_name,
    ];
  }
}
