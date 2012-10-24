<?php

namespace AdrienBrault\ItunesClient\Tests\Command;

use AdrienBrault\ItunesClient\Tests\TestCase;

class LookupCommandTest extends TestCase
{
    /**
     * @dataProvider getTestUriData
     */
    public function testUri($uri, $parameters)
    {
        $client = $this->getClient();

        $command = $client->getCommand('lookup_command', $parameters);

        $request = $command->prepare();

        $this->assertEquals($uri, $request->getResource());
    }

    public function getTestUriData()
    {
        return array(
            array(
                '/us/lookup',
                array(
                ),
            ),
            array(
                '/us/lookup?id=42',
                array(
                    'id' => 42,
                ),
            ),
        );
    }

    public function testExecute()
    {
        $client = $this->getClient();
        $this->setMockResponse($client, 'lookup');

        $command = $client->getCommand('lookup_command');

        $result = $command->execute();

        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('results', $result);
        $this->assertEquals(1, $result['resultCount']);
    }
}