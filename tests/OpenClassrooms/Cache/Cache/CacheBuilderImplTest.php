<?php

namespace OpenClassrooms\Tests\Cache\Cache;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\MemcacheCache;
use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\Common\Cache\RedisCache;
use OpenClassrooms\Cache\Cache\CacheBuilderImpl;
use OpenClassrooms\Tests\Cache\CacheServer\MemcachedSpy;
use OpenClassrooms\Tests\Cache\CacheServer\MemcacheSpy;
use OpenClassrooms\Tests\Cache\CacheServer\RedisSpy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheBuilderImplTest extends \PHPUnit_Framework_TestCase
{
    const EXPECTED_DEFAULT_LIFETIME = 1000;

    /**
     * @test
     */
    public function WithoutType_Build_ReturnArrayCache()
    {
        $cache = CacheBuilderImpl::create()
            ->build();
        $this->assertAttributeInstanceOf('Doctrine\Common\Cache\ArrayCache', 'cache', $cache);
    }

    /**
     * @test
     */
    public function WithArrayCacheType_Build_ReturnArrayCache()
    {
        $cache = CacheBuilderImpl::create()
            ->withCacheProvider(new ArrayCache())
            ->build();
        $this->assertAttributeInstanceOf('Doctrine\Common\Cache\ArrayCache', 'cache', $cache);
    }

    /**
     * @test
     */
    public function WithMemcacheType_Build_ReturnMemcache()
    {
        $memcacheCache = new MemcacheCache();
        $memcacheCache->setMemcache(new MemcacheSpy());

        $cache = CacheBuilderImpl::create()
            ->withCacheProvider($memcacheCache)
            ->build();
        $this->assertAttributeInstanceOf('Doctrine\Common\Cache\MemcacheCache', 'cache', $cache);
    }

    /**
     * @test
     */
    public function WithMemcachedType_Build_ReturnMemcached()
    {
        $memcachedCache = new MemcachedCache();
        $memcachedCache->setMemcached(new MemcachedSpy());

        $cache = CacheBuilderImpl::create()
            ->withCacheProvider($memcachedCache)
            ->build();
        $this->assertAttributeInstanceOf('Doctrine\Common\Cache\MemcachedCache', 'cache', $cache);
    }

    /**
     * @test
     */
    public function WithRedisType_Build_ReturnRedis()
    {
        $redisCache = new RedisCache();
        $redisCache->setRedis(new RedisSpy());
        $cache = CacheBuilderImpl::create()
            ->withCacheProvider($redisCache)
            ->build();
        $this->assertAttributeInstanceOf('Doctrine\Common\Cache\RedisCache', 'cache', $cache);
    }

    /**
     * @test
     */
    public function WithDefaultLifetime_Make_ReturnDefaultLifetime()
    {
        $cache = CacheBuilderImpl::create()
            ->withDefaultLifeTime(self::EXPECTED_DEFAULT_LIFETIME)
            ->build();
        $this->assertAttributeEquals(self::EXPECTED_DEFAULT_LIFETIME, 'defaultLifetime', $cache);
    }
}
