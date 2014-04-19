<?php

namespace OC\Tests\Cache\CacheProvider;

use Doctrine\Common\Cache\CacheProvider;
use OC\Cache\CacheProvider\CacheProviderFactory;
use OC\Cache\CacheProvider\CacheProviderFactoryImpl;
use OC\Cache\CacheProvider\CacheProviderType;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheProviderFactoryImplTest extends \PHPUnit_Framework_TestCase
{
    const ARRAY_CACHE_CLASS = 'Doctrine\Common\Cache\ArrayCache';

    const MEMCACHE_CLASS = 'Doctrine\Common\Cache\MemcacheCache';

    const MEMCACHED_CLASS = 'Doctrine\Common\Cache\MemcachedCache';

    const REDIS_CLASS = 'Doctrine\Common\Cache\RedisCache';

    const INVALID_CACHE_PROVIDER_TYPE = 'Invalid Cache Provider Type';

    /**
     * @var CacheProviderFactory
     */
    private $cacheProviderFactory;

    /**
     * @var CacheProvider
     */
    private $cacheProvider;

    /**
     * @test
     * @expectedException \OC\Cache\CacheProvider\Exception\InvalidCacheProviderTypeException
     */
    public function InvalidCacheProviderType_Make_ThrowException()
    {
        $this->cacheProvider = $this->cacheProviderFactory->make(self::INVALID_CACHE_PROVIDER_TYPE);
    }

    /**
     * @test
     * @expectedException \OC\Cache\CacheProvider\Exception\InvalidCacheServerException
     */
    public function MemcacheWrongServer_Make_ThrowException()
    {
        $this->cacheProvider = $this->cacheProviderFactory->make(CacheProviderType::MEMCACHE);
    }

    /**
     * @test
     * @expectedException \OC\Cache\CacheProvider\Exception\InvalidCacheServerException
     */
    public function MemcachedWrongServer_Make_ThrowException()
    {
        $this->cacheProvider = $this->cacheProviderFactory->make(CacheProviderType::MEMCACHED);
    }

    /**
     * @test
     * @expectedException \OC\Cache\CacheProvider\Exception\InvalidCacheServerException
     */
    public function RedisWrongServer_Make_ThrowException()
    {
        $this->cacheProvider = $this->cacheProviderFactory->make(CacheProviderType::REDIS);
    }

    /**
     * @test
     */
    public function ArrayCache_Make_ReturnArrayCache()
    {
        $this->cacheProvider = $this->cacheProviderFactory->make(CacheProviderType::ARRAY_CACHE);
        $this->assertInstanceOf(self::ARRAY_CACHE_CLASS, $this->cacheProvider);
    }

    /**
     * @test
     */
    public function Memcache_Make_ReturnMemcache()
    {
        $this->cacheProvider = $this->cacheProviderFactory->make(CacheProviderType::MEMCACHE, new MemcacheStub());
        $this->assertInstanceOf(self::MEMCACHE_CLASS, $this->cacheProvider);
    }

    /**
     * @test
     */
    public function Memcached_Make_ReturnMemcached()
    {
        $this->cacheProvider = $this->cacheProviderFactory->make(CacheProviderType::MEMCACHED, new MemcachedStub());
        $this->assertInstanceOf(self::MEMCACHED_CLASS, $this->cacheProvider);
    }

    /**
     * @test
     */
    public function Redis_Make_ReturnRedis()
    {
        $this->cacheProvider = $this->cacheProviderFactory->make(CacheProviderType::REDIS, new RedisStub());
        $this->assertInstanceOf(self::REDIS_CLASS, $this->cacheProvider);
    }

    protected function setUp()
    {
        $this->cacheProviderFactory = new CacheProviderFactoryImpl();
    }

}
