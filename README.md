# Требования
## Вариант 1
 - docker && docker-compose;
 - NodeJs, npm (версия 7.0+) или NVM;
## Вариант 2
 - web-сервер с поддержкой PHP(версия 8.0+) интерпретации (apache, nginx);
 - composer (версия 2.0+);
 - NodeJs, npm (версия 7.0+) или NVM;

# Инструкция по установке

### Linux(Дебиан семейства) и Mac

> ВНИМАНИЕ! Необходимо верно установить привилегии.

 - cd /var/www && git clone https://github.com/doox911/moretech.git && cd moretech/
 - ``` 
   docker run --rm --interactive --tty \
   --volume $PWD:/app \
   composer install
   ```
 - `cd frontend`
 - `npm install`
 - `npm run build`
 - `cd .. && cp .env.example .env`
 - `./vendor/bin/sail up`

*Приложение будет доступно на http://0.0.0.0*

*Ngrok(временный) http://78b3-185-9-75-238.ngrok.io/*
