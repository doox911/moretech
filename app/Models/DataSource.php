<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSource extends Model {

  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'name',
    'url',
  ];
}
