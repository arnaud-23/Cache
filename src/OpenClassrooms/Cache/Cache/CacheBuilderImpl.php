<?php

namespace OpenClassrooms\Cache\Cache;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\CacheProvider;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheBuilderImpl implements CacheBuilder
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var int
     */
    private $defaultLifetime;

    /**
     * @return CacheBuilder
     */
    public function withCacheProvider(CacheProvider $cacheProvider)
    {
        $this->cache = new CacheImpl($cacheProvider);

        return $this;
    }

    /**
     * @return CacheBuilder
     */
    public function withDefaultLifeTime($defaultLifetime)
    {
        $this->defaultLifetime = $defaultLifetime;

        return $this;
    }

    /**
     * @return Cache
     */
    public function build()
    {
        if (null === $this->cache) {
            $this->cache = new CacheImpl(new ArrayCache());
        }

        if (null !== $this->defaultLifetime) {
            $this->cache->setDefaultLifetime($this->defaultLifetime);
        }

        return $this->cache;
    }
}
