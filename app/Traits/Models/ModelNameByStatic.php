<?php

  namespace App\Traits\Models;

  trait ModelNameByStatic
  {

    /**
     * Имя таблицы у модели
     *
     * @return string Имя таблицы
     */
    public static function getTableName(): string
    {
      return (new static)->getTable();
    }
  }
