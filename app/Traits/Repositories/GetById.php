<?php

  namespace App\Traits\Repositories;

  use Illuminate\Database\Eloquent\Model;

  trait GetById
  {

    /**
     * Получение модель по уникальному идентификатору
     *
     * @param int $model_id Уникальный идентификатор модели
     * @return Model|null
     */
    public function getById(int $model_id): ?Model
    {
      return $this->model::find($model_id);
    }
  }
