cd storage
openssl ecparam -name secp256r1 -genkey -noout -out private_key.pem
openssl ec -in private_key.pem -pubout -out public_key.pem
cd ../
docker compose up -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
