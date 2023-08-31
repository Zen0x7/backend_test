<?php

require("vendor/autoload.php");

$openapi = \OpenApi\Generator::scan(['./app']);

header('Content-Type: application/x-yaml');
echo $openapi->toYaml();
