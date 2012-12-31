<?php

namespace AdrienBrault\ItunesClient\Command;

use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Description\Operation;
use Guzzle\Service\Command\ResponseParserInterface;

/**
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * Look at the source code of @link http://itunes.apple.com/rss
 */
class ListFeedsCommand extends OperationCommand implements ResponseParserInterface
{
    /**
     * {@inheritdoc}
     */
    protected function init()
    {
        $this->setResponseParser($this);
    }

    /**
     * {@inheritdoc}
     */
    protected function createOperation()
    {
        return new Operation(array(
            'name'       => 'available_feeds_command',
            'uri'        => '/WebObjects/MZStoreServices.woa/wa/RSS/wsAvailableFeeds?cc={country}',
            'httpMethod' => 'GET',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function parse(CommandInterface $command)
    {
        $content = $command->getRequest()->getResponse()->getBody(true);

        return json_decode(preg_replace('/^availableFeeds=/', '', $content), true);
    }
}
