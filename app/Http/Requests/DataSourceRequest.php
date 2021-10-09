<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @package
 */
class DataSourceRequest extends FormRequest {

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules(): array {
    return [
      'name' => 'required|max:191',
      'url' => 'required|max:591',
    ];
  }
}
