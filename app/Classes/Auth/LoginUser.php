<?php

  namespace App\Classes\Auth;

  use Illuminate\Http\Request;
  use App\Exceptions\VTBException;

  class LoginUser
  {

    /**
     * Выполнить вход в систему
     *
     * @param Request $request Запрос
     * @throws VTBException
     */
    public function execute(Request $request): void
    {
      if (!auth('web')->attempt($request->all(), true)) {
        throw new VTBException('Ошибка авторизации', 'Unauthorized', 401);
      }

      $request->session()->regenerate();
    }
  }
