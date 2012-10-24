<?php

namespace AdrienBrault\ItunesClient\Command;

use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Description\Operation;

/**
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @link http://www.apple.com/itunes/affiliates/resources/documentation/itunes-store-web-service-search-api.html
 */
class LookupCommand extends OperationCommand
{
    /**
     * {@inheritdoc}
     */
    protected function createOperation()
    {
        $parametersName = array('id', 'entity', 'sort', 'amgArtistId', 'amgAlbumId', 'amgVideoId', 'upc', 'isbn');
        $parameters = array();
        foreach ($parametersName as $parameterName) {
            $parameters[$parameterName] = array(
                'required' => false,
                'type' => 'string', // Because for ids, it can either be "34" or "45,98,45"
                'location' => 'uri',
            );
        }

        return new Operation(array(
            'name'       => 'lookup_command',
            'uri'        => 'lookup{?limit,'.join(',', $parametersName).'}',
            'httpMethod' => 'GET',
            'parameters' => array_merge($parameters, array(
                'limit' => array(
                    'required' => false,
                    'type' => 'integer',
                    'location' => 'uri',
                ),
            )),
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