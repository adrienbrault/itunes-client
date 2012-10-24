<?php

require __DIR__.'/../vendor/autoload.php';

use AdrienBrault\ItunesClient\ItunesClient;

$client = ItunesClient::factory(array(
    'country' => 'gb',
));

$command = $client->getCommand('lookup_command', array(
    'id' => '343200656,398157641,499511971',
));
$result = $command->execute();

showTitle('Lookup angry birds original+seasons+space in the GB store:');

foreach ($result['results'] as $result) {
    echo $result['trackName'].PHP_EOL;
    echo str_repeat('-', strlen($result['trackName'])).PHP_EOL;
    echo 'Genres: '.join(', ', $result['genres']).PHP_EOL;
    echo 'Price: '.$result['price'].' '.$result['currency'].PHP_EOL;
    echo PHP_EOL;
}

function showTitle($title)
{
    echo $title.PHP_EOL;
    echo str_repeat('=', strlen($title)).PHP_EOL;
    echo PHP_EOL;
}
