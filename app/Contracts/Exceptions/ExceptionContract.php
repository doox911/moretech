<?php

  namespace App\Contracts\Exceptions;

  interface ExceptionContract
  {
    /**
     * Вывод пользовательского сообщения
     *
     * @return string
     */
    public function getUserMessage(): string;

    /**
     * Вывод сообщения предназначенное для администратора
     *
     * @return string
     */
    public function getSystemMessage(): string;

    /**
     * Возвращает пользовательские сообщения
     *
     * @return array
     */
    public function getUserMessages(): array;

    /**
     * Возвращает пользовательские сообщения
     *
     * @return array
     */
    public function getSystemMessages(): array;

    /**
     * Добавляет пользовательское сообщение
     *
     * @param string $message Сообщение
     */
    public function appendUserMessage(string $message): void;

    /**
     * Добавляет сообщение для администратора
     *
     * @param string $message Сообщение
     */
    public function appendSystemMessage(string $message): void;

    /**
     * Добавляет пользовательские сообщения
     *
     * @param array $messages Сообщения
     */
    public function appendUserMessages(array $messages): void;

    /**
     * Добавляет сообщения для администратора
     *
     * @param array $messages Сообщения
     */
    public function appendSystemMessages(array $messages): void;
  }
