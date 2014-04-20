<?php

namespace OC\Tests\Cache\CacheProvider;

use OC\Cache\CacheProvider\CacheProviderType;
use OC\Cache\CacheServer\Memcache;
use OC\Tests\Cache\CacheServer\MemcacheSpy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class MemcacheCacheBuilderTest extends \PHPUnit_Framework_TestCase
{
    const EXPECTED_HOST = '127.0.0.1';

    const EXPECTED_PORT = 12345;

    const EXPECTED_TIMEOUT = 10.0;

    /**
     * @test
     * @expectedException \OC\Cache\CacheProvider\Exception\HostShouldBeProvidedException
     */
    public function BuildWithoutHost_ThrowException()
    {
        CacheBuilderMock::create(CacheProviderType::MEMCACHE)->build();
    }

    /**
     * @test
     */
    public function BuildWithOnlyHost_ReturnMemcacheCache()
    {
        $memcacheCache = CacheBuilderMock::create(CacheProviderType::MEMCACHE)
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
        $memcacheCache = CacheBuilderMock::create(CacheProviderType::MEMCACHE)
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
