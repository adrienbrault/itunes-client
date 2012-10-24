<?php

$loader = require __DIR__.'/../vendor/autoload.php'; /** @var $loader \Composer\Autoload\ClassLoader */
$loader->add('AdrienBrault\ItunesClient\Tests', __DIR__);

Guzzle\Tests\GuzzleTestCase::setMockBasePath(__DIR__.'/mocks');
Guzzle\Tests\GuzzleTestCase::setServiceBuilder(Guzzle\Service\Builder\ServiceBuilder::factory(array(
    'itunes_client' => array(
        'class' => 'AdrienBrault\ItunesClient\ItunesClient',
        'params' => array(
            'country' => 'us',
        )
    )
)));
