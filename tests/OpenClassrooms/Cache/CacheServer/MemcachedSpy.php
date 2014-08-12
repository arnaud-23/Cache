<?php

namespace OpenClassrooms\Tests\Cache\CacheServer;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class MemcachedSpy extends \Memcached
{
    /**
     * @var string
     */
    public $host;

    /**
     * @var int
     */
    public $port;

    public function addServer($host, $port, $weight = 0)
    {
        $this->host = $host;
        $this->port = $port;

        return true;
    }

}
