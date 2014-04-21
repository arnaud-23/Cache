<?php

namespace OpenClassrooms\Tests\Cache\CacheProvider;

use OpenClassrooms\Cache\CacheProvider\CacheProviderType;
use OpenClassrooms\Cache\CacheServer\Memcache;
use OpenClassrooms\Tests\Cache\CacheServer\MemcacheSpy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class MemcacheCacheBuilderTest extends AbstractCacheProviderBuilderTest
{
    const EXPECTED_HOST = '127.0.0.1';

    const EXPECTED_PORT = 12345;

    const EXPECTED_TIMEOUT = 10.0;

    /**
     * @test
     * @expectedException \OpenClassrooms\Cache\CacheProvider\Exception\HostShouldBeProvidedException
     */
    public function BuildWithoutHost_ThrowException()
    {
        $this->cacheProviderBuilder->create(CacheProviderType::MEMCACHE)->build();
    }

    /**
     * @test
     */
    public function BuildWithOnlyHost_ReturnMemcacheCache()
    {
        $memcacheCache = $this->cacheProviderBuilder
            ->create(CacheProviderType::MEMCACHE)
            ->withHost(self::EXPECTED_HOST)
            ->build();

        /** @var MemcacheSpy $memcache */
        $memcache = $memcacheCache->getMemcache();
        $this->assertEquals(self::EXPECTED_HOST, $memcache->host);
        $this->assertEquals(Memcache::DEFAULT_PORT, $memcache->port);
        $this->assertEquals(Memcache::DEFAULT_TIMEOUT, $memcache->timeout);
    }

    /**
     * @test
     */
    public function Build_ReturnMemcacheCache()
    {
        $memcacheCache = $this->cacheProviderBuilder
            ->create(CacheProviderType::MEMCACHE)
            ->withHost(self::EXPECTED_HOST)
            ->withPort(self::EXPECTED_PORT)
            ->withTimeout(self::EXPECTED_TIMEOUT)
            ->build();

        /** @var MemcacheSpy $memcache */
        $memcache = $memcacheCache->getMemcache();
        $this->assertEquals(self::EXPECTED_HOST, $memcache->host);
        $this->assertEquals(self::EXPECTED_PORT, $memcache->port);
        $this->assertEquals(self::EXPECTED_TIMEOUT, $memcache->timeout);
    }
}
