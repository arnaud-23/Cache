<?php

namespace OpenClassrooms\Tests\Cache\CacheProvider;

use OpenClassrooms\Cache\CacheProvider\CacheProviderType;
use OpenClassrooms\Cache\CacheServer\Memcache;
use OpenClassrooms\Tests\Cache\CacheServer\MemcachedSpy;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class MemcachedCacheBuilderTest extends AbstractCacheProviderBuilderTest
{
    const EXPECTED_HOST = '127.0.0.1';

    const EXPECTED_PORT = 12345;

    /**
     * @test
     * @expectedException \OpenClassrooms\Cache\CacheProvider\Exception\HostShouldBeProvidedException
     */
    public function BuildWithoutHost_ThrowException()
    {
        $this->cacheProviderBuilder->create(CacheProviderType::MEMCACHED)->build();
    }

    /**
     * @test
     */
    public function BuildWithOnlyHost_ReturnMemcachedCache()
    {
        $memcachedCache = $this->cacheProviderBuilder->create(CacheProviderType::MEMCACHED)
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
        $memcachedCache = $this->cacheProviderBuilder->create(CacheProviderType::MEMCACHED)
            ->withHost(self::EXPECTED_HOST)
            ->withPort(self::EXPECTED_PORT)
            ->build();

        /** @var MemcachedSpy $memcached */
        $memcached = $memcachedCache->getMemcached();
        $this->assertEquals(self::EXPECTED_HOST, $memcached->host);
        $this->assertEquals(self::EXPECTED_PORT, $memcached->port);
    }
}
