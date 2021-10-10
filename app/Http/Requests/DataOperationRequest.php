<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @package
 */
class DataOperationRequest extends FormRequest {

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules(): array {
    return [
      'name' => 'required|max:191',
      //'canonical_name' => 'required|max:191',
      'formula' => 'required|max:500',
    ];
  }
}
