<?php

  namespace App\Traits\Repositories;

  use Illuminate\Database\Eloquent\Model;

  trait GetModel
  {

    /**
     * Модель
     *
     * @return Model
     */
    public function getModel(): Model
    {
      return $this->model;
    }
  }
