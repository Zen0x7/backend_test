# Deployment

## 1. Public and private key generation

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
