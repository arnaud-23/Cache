<?php

namespace OC\Tests\Cache\Cache;

use OC\Cache\Cache\CacheBuilder;
use OC\Cache\Cache\CacheBuilderImpl;
use OC\Cache\Cache\CacheProvider\CacheProviderFactoryImpl;
use OC\Cache\Cache\CacheProvider\CacheProviderType;
use OC\Tests\Cache\CacheProvider\MemcachedStub;
use OC\Tests\Cache\CacheProvider\MemcacheStub;
use OC\Tests\Cache\CacheProvider\RedisStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheBuilderImplTest extends \PHPUnit_Framework_TestCase
{
    const EXPECTED_DEFAULT_LIFETIME = 1000;

    /**
     * @var CacheBuilder
     */
    private $cacheBuilder;

    /**
     * @test
     */
    public function WithoutType_Build_ReturnArrayCache()
    {
        $cache = $this->cacheBuilder
            ->create()
            ->build();
        $this->assertAttributeInstanceOf('Doctrine\Common\Cache\ArrayCache', 'cache', $cache);
    }

    /**
     * @test
     */
    public function WithArrayCacheType_Build_ReturnArrayCache()
    {
        $cache = $this->cacheBuilder
            ->create(CacheProviderType::ARRAY_CACHE)
            ->build();
        $this->assertAttributeInstanceOf('Doctrine\Common\Cache\ArrayCache', 'cache', $cache);
    }

    /**
     * @test
     * @expectedException \OC\Cache\Cache\Exception\ServerShouldNotBeNullException
     */
    public function WithMemcacheTypeWithoutServer_Build_ThrowException()
    {
        $this->cacheBuilder
            ->create(CacheProviderType::MEMCACHE)
            ->build();
    }

    /**
     * @test
     */
    public function WithMemcacheType_Build_ReturnMemcache()
    {
        $cache = $this->cacheBuilder
            ->create(CacheProviderType::MEMCACHE)
            ->withServer(new MemcacheStub())
            ->build();
        $this->assertAttributeInstanceOf('Doctrine\Common\Cache\MemcacheCache', 'cache', $cache);
    }

    /**
     * @test
     * @expectedException \OC\Cache\Cache\Exception\ServerShouldNotBeNullException
     */
    public function WithMemcachedTypeWithoutServer_Build_ThrowException()
    {
        $this->cacheBuilder
            ->create(CacheProviderType::MEMCACHED)
            ->build();
    }

    /**
     * @test
     */
    public function WithMemcachedType_Build_ReturnMemcached()
    {
        $cache = $this->cacheBuilder
            ->create(CacheProviderType::MEMCACHED)
            ->withServer(new MemcachedStub())
            ->build();
        $this->assertAttributeInstanceOf('Doctrine\Common\Cache\MemcachedCache', 'cache', $cache);
    }

    /**
     * @test
     * @expectedException \OC\Cache\Cache\Exception\ServerShouldNotBeNullException
     */
    public function WithRedisTypeWithoutServer_Build_ThrowException()
    {
        $this->cacheBuilder
            ->create(CacheProviderType::REDIS)
            ->build();
    }

    /**
     * @test
     */
    public function WithRedisType_Build_ReturnRedis()
    {
        $cache = $this->cacheBuilder
            ->create(CacheProviderType::REDIS)
            ->withServer(new RedisStub())
            ->build();
        $this->assertAttributeInstanceOf('Doctrine\Common\Cache\RedisCache', 'cache', $cache);
    }

    /**
     * @test
     */
    public function WithDefaultLifetime_Make_ReturnDefaultLifetime()
    {
        $cache = $this->cacheBuilder
            ->create(CacheProviderType::ARRAY_CACHE)
            ->withDefaultLifeTime(self::EXPECTED_DEFAULT_LIFETIME)
            ->build();
        $this->assertAttributeEquals(self::EXPECTED_DEFAULT_LIFETIME, 'defaultLifetime', $cache);
    }

    protected function setUp()
    {
        $this->cacheBuilder = new CacheBuilderImpl();
        $this->cacheBuilder->setCacheProviderFactory(new CacheProviderFactoryImpl());
    }
}
