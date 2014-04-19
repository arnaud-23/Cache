<?php

namespace OC\Cache\Cache;

use OC\Cache\Cache\CacheProvider\CacheProviderType;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface CacheBuilder
{
    /**
     * @return CacheBuilder
     */
    public function create($cacheType = CacheProviderType::ARRAY_CACHE);

    /**
     * @return CacheBuilder
     */
    public function withServer($server);

    /**
     * @return CacheBuilder
     */
    public function withDefaultLifeTime($defaultLifetime);

    /**
     * @return Cache
     */
    public function build();
}
