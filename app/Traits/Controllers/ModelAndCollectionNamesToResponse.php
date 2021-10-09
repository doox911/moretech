<?php

  namespace App\Traits\Controllers;

  use Illuminate\Database\Eloquent\Model;

  trait ModelAndCollectionNamesToResponse
  {
    use ModelName, CollectionName;

    /**
     * Установить имена модели и коллекции
     *
     * @param Model $model Модель
     */
    public function setModelAndCollectionNames(Model $model): void
    {
      $this->setModelName($model);
      $this->setCollectionName();
    }
  }
