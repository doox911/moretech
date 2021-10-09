<?php

  namespace App\Traits\Controllers;

  use Illuminate\Support\Str;
  use Illuminate\Database\Eloquent\Model;

  trait ModelName
  {

    /**
     * Имя модели
     *
     * @var string
     */
    protected string $model_name;

    /**
     * Установить имя модели
     *
     * @param Model $model
     */
    protected function setModelName(Model $model): void
    {
      $this->model_name = class_basename($model);
    }

    /**
     * Имя модели для ответа сервера
     *
     * @return string
     */
    protected function getModelNameToResponse(): string
    {
      return Str::snake($this->model_name);
    }
  }
