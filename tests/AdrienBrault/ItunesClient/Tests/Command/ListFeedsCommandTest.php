<?php

namespace AdrienBrault\ItunesClient\Tests\Command;

use AdrienBrault\ItunesClient\Tests\TestCase;

class ListFeedsCommandTest extends TestCase
{
    public function testUri()
    {
        $client = $this->getClient();

        $command = $client->getCommand('list_feeds_command');

        $request = $command->prepare();

        $this->assertEquals('/WebObjects/MZStoreServices.woa/wa/RSS/wsAvailableFeeds?cc=us', $request->getResource());
    }

    public function testExecute()
    {
        $client = $this->getClient();
        $this->setMockResponse($client, 'available_feeds_us');

        $command = $client->getCommand('list_feeds_command');

        $result = $command->execute();

        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('list', $result);
    }
}