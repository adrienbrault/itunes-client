<?php

namespace AdrienBrault\ItunesClient;

use Guzzle\Service\Client;
use Guzzle\Common\Collection;

/**
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class ItunesClient extends Client
{
    /**
     * {@inheritdoc}
     *
     * @return self
     */
    public static function factory($config = array())
    {
        $default = array(
            'base_url' => '{scheme}://itunes.apple.com/{country}/',
            'scheme'   => 'https',
        );
        $required = array('country');
        $config = Collection::fromConfig($config, $default, $required);

        $client = new static($config->get('base_url'), $config);

        return $client;
    }
}
