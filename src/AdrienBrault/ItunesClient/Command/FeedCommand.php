<?php

namespace AdrienBrault\ItunesClient\Command;

use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Description\Operation;

/**
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @link http://itunes.apple.com/rss?cc=EN
 */
class FeedCommand extends OperationCommand
{
    /**
     * {@inheritdoc}
     */
    protected function createOperation()
    {
        return new Operation(array(
            'name'       => 'feed_command',
            'uri'        => 'rss/{feed_type}{media_type}/limit={size}{+genre}/{format}',
            'httpMethod' => 'GET',
            'parameters' => array(
                'media_type' => array(
                    'type'     => 'string',
                    'required' => true,
                    'location' => 'uri',
                ),
                'feed_type' => array(
                    'type'     => 'string',
                    'required' => true,
                    'location' => 'uri',
                ),
                'size' => array(
                    'type'     => 'integer',
                    'default'  => 100,
                    'required' => true,
                    'location' => 'uri',
                ),
                'genre' => array(
                    'type'     => 'integer',
                    'required' => false,
                    'location' => 'uri',
                    'filters'  => array(function ($data) {
                            return '/genre='.$data;
                        }
                    ),
                ),
                'format' => array(
                    'type'     => 'string',
                    'required' => true,
                    'default'  => 'json',
                    'location' => 'uri',
                    'pattern'  => '/^json|xml$/',
                ),
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function build()
    {
        parent::build();

        // json responses have the "text/javascript; charset=UTF-8" content type ...
        if ('json' === $this->get('format')) {
            $this->set('command.expects', 'application/json');
        }
    }
}