<?php

namespace OC\Tests\Cache\CacheProvider;

use Doctrine\Common\Cache\RedisCache;
use OC\Cache\CacheProvider\CacheProviderBuilder;
use OC\Cache\CacheProvider\CacheProviderBuilderImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class RedisCacheBuilderStub extends CacheProviderBuilderImpl
{
    protected function __construct($cacheProviderType)
    {
        parent::__construct($cacheProviderType);
        $this->cacheProvider = new RedisCache();
        $this->server = new RedisSpy();
    }

    /**
     * @return CacheProviderBuilder
     */
    public static function create($cacheProviderType)
    {
        return new RedisCacheBuilderStub($cacheProviderType);
    }
}
