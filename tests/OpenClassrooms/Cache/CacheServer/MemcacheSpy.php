<?php

namespace OpenClassrooms\Tests\Cache\CacheServer;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class MemcacheSpy extends \Memcache
{
    /**
     * @var string
     */
    public $host;

    /**
     * @var int
     */
    public $port;

    /**
     * @var float
     */
    public $timeout;

    public function addserver ($host, $port = 11211, $persistent = null, $weight = null, $timeout = null, $retry_interval = null, $status = null, callable $failure_callback = null, $timeoutms = null)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;

        return true;
    }

}
