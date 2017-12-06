<?php

$inputFilepath = __DIR__.'/../doc/swagger/v1-movies-swagger_v2.json';

if (false === file_exists($inputFilepath)) {
    throw new \LogicException(sprintf('File %s does not exist', $inputFilepath));
}

$json = json_decode(file_get_contents($inputFilepath), true);

if ($json['basePath'] === '/') {
    $json['basePath'] = '';
}
if (array('host', $json)) {
    unset($json['host']);
}
$json['info']['title'] = 'Movies API';

$outputFilepath = __DIR__.'/../doc/swagger/v1-movies-swagger_v2-clean.json.json';

file_put_contents($outputFilepath, json_encode($json));

echo "Done" . PHP_EOL;