<?php

namespace OC\Cache\Cache;

use OC\Cache\Cache\CacheProvider\CacheProviderFactory;
use OC\Cache\Cache\CacheProvider\CacheProviderType;
use OC\Cache\Cache\Exception\ServerShouldNotBeNullException;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheBuilderImpl implements CacheBuilder
{
    /**
     * @var CacheProviderFactory
     */
    private $cacheProviderFactory;

    /**
     * @var mixed
     */
    private $server;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var string
     */
    private $cacheType;

    /**
     * @var int
     */
    private $defaultLifetime;

    /**
     * @return CacheBuilder
     */
    public function create($cacheType = CacheProviderType::ARRAY_CACHE)
    {
        $this->cacheType = $cacheType;

        return $this;
    }

    /**
     * @return CacheBuilder
     */
    public function withServer($server)
    {
        $this->server = $server;

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
        switch ($this->cacheType) {
            case CacheProviderType::MEMCACHE:
                if (null === $this->server) {
                    throw new ServerShouldNotBeNullException();
                }
                $cacheProvider = $this->cacheProviderFactory->make(
                    CacheProviderType::MEMCACHE,
                    $this->server
                );
                break;
            case CacheProviderType::MEMCACHED:
                if (null === $this->server) {
                    throw new ServerShouldNotBeNullException();
                }
                $cacheProvider = $this->cacheProviderFactory->make(
                    CacheProviderType::MEMCACHED,
                    $this->server
                );
                break;
            case CacheProviderType::REDIS:
                if (null === $this->server) {
                    throw new ServerShouldNotBeNullException();
                }
                $cacheProvider = $this->cacheProviderFactory->make(
                    CacheProviderType::REDIS,
                    $this->server
                );
                break;
            case CacheProviderType::ARRAY_CACHE:
            default:
                $cacheProvider = $this->cacheProviderFactory->make(
                    CacheProviderType::ARRAY_CACHE
                );
                break;
        }
        $this->cache = new CacheImpl($cacheProvider);
        if (null !== $this->defaultLifetime) {
            $this->cache->setDefaultLifetime($this->defaultLifetime);
        }

        return $this->cache;
    }

    public function setCacheProviderFactory(CacheProviderFactory $cacheProviderFactory)
    {
        $this->cacheProviderFactory = $cacheProviderFactory;
    }

}
