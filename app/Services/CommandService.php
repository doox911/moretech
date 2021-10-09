<?php

class CommandService {

  private array $queries;

  public function __construct(array $queries) {
    $this->queries = $queries;
  }

  public function run() {
    // todo тут типа в очередь закидываем запросы на исполнение

    return $this->queries;
  }

  public function applyOperations(array $operations) {
    // todo тут производятся вычисления над данными
  }
}
