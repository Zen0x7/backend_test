# Installation

Executes the following command to install the package in your laravel project.

```
composer require spiritsaint/laravel-bacs:dev-master
```

# Requirements

- Laravel 10 or higher
- PHP 8.1 or higher

# Usage

After installation the package will register the `/api/bacs` endpoint. `php artisan serve can be used`

Only `GET` requests are acceptable, `serial_number` and `sun` or `marker` are required params.

For fast payments, use his parameter as true, otherwise you should define the `creation_date` and `expiration_date`.

Creation date can be today or a future day. Expiration date must be after Creation date.

`Accept` header with value `application/json` is mandatory.

# OpenAPI

In order to walk through the API you should view the documentation using [Swagger Editor](https://editor.swagger.io/):

```
openapi: 3.0.0
info:
  title: 'BACS - Swagger Documentation'
  version: 1.0.0
servers:
  - url: http://localhost:8000
paths:
  /api/bacs:
    get:
      operationId: bdfd7b90fc16856aad8db2a99ae14e6f
      parameters:
        -
          name: serial_number
          in: query
          required: true
          schema:
            description: 'Must be a 6 alphanumeric characters.'
            type: string
        -
          name: sun
          in: query
          required: false
          schema:
            description: "Must be a 6 characters if marker isn't defined."
            type: string
        -
          name: marker
          in: query
          required: false
          schema:
            description: "Must be hsbc or sage if sun isn't defined."
            type: string
            enum:
              - hsbc
              - sage
        -
          name: generation_number
          in: query
          required: false
          schema:
            description: 'Must be a number of 4 characters.'
            type: number
        -
          name: generation_version_number
          in: query
          required: false
          schema:
            description: 'Must be a number of 2 characters.'
            type: number
        -
          name: fast_payment
          in: query
          required: false
          schema:
            description: 'Indicates if must be fast payment.'
            type: string
        -
          name: creation_date
          in: query
          required: false
          schema:
            description: "Must be a date in format Y-m-d and explicit defined if fast_payment isn't defined. (ie: 2023-12-03)"
            type: string
        -
          name: expiration_date
          in: query
          required: false
          schema:
            description: "Must be a date in format Y-m-d and explicit defined if fast_payment isn't defined. (ie: 2023-12-03)"
            type: string
        -
          name: Accept
          in: header
          required: true
          schema:
            description: 'Must be application/json'
            type: string
            default: application/json
      responses:
        '200':
          description: Success
          content:
                application/json: {}
```