<?php

namespace OpenClassrooms\Cache\CacheProvider;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
final class CacheProviderType
{
    const ARRAY_CACHE = 'arrayCache';

    const MEMCACHE = 'memcache';

    const MEMCACHED = 'memcached';

    const REDIS = 'redis';

    /** @codeCoverageIgnore */
    private function __construct()
    {
    }

}
