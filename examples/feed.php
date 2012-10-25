<?php

require __DIR__.'/../vendor/autoload.php';

use AdrienBrault\ItunesClient\ItunesClient;

$client = ItunesClient::factory(array(
    'country' => 'us',
));

$command = $client->getCommand('feed_command', array(
    'type'   => 'toppaidapplications',
    'format' => 'json',
    'size'   => 10,
));
$result = $command->execute();

showTitle('Top 10 paid ios application in the US:');

foreach ($result['feed']['entry'] as $entry) {
    echo '- '.$entry['title']['label'].PHP_EOL;
}

function showTitle($title)
{
    echo $title.PHP_EOL;
    echo str_repeat('=', strlen($title)).PHP_EOL;
    echo PHP_EOL;
}
