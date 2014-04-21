<?php

namespace OpenClassrooms\Tests\Cache\CacheProvider;

use OpenClassrooms\Cache\CacheProvider\CacheProviderBuilder;
use OpenClassrooms\Cache\CacheProvider\CacheProviderBuilderImpl;
use OpenClassrooms\Cache\CacheProvider\CacheProviderType;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheProviderBuilderTest extends \PHPUnit_Framework_TestCase
{
    const UNKNOWN_PROVIDER_TYPE = 'Unknown type';

    /**
     * @var CacheProviderBuilder
     */
    protected $cacheProviderBuilder;

    /**
     * @test
     * @expectedException \OpenClassrooms\Cache\CacheProvider\Exception\InvalidCacheProviderTypeException
     */
    public function CreateWithUnknownType_ThrowException()
    {
        $this->cacheProviderBuilder->create(self::UNKNOWN_PROVIDER_TYPE);
    }

    /**
     * @test
     */
    public function CreateMemcache_ReturnMemcacheCacheBuilderImpl()
    {
        $builder = $this->cacheProviderBuilder->create(CacheProviderType::MEMCACHE);
        $this->assertAttributeInstanceOf(
            'Doctrine\Common\Cache\MemcacheCache',
            'cacheProvider',
            $builder
        );
        $this->assertAttributeInstanceOf('\Memcache', 'server', $builder);
    }

    /**
     * @test
     */
    public function CreateMemcached_ReturnMemcacheCacheBuilderImpl()
    {
        $builder = $this->cacheProviderBuilder->create(CacheProviderType::MEMCACHED);
        $this->assertAttributeInstanceOf(
            'Doctrine\Common\Cache\MemcachedCache',
            'cacheProvider',
            $builder
        );
        $this->assertAttributeInstanceOf('\Memcached', 'server', $builder);
    }

    /**
     * @test
     */
    public function CreateRedis_ReturnRedisCacheBuilderImpl()
    {
        $builder = $this->cacheProviderBuilder->create(CacheProviderType::REDIS);
        $this->assertAttributeInstanceOf(
            'Doctrine\Common\Cache\RedisCache',
            'cacheProvider',
            $builder
        );
        $this->assertAttributeInstanceOf('\Redis', 'server', $builder);
    }

    /**
     * @test
     */
    public function CreateArrayCache_ReturnArrayCacheBuilderImpl()
    {
        $builder = $this->cacheProviderBuilder->create(CacheProviderType::ARRAY_CACHE);
        $this->assertAttributeInstanceOf(
            'Doctrine\Common\Cache\ArrayCache',
            'cacheProvider',
            $builder
        );
        $this->assertAttributeEmpty('server', $builder);
    }

    protected function setUp()
    {
        $this->cacheProviderBuilder = new CacheProviderBuilderImpl();
    }

}
