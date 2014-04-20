<?php

namespace OpenClassrooms\Cache\CacheProvider;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\MemcacheCache;
use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\Common\Cache\RedisCache;
use OpenClassrooms\Cache\CacheProvider\Exception\InvalidCacheProviderTypeException;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheProviderBuilderImpl extends CacheProviderBuilder
{
    protected function __construct($cacheProviderType)
    {
        $this->cacheProviderType = $cacheProviderType;
        switch ($this->cacheProviderType) {
            case CacheProviderType::MEMCACHE:
                $this->cacheProvider = new MemcacheCache();
                $this->server = new \Memcache();
                break;
            case CacheProviderType::MEMCACHED:
                $this->cacheProvider = new MemcachedCache();
                $this->server = new \Memcached();
                break;
            case CacheProviderType::REDIS:
                $this->cacheProvider = new RedisCache();
                $this->server = new \Redis();
                break;
            case CacheProviderType::ARRAY_CACHE:
                $this->cacheProvider = new ArrayCache();
                break;
            default:
                throw new InvalidCacheProviderTypeException();
        }
    }

    /**
     * @return CacheProviderBuilderImpl
     */
    public static function create($cacheProviderType)
    {
        return new CacheProviderBuilderImpl($cacheProviderType);
    }
}
