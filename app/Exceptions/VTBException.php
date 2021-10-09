<?php

  namespace App\Exceptions;

  use Exception;
  use Throwable;
  use App\Traits\PrepareResponse;
  use App\Contracts\Exceptions\ExceptionContract;
  use function gettype;
  use Illuminate\Http\JsonResponse;

  class VTBException extends Exception implements ExceptionContract
  {
    use PrepareResponse;

    /**
     * Пользовательское сообщение
     *
     * @var string
     */
    protected string $user_message;

    /**
     * Сообщение для администратора
     *
     * @var string
     */
    protected string $system_message;

    /**
     * Пользовательские сообщения
     *
     * @var array
     */
    protected array $user_messages;

    /**
     * Сообщения для администратора
     *
     * @var array
     */
    protected array $system_messages;

    /**
     * Предыдущее исключение
     *
     * @var Exception|null
     */
    protected ?Exception $previous;

    /**
     * VTBException constructor.
     *
     * @param string $user_message Сообщение предназначенное для пользователя
     * @param string $system_message Сообщение предназначено для администратора
     * @param int $code Код ошибки сервера
     * @param Throwable|null $previous Предыдущее исключение
     */
    public function __construct(string $user_message, string $system_message, int $code = 500, ?Throwable $previous = null)
    {
      $this->user_message = $user_message;
      $this->system_message = $system_message;
      $this->user_messages = [];
      $this->system_messages = [];
      $this->code = $code;
      $this->previous = $previous;

      parent::__construct($this->user_message, $this->code, $this->previous);
    }

    /**
     * Вывод пользовательского сообщения
     *
     * @return string
     */
    final public function getUserMessage(): string
    {
      return $this->user_message;
    }

    /**
     * Вывод сообщения предназначенное для администратора
     *
     * @return string
     */
    final public function getSystemMessage(): string
    {
      return $this->system_message;
    }

    /**
     * Возвращает пользовательские сообщения
     *
     * @return array
     */
    final public function getUserMessages(): array
    {
      return $this->user_messages;
    }

    /**
     * Возвращает пользовательские сообщения
     *
     * @return array
     */
    final public function getSystemMessages(): array
    {
      return $this->system_messages;
    }

    /**
     * Добавляет пользовательское сообщение
     *
     * @param string $message Сообщение
     */
    final public function appendUserMessage(string $message): void
    {
      $this->user_messages[] = $message;
    }

    /**
     * Добавляет сообщение для администратора
     *
     * @param string $message Сообщение
     */
    final public function appendSystemMessage(string $message): void
    {
      $this->system_messages[] = $message;
    }

    /**
     * Добавляет пользовательские сообщения
     *
     * @param array $messages Сообщения
     */
    final public function appendUserMessages(array $messages): void
    {
      foreach ($messages as $message) {
        if (gettype($message === 'string')) {
          $this->user_messages[] = $message;
        }
      }
    }

    /**
     * Добавляет сообщения для администратора
     *
     * @param array $messages Сообщения
     */
    final public function appendSystemMessages(array $messages): void
    {
      foreach ($messages as $message) {
        if (gettype($message === 'string')) {
          $this->system_messages[] = $message;
        }
      }
    }

    /**
     * Отправить сообщения
     *
     * @return JsonResponse
     */
    public function responseMessages(): JsonResponse {
      $user_messages = [...$this->user_messages, $this->user_message];

      $system_messages = [
        'system_messages' => [...$this->system_messages, $this->system_message],
      ];

      return $this->prepareResponse($system_messages, $user_messages, $this->code);
    }

    /**
     * Вывод исключения
     */
    public function render() {
      return $this->responseMessages();
    }
  }
