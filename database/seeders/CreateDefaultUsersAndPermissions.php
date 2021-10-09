<?php

  namespace Database\Seeders;

  use Illuminate\Database\Seeder;
  use Illuminate\Support\Facades\Hash;
  use Spatie\Permission\Models\Permission;
  use Spatie\Permission\Models\Role;
  use Spatie\Permission\PermissionRegistrar;

  class CreateDefaultUsersAndPermissions extends Seeder
  {

    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
      // Reset cached roles and permissions
      app()[PermissionRegistrar::class]->forgetCachedPermissions();

      // create permissions
      Permission::create(['name' => 'see all', 'guard_name' => 'api']);

      // create roles and assign existing permissions
      $sa = Role::create(['name' => 'super-admin', 'guard_name' => 'api']);

      $admin = Role::create(['name' => 'admin', 'guard_name' => 'api']);

      $polyakov = \App\Models\User::create([
        'name' => 'Андрей',
        'email' => 'doox911@ya.ru',
        'password' => Hash::make('12345678'),
        'nickname' => 'a.polyakov',
        'second_name' => 'Поляков',
        'patronymic' => 'Сергеевич',
      ]);

      $polyakov->assignRole($sa);

      $ivanov = \App\Models\User::create([
        'name' => 'Иван',
        'email' => 'ivan@ya.ru',
        'password' => Hash::make('12345678'),
        'nickname' => 'i.ivanov',
        'second_name' => 'Иванов',
        'patronymic' => 'Иванович',
      ]);

      $ivanov->assignRole($admin);
    }
  }
