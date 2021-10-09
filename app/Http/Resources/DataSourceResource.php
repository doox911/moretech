<?php

namespace App\Http\Resources;

use App\Models\DataSource;
use Illuminate\Http\Resources\Json\JsonResource;

class DataSourceResource extends JsonResource {

  public function toArray($request): array {

    /**
     * @var DataSource $data_source
     */
    $data_source = $this->resource;

    return [
      'name' => $data_source->name,
      'url' => $data_source->url,
    ];
  }
}
