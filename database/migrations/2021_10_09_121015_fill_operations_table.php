<?php

use App\Models\DataOperation;
use Illuminate\Database\Migrations\Migration;

class FillOperationsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void {
    DataOperation::create([
      'name' => 'Сложение',
      'formula' => '+',
      'canonical_name' => 'default',
    ]);

    DataOperation::create([
      'name' => 'Вычитание',
      'formula' => '-',
      'canonical_name' => 'default',
    ]);

    DataOperation::create([
      'name' => 'Умножение',
      'formula' => '*',
      'canonical_name' => 'default',
    ]);

    DataOperation::create([
      'name' => 'Деление',
      'formula' => '/',
      'canonical_name' => 'default',
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
