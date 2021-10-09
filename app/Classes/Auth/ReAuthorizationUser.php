<?php

  namespace App\Classes\Auth;

  use Illuminate\Http\Request;
  use App\Exceptions\VTBException;

  class ReAuthorizationUser
  {

    /**
     * Класс авторизации пользователя
     *
     * @var LoginUser
     */
    protected LoginUser $login;

    /**
     * Класс авторизации пользователя
     *
     * @var LogoutUser
     */
    protected LogoutUser $logout;

    public function __construct(LoginUser $login, LogoutUser $logout)
    {
      $this->login = $login;
      $this->logout = $logout;
    }

    /**
     * Выход из системы
     *
     * @param Request $request Запрос
     * @throws VTBException
     */
    public function execute(Request $request): void
    {
      $this->logout->execute($request);

      $this->login->execute($request);
    }
  }
