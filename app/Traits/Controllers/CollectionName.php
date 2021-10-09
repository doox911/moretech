<?php

  namespace App\Traits\Controllers;

  use Illuminate\Support\Str;

  trait CollectionName
  {

    use ModelName;

    /**
     * Имя коллекции
     *
     * @var string
     */
    protected string $collection_name;

    /**
     * Установить имя коллекции
     */
    public function setCollectionName(): void
    {
      $this->collection_name = Str::plural($this->model_name);
    }

    /**
     * Имя коллекции для ответа
     *
     * @return string
     */
    protected function getCollectionNameToResponse(): string
    {
      return Str::snake($this->collection_name);
    }
  }
