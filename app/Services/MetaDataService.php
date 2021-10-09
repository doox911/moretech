<?php

namespace App\Services;

use App\Models\DataSource;
use Illuminate\Support\Collection;

/**
 * Class MetaDataService
 *
 * @package
 */
class MetaDataService {

  /**
   * Возврващает источники датасетов
   *
   * @return Collection
   */
  public static function getDataSources(): Collection {
    return DataSource::all();
  }

}
