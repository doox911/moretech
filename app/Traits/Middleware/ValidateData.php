<?php

  namespace App\Traits\Middleware;

  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Validator;

  trait ValidateData
  {

    /**
     * Валидация входной информации
     *
     * @param Request $request
     * @return null|JsonResponse
     */
    public function validate(Request $request): ?JsonResponse
    {
      /**
       * Validator
       */
      $v = Validator::make($request->all(), $this->rules(), $this->messages());

      /**
       * Если валидация данных провалена
       */
      if ($v->fails()) {
        $errors = [...$v->errors()->all()];

        return $this->prepareResponse([], $errors, $this->code)->throwResponse();
      }

      return null;
    }
  }
