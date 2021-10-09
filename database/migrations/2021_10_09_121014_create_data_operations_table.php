<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataOperationsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void {
    Schema::create('data_operations', function (Blueprint $table) {
      $table->increments('id');

      $table->string('name');
      $table->string('canonical_name')->nullable();
      $table->string('formula', 500);

      $table->unsignedBigInteger('user_id')->nullable();
      $table->foreign('user_id')->references('id')->on('users');

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
    Schema::dropIfExists('data_operations');
  }
}
