# This is a service for collection youtube metrics and comments for following channels

Metrics collect by Youtube API. You can use unlimited amount of api kys and can balance api requests between them for increasing requests limits. If one of keys reached limits it will blocks untill next period. If all keys are blocked then metrics collecting will be stopped untill next period.

## Used tools

- NuxtJs (Vue JS SPA) + JWT Auth 
- Laravel 5.6
- Mongo DB for collecting Youtube Metrics
- MySQL
- Redis (Cache, Queues)
- Sentry for logs
- Cron jobs

## Console commands

### Channel folowing

`$ php artisan channel:follow {channel}`

`$ php artisan channel:unfollow {channel}`

### Register a new user

`$ php artisan user:register`

### Moderation rights

`$ php artisan user:grant-moderator {email}`

`$ php artisan user:revoke-moderator {email}`

### Youtube API

Registering a new api key

`$ php artisan youtube:register-api-key {key}`

Removing existing API key

`$ php artisan youtube:remove-api-key {key}`

Get list of API keys (only active keys)

`$ php artisan youtube:keys-active`

### System

Create locale JS files
`$ php artisan locales:javascript`

Generate API routes for javascript. Uses for API requests from NuxtJS
`$ php artisan route:javascript`

## Installation
This application uses queues for runing and handling request and can be deployed on several servers.

- Frontend server with NuxtJS
- Workers
- Cron
- Database (MySQL)
- Queue server (Redis)
- Cache server (Redis)

You can deploy this project by using [Deployer](https://deployer.org/).
`$ dep depoly`

## Server configuration
https://gist.github.com/butschster/48d33bd1e3a8192ca4059d8e6a459118
