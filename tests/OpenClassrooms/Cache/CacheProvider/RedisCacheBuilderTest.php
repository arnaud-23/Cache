<?php

namespace OpenClassrooms\Tests\Cache\CacheProvider;

use OpenClassrooms\Cache\CacheProvider\CacheProviderType;
use OpenClassrooms\Cache\CacheServer\Redis;
use OpenClassrooms\Tests\Cache\CacheServer\RedisSpy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class RedisCacheBuilderTest extends AbstractCacheProviderBuilderTest
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
        $this->cacheProviderBuilder->create(CacheProviderType::REDIS)->build();
    }

    /**
     * @test
     */
    public function BuildWithOnlyHost_ReturnRedisCache()
    {
        $redisCache = $this->cacheProviderBuilder->create(CacheProviderType::REDIS)
            ->withHost(self::EXPECTED_HOST)
            ->build();

        /** @var RedisSpy $redis */
        $redis = $redisCache->getRedis();
        $this->assertEquals(self::EXPECTED_HOST, $redis->host);
        $this->assertEquals(Redis::DEFAULT_PORT, $redis->port);
        $this->assertEquals(Redis::DEFAULT_TIMEOUT, $redis->timeout);
    }

    /**
     * @test
     */
    public function Build_ReturnRedisCache()
    {
        $redisCache = $this->cacheProviderBuilder->create(CacheProviderType::REDIS)
            ->withHost(self::EXPECTED_HOST)
            ->withPort(self::EXPECTED_PORT)
            ->withTimeout(self::EXPECTED_TIMEOUT)
            ->build();

        /** @var RedisSpy $redis */
        $redis = $redisCache->getRedis();
        $this->assertEquals(self::EXPECTED_HOST, $redis->host);
        $this->assertEquals(self::EXPECTED_PORT, $redis->port);
        $this->assertEquals(self::EXPECTED_TIMEOUT, $redis->timeout);
    }
}
