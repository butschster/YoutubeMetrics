# Сервис сбора статистики.

Данный сервис производит сбор статистики youtube каналов и комментарии к ним.

Также сервиc позволяет определять комментарии ботов на основе информации от [https://kremlebot.rip/](MetaBot) и производить ручную модерацию каналов, с которых были написаны комментарии.

Сбор информации произваодится через Youtube API и позволяет использовать неограниченное кол-во ключей и балансировать запросы между ними для увеличения лимита запросов. При достижении лимита для ключа, он автоматически блокируется до следующего расчетного периода. При блокировке всех ключей, API запросы перестают выполняться, до тех пор, пока не наступит следующий расчетный период (Pacific time)

## Используемые инструменты

- NuxtJs (Vue JS SPA) + JWT Auth 
- Laravel 5.6
- Mongo DB Для хранения статистики просмотров
- MySQL
- Redis (Кеш, Сервис очередей)
- Sentry логирование
- Cron jobs

## Консольные команды

### Слежение за каналов

`$ php artisan channel:follow {channel}`

`$ php artisan channel:unfollow {channel}`

### Регистрация нового пользователя

`$ php artisan user:register`

### Модерация

`$ php artisan user:grant-moderator {email}`

`$ php artisan user:revoke-moderator {email}`

### Youtube API

Регистрация нового API ключа

`$ php artisan youtube:register-api-key {key}`

Удаление API ключа

`$ php artisan youtube:remove-api-key {key}`

Список ключей, которые используюся для получения данных (Активные)

`$ php artisan youtube:keys-active`

### Системные

Создание файлов локализации для JS в json формате

`$ php artisan locales:javascript`

Генерация api routes для JS. Испольщуется для выполнения API запросов в nuxt

`$ php artisan route:javascript`


## Запуск приложения
Данное приложение использует сервис очередей для выполнения и обработки запросов и может быть развернуто на нескольких серверах. 

- Frontend
- Workers
- Cron
- Database
- Queue server
- Cache server

Для развертывания приложения можно использовать [Deployer](https://deployer.org/). Для этого необходимо в файле `~/.ssh/config` указать адреса серверов `youtube-metrics` и `youtube-metrics-workers` и затем из корневой директории приложения выполнить консольную команду `$ dep depoly`

## Настройка сервера

Для развертывания LEMP стека можно воспользоваться инструкцией https://gist.github.com/butschster/48d33bd1e3a8192ca4059d8e6a459118
