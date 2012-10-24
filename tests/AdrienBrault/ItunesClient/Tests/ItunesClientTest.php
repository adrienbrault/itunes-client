<?php

namespace AdrienBrault\ItunesClient\Tests;

class ItunesClientTest extends TestCase
{
    public function testServiceBuilder()
    {
        $client = $this->getServiceBuilder()->get('itunes_client');

        $this->assertInstanceOf('AdrienBrault\ItunesClient\ItunesClient', $client);
    }
}