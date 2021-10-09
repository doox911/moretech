<?php

use App\Models\DataSource;
use Illuminate\Database\Migrations\Migration;

class FillDataSourcesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void {
    DataSource::create([
      'name' => 'Популяция',
      'url' => 'https://pkgstore.datahub.io/core/population/11/datapackage.json',
    ]);

    DataSource::create([
      'name' => 'Ковид-19',
      'url' => 'https://pkgstore.datahub.io/core/covid-19/947/datapackage.json',
    ]);

    DataSource::create([
      'name' => 'Список стран',
      'url' => 'https://pkgstore.datahub.io/core/country-list/11/datapackage.json',
    ]);
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void {
    //
  }
}
