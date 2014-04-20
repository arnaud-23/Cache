<?php

namespace OC\Tests\Cache\CacheProvider;

use OC\Cache\CacheProvider\CacheProviderType;
use OC\Cache\CacheServer\Memcache;
use OC\Tests\Cache\CacheServer\MemcachedSpy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class MemcachedCacheBuilderTest extends \PHPUnit_Framework_TestCase
{
    const EXPECTED_HOST = '127.0.0.1';

    const EXPECTED_PORT = 12345;

    /**
     * @test
     * @expectedException \OC\Cache\CacheProvider\Exception\HostShouldBeProvidedException
     */
    public function BuildWithoutHost_ThrowException()
    {
        CacheBuilderMock::create(CacheProviderType::MEMCACHED)->build();
    }

    /**
     * @test
     */
    public function BuildWithOnlyHost_ReturnMemcachedCache()
    {
        $memcachedCache = CacheBuilderMock::create(CacheProviderType::MEMCACHED)
            ->withHost(self::EXPECTED_HOST)
            ->build();

        /** @var MemcachedSpy $memcached */
        $memcached = $memcachedCache->getMemcached();
        $this->assertEquals(self::EXPECTED_HOST, $memcached->host);
        $this->assertEquals(Memcache::DEFAULT_PORT, $memcached->port);
    }

    /**
     * @test
     */
    public function Build_ReturnMemcachedCache()
    {
        $memcachedCache = CacheBuilderMock::create(CacheProviderType::MEMCACHED)
            ->withHost(self::EXPECTED_HOST)
            ->withPort(self::EXPECTED_PORT)
            ->build();

        /** @var MemcachedSpy $memcached */
        $memcached = $memcachedCache->getMemcached();
        $this->assertEquals(self::EXPECTED_HOST, $memcached->host);
        $this->assertEquals(self::EXPECTED_PORT, $memcached->port);
    }
}
