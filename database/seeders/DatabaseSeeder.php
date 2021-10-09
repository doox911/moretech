<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {

    /**
     * Запускать при инициализации приложения
     *
     * Порядок важен.
     */
    $this->call([
      CreateDefaultUsersAndPermissions::class,
    ]);
  }
}
