<?php

  namespace App\Classes\Auth;

  use Illuminate\Http\Request;

  class LogoutUser
  {

    /**
     * Выполнить выход из системы
     *
     * @param Request $request Запрос
     */
    public function execute(Request $request): void
    {
      auth('web')->logout();

      $request->session()->invalidate();

      $request->session()->regenerateToken();
    }
  }
