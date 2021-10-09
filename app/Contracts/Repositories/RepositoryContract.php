<?php

  namespace App\Contracts\Repositories;

  use Illuminate\Database\Eloquent\Model;

  interface RepositoryContract
  {

    /**
     * Получение модели по уникальному идентификатору
     *
     * @param int $model_id
     * @return Model
     */
    public function getById(int $model_id): ?Model;

    /**
     * Последний уникальный идентификатор
     *
     * @return int
     */
    public function getLastInsertId(): int;
  }
