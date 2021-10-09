<?php

  namespace App\Traits\Repositories;

  use Illuminate\Database\Eloquent\Model;

  trait DefaultUpdate
  {

    use GetById;

    /**
     * Обновить модель
     *
     * @param array $model Модель
     * @return Model
     */
    public function update(array $model): Model
    {
      $m = $this->getById($model['id']);

      $m->update($model);

      return $m;
    }
  }
