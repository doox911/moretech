<?php

  namespace App\Http\Middleware;

  use Closure;
  use Illuminate\Http\Request;

  class AddBearerToken
  {
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

      /**
       * Если отсутствует заголовок Authorization с токеном
       */
      if (!$request->bearerToken()) {

        /**
         * Если переданы Cookie с токеном
         */
        if ($request->hasCookie(env('ACCESS_TOKEN_NAME'))) {
          $token = $request->cookie(env('ACCESS_TOKEN_NAME'));

          /**
           * Добавляем к заголовкам
           */
          $request->headers->add(['Authorization' => 'Bearer ' . $token]);
        }
      }

      return $next($request);
    }
  }
