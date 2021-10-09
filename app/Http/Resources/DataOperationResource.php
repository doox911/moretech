<?php

namespace App\Http\Resources;

use App\Models\DataOperation;
use Illuminate\Http\Resources\Json\JsonResource;

class DataOperationResource extends JsonResource {

  public function toArray($request): array {

    /**
     * @var DataOperation $operation
     */
    $operation = $this->resource;

    return [
      'name' => $operation->name,
      'formula' => $operation->formula,
    ];
  }
}
