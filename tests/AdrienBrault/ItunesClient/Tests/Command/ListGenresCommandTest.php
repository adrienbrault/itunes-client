<?php

namespace AdrienBrault\ItunesClient\Tests\Command;

use AdrienBrault\ItunesClient\Tests\TestCase;

class ListGenresCommandTest extends TestCase
{
    public function testUri()
    {
        $client = $this->getClient();

        $command = $client->getCommand('list_genres_command');

        $request = $command->prepare();

        $this->assertEquals('/WebObjects/MZStoreServices.woa/ws/genres', $request->getResource());
    }

    public function testExecute()
    {
        $client = $this->getClient();
        $this->setMockResponse($client, 'genres');

        $command = $client->getCommand('list_genres_command');

        $result = $command->execute();

        $this->assertInternalType('array', $result);
        $this->assertEquals('App Store', $result[36]['name']);
    }
}