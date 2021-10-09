<?php

  namespace App\Traits\Repositories;

  trait LastInsertId
  {

    /**
     * Последний уникальный идентификатор
     *
     * @return int
     */
    final public function getLastInsertId(): int
    {
      return $this
        ->model
        ->orderBy('id', 'desc')
        ->withTrashed()
        ->take(1)
        ->first()
        ->id;
    }

  }
