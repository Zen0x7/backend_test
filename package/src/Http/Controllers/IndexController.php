<?php

namespace SpiritSaint\LaravelBacs\Http\Controllers;


use SpiritSaint\LaravelBacs\Http\Requests\IndexRequest;
use SpiritSaint\LaravelBacs\Records\HDR1;
use SpiritSaint\LaravelBacs\Records\VOL;

use OpenApi\Attributes as OA;

#[OA\Info(version: "1.0.0", title: "BACS - Swagger Documentation")]
class IndexController
{
    #[OA\Get(path: '/api/bacs', parameters: [
        new OA\Parameter(name: "serial_number", in: "query", required: true, schema: new OA\Schema(
            description: "Must be a 6 alphanumeric characters.",
            type: "string"
        )),
        new OA\Parameter(name: "sun", in: "query", required: false, schema: new OA\Schema(
            description: "Must be a 6 characters if marker isn't defined.",
            type: "string",
        )),
        new OA\Parameter(name: "marker", in: "query", required: false, schema: new OA\Schema(
            description: "Must be hsbc or sage if sun isn't defined.",
            type: "string",
            enum: ["hsbc", "sage"],
        )),
        new OA\Parameter(name: "generation_number", in: "query", required: false, schema: new OA\Schema(
            description: "Must be a number of 4 characters.",
            type: "number",
        )),
        new OA\Parameter(name: "generation_version_number", in: "query", required: false, schema: new OA\Schema(
            description: "Must be a number of 2 characters.",
            type: "number",
        )),
        new OA\Parameter(name: "fast_payment", in: "query", required: false, schema: new OA\Schema(
            description: "Indicates if must be fast payment.",
            type: "string",
        )),
        new OA\Parameter(name: "creation_date", in: "query", required: false, schema: new OA\Schema(
            description: "Must be a date in format Y-m-d and explicit defined if fast_payment isn't defined. (ie: 2023-12-03)",
            type: "string",
        )),
        new OA\Parameter(name: "expiration_date", in: "query", required: false, schema: new OA\Schema(
            description: "Must be a date in format Y-m-d and explicit defined if fast_payment isn't defined. (ie: 2023-12-03)",
            type: "string",
        )),
        new OA\Parameter(name: "Accept", in: "header", required: true, schema: new OA\Schema(
            description: "Must be application/json",
            type: "string",
            default: "application/json"
        )),
    ])]
    #[OA\Response(response: '200', description: 'Success')]
    public function __invoke(IndexRequest $request) {
        $response = [];

        $response["data"]["vol"] = VOL::fromRequest($request);
        $response["data"]["hdr1"] = HDR1::fromRequest($request);

        return response()->json($response);
    }
}