<?php

  namespace App\Http\Middleware;

  use Closure;
  use Illuminate\Http\Request;
  use App\Traits\PrepareResponse;
  use App\Traits\Middleware\ValidateData;

  class Login
  {

    use PrepareResponse, ValidateData;

    /**
     * Код ошибки в случае не корректных данных
     *
     * @var int
     */
    private int $code = 401;

    /**
     * Правила валидации данных создаваемого пользователя
     *
     * @return string[]
     */
    private function rules(): array
    {
      return [
        'email' => 'required|email',
        'password' => 'required',
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
        'email.required' => 'Электронный адрес - обязательное поле',
        'email.email' => 'Не корректный электронный адрес',

        'password.required' => 'Пароль - обязательное поле',
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
