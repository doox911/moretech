<?php

namespace App\Services;

use App\Models\DataOperation;
use App\Models\DataSource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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
    $user = Auth::user();

    return DataOperation::whereNull('user_id')
      ->orWhere('user_id', $user->id ?? null)
      ->get();
  }

}
