<?php

namespace OC\Cache\Cache\CacheProvider;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\MemcacheCache;
use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\Common\Cache\RedisCache;
use OC\Cache\CacheProvider\Exception\InvalidCacheProviderTypeException;
use OC\Cache\CacheProvider\Exception\InvalidCacheServerException;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheProviderFactoryImpl implements CacheProviderFactory
{
    /**
     * @return \Doctrine\Common\Cache\CacheProvider
     * @throws InvalidCacheProviderTypeException
     * @throws InvalidCacheServerException
     */
    public function make($cacheProviderType, $server = null)
    {
        switch ($cacheProviderType) {
            case CacheProviderType::MEMCACHE:
                if (!$server instanceof \Memcache) {
                    throw new InvalidCacheServerException();
                }
                $cacheProvider = new MemcacheCache();
                $cacheProvider->setMemcache($server);
                break;
            case CacheProviderType::MEMCACHED:
                if (!$server instanceof \Memcached) {
                    throw new InvalidCacheServerException();
                }
                $cacheProvider = new MemcachedCache();
                $cacheProvider->setMemcached($server);
                break;
            case CacheProviderType::REDIS:
                if (!$server instanceof \Redis) {
                    throw new InvalidCacheServerException();
                }
                $cacheProvider = new RedisCache();
                $cacheProvider->setRedis($server);
                break;
            case CacheProviderType::ARRAY_CACHE:
                $cacheProvider = new ArrayCache();
                break;
            default:
                throw new InvalidCacheProviderTypeException();
        }

        return $cacheProvider;
    }
}
