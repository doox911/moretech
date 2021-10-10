<?php

  namespace App\Http\Controllers\Api\V1;

  use App\Models\User;
  use Illuminate\Http\Request;
  use App\Classes\Auth\LoginUser;
  use App\Classes\Auth\LogoutUser;
  use Illuminate\Http\JsonResponse;
  use App\Exceptions\VTBException;
  use App\Http\Controllers\Controller;
  use Illuminate\Support\Facades\Auth;

  class AuthController extends Controller
  {

    /**
     * Регистрация пользователя в системе
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
      $data = $request->all();

      $data['password'] = bcrypt($request->password);

      return $this->prepareResponse(['user' => User::create($data)], ['Успешная регистрация']);
    }

    /**
     * Вход в систему
     *
     * @param Request $request Запрос
     * @param LoginUser $action Клас авторизации пользователя
     * @return JsonResponse
     * @throws VTBException
     */
    public function login(Request $request): JsonResponse
    {
//      dd($request->user(), User::where('email', $request->email)->first());
      Auth::login( User::where('email', $request->email)->first());
//      if (Auth::login($request->all(), true)) {
//        throw new VTBException('Ошибка авторизации', 'Unauthorized', 401);
//      }

      $request->session()->regenerate();

      $user = $request->user()->load(([
        'roles.permissions',
        'permissions'
      ]));

      /**
       * Пока нет чёткого понимания,как мы будем использовать роли.
       * Одно или несколько.
       *
       * @TODO Аналогичный фикс лежит в UserRepository->getUserWithRights
       */
      if ($user) {
        $user->role = $user->roles->first();

        unset($user->roles);
      }

      return $this->prepareResponse(['user' => $user]);
    }

    /**
     * Выход из системы
     *
     * @param Request $request Запрос
     * @param LogoutUser $action Класс выхода пользователя из системы
     * @return JsonResponse
     */
    public function logout(Request $request, LogoutUser $action): JsonResponse
    {
      $action->execute($request);

      return $this->prepareResponse([], ['Выход из системы успешно выполнен']);
    }
  }
