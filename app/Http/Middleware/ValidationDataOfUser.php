<?php

  namespace App\Http\Middleware;

  use Closure;
  use Illuminate\Http\Request;
  use App\Traits\PrepareResponse;
  use App\Traits\Middleware\ValidateData;

  class ValidationDataOfUser
  {

    use PrepareResponse, ValidateData;

    /**
     * Код ошибки в случае не корректных данных
     *
     * @var int
     */
    private int $code = 400;

    /**
     * Правила валидации данных создаваемого пользователя
     *
     * @return string[]
     */
    private function rules(): array
    {
      return [
        'nickname' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
      ];
    }

    /**
     * Кастомные сообщения ошибок
     *
     * @return string[]
     */
    private function messages(): array
    {
      return [
        'nickname.required' => 'Псевдоним - обязательное поле',
        'nickname.string' => 'Псевдоним должен быть строкой',
        'nickname.max' => 'Псевдоним слишком длинный',

        'email.required' => 'Электронный адрес - обязательное поле',
        'email.string' => 'Электронный адрес должен быть строкой',
        'email.email' => 'Не корректный электронный адрес',
        'email.max' => 'Электронный адрес слишком длинный',
        'email.unique' => 'Пользователь с таким электронным адресом уже зарегестрирован в системе',

        'password.required' => 'Пароль - обязательное поле',
        'password.string' => 'Пароль должен быть строкой',
        'password.min' => 'Пароль слишком короткий',
        'password.confirmed' => 'Пароли не совпадают',
      ];
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

      $this->validate($request);

      return $next($request);
    }
  }
