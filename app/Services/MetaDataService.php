<?php

namespace App\Services;

use App\Models\DataOperation;
use App\Models\DataSource;
use Illuminate\Support\Collection;

/**
 * Class MetaDataService
 *
 * @package
 */
class MetaDataService {

  /**
   * Возвращает источники датасетов
   *
   * @return Collection
   */
  public static function getDataSources(): Collection {
    return DataSource::all();
  }

  /**
   * Возвращает операции над данными датасетов
   *
   * @return Collection
   */
  public static function getDataOperations(): Collection {
    return DataOperation::all();
  }

}
