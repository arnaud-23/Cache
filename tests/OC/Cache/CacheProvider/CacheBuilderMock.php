<?php

namespace OC\Tests\Cache\CacheProvider;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\MemcacheCache;
use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\Common\Cache\RedisCache;
use OC\Cache\CacheProvider\CacheProviderBuilder;
use OC\Cache\CacheProvider\CacheProviderBuilderImpl;
use OC\Cache\CacheProvider\CacheProviderType;
use OC\Cache\CacheProvider\Exception\InvalidCacheProviderTypeException;
use OC\Tests\Cache\CacheServer\MemcachedSpy;
use OC\Tests\Cache\CacheServer\MemcacheSpy;
use OC\Tests\Cache\CacheServer\RedisSpy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheBuilderMock extends CacheProviderBuilderImpl
{
    protected function __construct($cacheProviderType)
    {
        $this->cacheProviderType = $cacheProviderType;
        switch ($this->cacheProviderType) {
            case CacheProviderType::MEMCACHE:
                $this->cacheProvider = new MemcacheCache();
                $this->server = new MemcacheSpy();
                break;
            case CacheProviderType::MEMCACHED:
                $this->cacheProvider = new MemcachedCache();
                $this->server = new MemcachedSpy();
                break;
            case CacheProviderType::REDIS:
                $this->cacheProvider = new RedisCache();
                $this->server = new RedisSpy();
                break;
            case CacheProviderType::ARRAY_CACHE:
                $this->cacheProvider = new ArrayCache();
                break;
            default:
                throw new InvalidCacheProviderTypeException();
        }
    }

    /**
     * @return CacheProviderBuilder
     */
    public static function create($cacheProviderType)
    {
        return new CacheBuilderMock($cacheProviderType);
    }
}
