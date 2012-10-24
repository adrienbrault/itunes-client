<?php

namespace AdrienBrault\ItunesClient\Tests;

use AdrienBrault\ItunesClient\ItunesClient;

class TestCase extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @return ItunesClient
     */
    public function getClient()
    {
        return $this->getServiceBuilder()->get('itunes_client');
    }
}