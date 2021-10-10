<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataOperation extends Model {

  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'name',
    'formula',
    'canonical_name',
    'user_id',
  ];
}
