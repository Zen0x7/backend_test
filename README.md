# Deployment

> If you have `openssl`, `docker` and ports `80`, `443` and `3306` are available then use `deployment.sh` for fast checking purposes.

## Setup

In order to implement asymmetric encryption you'll need to provide public and private keys. Execute the following command to generate both into storage path.

```shell
cd storage
openssl ecparam -name secp256r1 -genkey -noout -out private_key.pem
openssl ec -in private_key.pem -pubout -out public_key.pem
```

## Composing

Use Docker to implement this project on your local machine.

```
docker compose up -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

## Testing and insights

```
docker compose exec app php artisan test
docker compose exec app php artisan insights
```
