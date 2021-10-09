<?php

  namespace App\Traits\Repositories;

  use Illuminate\Database\Eloquent\Model;

  trait DefaultStore
  {

    /**
     * Создать модель
     *
     * @param array $model Модель
     * @return Model
     */
    public function store(array $model): Model
    {
      return $this->model::create($model);
    }
  }
