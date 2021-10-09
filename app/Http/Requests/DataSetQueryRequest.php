<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataSetQueryRequest extends FormRequest {
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules(): array {
    return [
      'select' => 'required|array',
      'select.*.field_name' => 'required|string',
      'select.*.field_type' => 'required|string',
      'select.*.dataset_name' => 'required|string',

      'where' => 'required|array',
      'where.*.field' => 'required|array',
      'where.*.field.field_name' => 'required|string',
      'where.*.field.field_type' => 'required|string',
      'where.*.field.dataset_name' => 'required|string',
      'where.*.condition' => 'required|string',
      'where.*.value' => 'required|string',

      'sort' => 'required|array',
      'sort.*.field_name' => 'required|string',
      'sort.*.field_type' => 'required|string',
      'sort.*.dataset_name' => 'required|string',
    ];
  }
}
