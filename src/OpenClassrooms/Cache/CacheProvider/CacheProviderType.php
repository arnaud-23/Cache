<?php

namespace OpenClassrooms\Cache\CacheProvider;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
final class CacheProviderType
{
    const ARRAY_CACHE = 'ArrayCache';

    const MEMCACHE = 'Memcache';

    const MEMCACHED = 'Memcached';

    const REDIS = 'Redis';

    /** @codeCoverageIgnore */
    private function __construct()
    {
    }

}
