<?php

  namespace App\Traits;

  use Illuminate\Http\JsonResponse;

  trait PrepareResponse
  {

    /**
     * Стандарт ответа приложения
     *
     * @param array $payload Данные
     * @param array $messages Сообщение
     * @param int $code Код ответа
     * @return JsonResponse
     */
    public function prepareResponse(array $payload = [], array $messages = [], int $code = 200): JsonResponse
    {
      return response()->json([
        'payload' => $payload,
        'messages' => $messages,
      ], $code);
    }

  }
