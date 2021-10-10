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
      'select.*.name' => 'required|string',
      'select.*.type' => 'required|string',
      'select.*.dataset_name' => 'required|string',

      'where' => 'present|array',
      'where.*.field' => 'required|array',
      'where.*.field.name' => 'required|string',
      'where.*.field.type' => 'required|string',
      'where.*.field.dataset_name' => 'required|string',
      'where.*.condition' => 'required|string',
      'where.*.value' => 'required|string',

      'sort' => 'array|present',
      'sort.*.name' => 'required|string',
      'sort.*.type' => 'required|string',
      'sort.*.dataset_name' => 'required|string',
    ];
  }
}
