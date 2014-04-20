<?php

namespace OpenClassrooms\Cache\Cache;

use Doctrine\Common\Cache\CacheProvider;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface CacheBuilder
{
    /**
     * @return CacheBuilder
     */
    public static function create();

    /**
     * @return CacheBuilder
     */
    public function withCacheProvider(CacheProvider $cacheProvider);

    /**
     * @return CacheBuilder
     */
    public function withDefaultLifeTime($defaultLifetime);

    /**
     * @return Cache
     */
    public function build();
}
