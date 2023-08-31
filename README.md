# Deployment

> If you have `openssl`, `docker` and ports `80`, `443` and `3306` are available then use `deployment.sh` to start.

## Setup

In order to implement asymmetric token encryption you'll need to provide public and private keys. Execute the following command to generate both into storage path.

```shell
cd storage
openssl ecparam -name secp256r1 -genkey -noout -out private_key.pem
openssl ec -in private_key.pem -pubout -out public_key.pem
```

## Compose

Use Docker to run this project on your local machine.

```
docker compose up -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

## Usage

By running `composing commands` you'll have the application running over port `80`.

The database server will be using port `3306`, default credentials are `buckhill` and `secret_password` and database name is `buckhill`.

As required, once seeds, default admin credentials are `admin@buckhill.co.uk` and `admin`.

OpenApi specification can be viewed by reaching the endpoint `/api/documentation`.

## Testing and insights

```
docker compose exec app php artisan test
docker compose exec app php artisan insights
```

## Score

|  Code   | Complexity  |  Architecture  |  Style  |
|:-------:|:-----------:|:--------------:|:-------:|
|  94.4%  |    85.7%    |     87.5%      |  90.9%  |

You can verify the result based on [last running action logs](https://github.com/SpiritSaint/backend_test/actions).

## Coding

[API Prefix](https://github.com/SpiritSaint/backend_test/issues/5), [Bearer Token Authentication](https://github.com/SpiritSaint/backend_test/issues/6), [Middleware Protection](https://github.com/SpiritSaint/backend_test/issues/7) and [Admin endpoint](https://github.com/SpiritSaint/backend_test/issues/8) are fully implemented features. 
