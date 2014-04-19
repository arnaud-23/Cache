<?php

namespace OC\Cache\CacheProvider;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\CacheProvider;
use Doctrine\Common\Cache\MemcacheCache;
use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\Common\Cache\RedisCache;
use OC\Cache\CacheProvider\Exception\HostShouldBeProvidedException;
use OC\Cache\CacheProvider\Exception\InvalidCacheProviderTypeException;
use OC\Cache\CacheServer\Redis;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class CacheProviderBuilder
{
    /**
     * @var string
     */
    protected $cacheProviderType;

    /**
     * @var CacheProvider|ArrayCache|MemcacheCache|MemcachedCache|RedisCache
     */
    protected $cacheProvider;

    /**
     * @var \MemCache|\MemCached|\Redis
     */
    protected $server;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var float
     */
    protected $timeout;

    /**
     * @return CacheProviderBuilder
     */
    public function withHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return CacheProviderBuilder
     */
    public function withPort($port)
    {
        if (null !== $port) {
            $this->port = $port;
        }

        return $this;
    }

    /**
     * @return CacheProviderBuilder
     */
    public function withTimeout($timeout)
    {
        if (null !== $timeout) {
            $this->timeout = $timeout;
        }

        return $this;
    }

    /**
     * @return RedisCache
     */
    public function build()
    {
        switch ($this->cacheProviderType) {
            case CacheProviderType::MEMCACHE:
                $this->buildMemcacheCache();
                break;
            case CacheProviderType::MEMCACHED:
                $this->buildMemcachedCache();
                break;
            case CacheProviderType::REDIS:
                $this->buildRedisCache();
                break;
            case CacheProviderType::ARRAY_CACHE:
                break;
            default:
                throw new InvalidCacheProviderTypeException();
        }

        return $this->cacheProvider;
    }

    private function buildMemcacheCache()
    {
        if (null === $this->host) {
            throw new HostShouldBeProvidedException();
        }
        if (null === $this->port) {
            $this->port = 11211;
        }
        $this->server->addserver($this->host, $this->port, null, null, $this->timeout);
        $this->cacheProvider->setMemcache($this->server);
    }

    private function buildMemcachedCache()
    {
        if (null === $this->host) {
            throw new HostShouldBeProvidedException();
        }
        if (null === $this->port) {
            $this->port = 11211;
        }
        $this->server->addserver($this->host, $this->port);
        $this->cacheProvider->setMemcached($this->server);
    }

    private function buildRedisCache()
    {
        if (null === $this->host) {
            throw new HostShouldBeProvidedException();
        }
        if (null === $this->port) {
            $this->port = Redis::DEFAULT_PORT;
        }
        if (null === $this->timeout) {
            $this->timeout = Redis::DEFAULT_TIMEOUT;
        }
        $this->server->connect($this->host, $this->port, $this->timeout);
        $this->cacheProvider->setRedis($this->server);
    }
}
