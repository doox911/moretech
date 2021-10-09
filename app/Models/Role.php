<?php

  namespace App\Models;

  use Spatie\Permission\Models\Role as SpatieRole;

  class Role extends SpatieRole
  {

    /**
     * Супер админ
     */
    public const SUPER_ADMIN = 'super-admin';

    /**
     * Администратор
     *
     * Меньше полномочий, чем у супер-администратора
     */
    public const ADMIN = 'admin';

    /**
     * Пользователь
     *
     * Наименьшие полномочия
     */
    public const USER = 'user';

    /**
     * Поставщик
     */
    public const SUPPLIER = 'supplier';

    protected $fillable = [
      'name',
      'guard_name',
    ];
  }
