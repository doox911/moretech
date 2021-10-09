<?php

  namespace App\Http\Middleware;

  use Closure;
  use Exception;
  use Illuminate\Http\Request;
  use App\Traits\PrepareResponse;
  use App\Traits\Middleware\ValidateData;

  abstract class Unique
  {

    use PrepareResponse, ValidateData;

    /**
     * Код ошибки в случае не корректных данных
     *
     * @var int
     */
    protected int $code = 400;

    /**
     * Правила валидации
     *
     * @return string[]
     * @throws Exception
     */
    protected function rules(): array
    {
      throw new Exception('Необходимо переопределить метод rules');
    }

    /**
     * Кастомные сообщения ошибок
     *
     * @return string[]
     * @throws Exception
     */
    protected function messages(): array
    {
      throw new Exception('Необходимо переопределить метод messages');
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    final public function handle(Request $request, Closure $next)
    {
      $this->validate($request);

      return $next($request);
    }
  }
