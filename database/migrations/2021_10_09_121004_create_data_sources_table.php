<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSourcesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void {
    Schema::create('data_sources', function (Blueprint $table) {
      $table->increments('id');

      $table->string('name');
      $table->string('url');

      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void {
    Schema::dropIfExists('data_sources');
  }
}
