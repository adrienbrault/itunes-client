<?php

namespace AdrienBrault\ItunesClient\Tests\Command;

use AdrienBrault\ItunesClient\Tests\TestCase;

class FeedCommandTest extends TestCase
{
    /**
     * @expectedException Guzzle\Service\Exception\ValidationException
     */
    public function testInvalidParameters()
    {
        $client = $this->getClient();

        $command = $client->getCommand('feed_command');
        $this->assertInstanceOf('AdrienBrault\ItunesClient\Command\FeedCommand', $command);

        $request = $command->prepare();
    }

    /**
     * @dataProvider getTestUriData
     */
    public function testUri($uri, $parameters)
    {
        $client = $this->getClient();

        $command = $client->getCommand('feed_command', $parameters);

        $request = $command->prepare();

        $this->assertEquals($uri, $request->getResource());
    }

    public function getTestUriData()
    {
        return array(
            array(
                '/us/rss/topfreeapplications/limit=100/json',
                array(
                    'type' => 'topfreeapplications',
                ),
            ),
            array(
                '/us/rss/topfreeapplications/limit=100/genre=6014/json',
                array(
                    'type'  => 'topfreeapplications',
                    'genre' => 6014,
                ),
            ),
        );
    }

    public function testExecuteJson()
    {
        $client = $this->getClient();
        $this->setMockResponse($client, 'us_rss_topfreeapplications_limit10_json');

        $command = $client->getCommand('feed_command', array(
            'type'       => 'topfreeapplications',
            'size'       => 10,
            'format'     => 'json',
        ));

        $result = $command->execute();

        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('feed', $result);
    }

    public function testExecuteXml()
    {
        $client = $this->getClient();
        $this->setMockResponse($client, 'us_rss_topfreeapplications_limit10_xml');

        $command = $client->getCommand('feed_command', array(
            'type' => 'topfreeapplications',
            'size'       => 10,
            'format'     => 'xml',
        ));

        $result = $command->execute();

        $this->assertInstanceOf('SimpleXMLElement', $result);
    }
}