<?php

namespace AdrienBrault\ItunesClient\Command;

use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Description\Operation;

/**
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class ListGenresCommand extends OperationCommand
{
    /**
     * {@inheritdoc}
     */
    protected function createOperation()
    {
        return new Operation(array(
            'name'       => 'list_genres_command',
            'uri'        => '/WebObjects/MZStoreServices.woa/ws/genres',
            'httpMethod' => 'GET',
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function build()
    {
        parent::build();

        // json responses have the "text/javascript; charset=UTF-8" content type ...
        $this->set('command.expects', 'application/json');
    }
}