<?php

namespace OpenClassrooms\Cache\CacheServer;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
final class Memcache
{
    const DEFAULT_PORT = 11211;

    const DEFAULT_TIMEOUT = 1;

    /** @codeCoverageIgnore */
    private function __construct()
    {
    }

}
