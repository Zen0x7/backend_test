# Deployment

## Docker

Invoke up command over the `docker-compose.yml` file for 5 minute checking.

```
cd storage
openssl ecparam -name secp256r1 -genkey -noout -out private_key.pem
openssl ec -in private_key.pem -pubout -out public_key.pem
cd ../
docker compose up -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

### 1. Public and private key generation

We need to jump into the `storage` path in order to generate the JWT signing assets.

```shell
cd storage
```

The first of them is the private key. This process will generate a key with 256 bits length.

```shell
openssl ecparam -name secp256r1 -genkey -noout -out private_key.pem
```

The second is the public key.

```shell
openssl ec -in private_key.pem -pubout -out public_key.pem
```

### 2. Assign corresponding environment values

Copy the example environment variables and open it with an editor.

```shell
cp .env.example .env
nano .env
```

Assign mandatory values.

```shell
PRODUCTION_ENV_UUID=2e58a7ae-4ab6-447c-9f8b-1bbf2ecba054
STAGING_ENV_UUID=70a0cb45-4fec-48c2-a5eb-72e8ac2c1fa5
DEVELOPMENT_ENV_UUID=3994419e-33a0-4191-bdf8-7845a0988fec
```

### 3. Generates application encryption key

Executes the following command in project directory.

```shell
php artisan key:generate
```

### 4. Creates database, user and grant permissions

Executes the following command on a MySQL shell.

```shell
CREATE DATABASE 'buckhill_test';
CREATE USER 'buckhill_test_user'@'localhost' IDENTIFIED BY 'buckhill_test_password';
GRANT ALL PRIVILEGES ON 'buckhill_test'.* TO 'buckhill_test_user'@'localhost';
FLUSH PRIVILEGES;
```

### 5. Migrates database structure and seeds

Executes the following commands in project directory.

```shell
php artisan migrate
php artisan db:seed
```
