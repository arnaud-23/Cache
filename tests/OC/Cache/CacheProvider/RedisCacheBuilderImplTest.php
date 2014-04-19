<?php

namespace OC\Tests\Cache\CacheProvider;

use OC\Cache\CacheProvider\CacheProviderBuilderImpl;
use OC\Cache\CacheProvider\CacheProviderType;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class RedisCacheBuilderImplTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Create_ReturnRedisCacheBuilderImpl()
    {
        $builder = CacheProviderBuilderImpl::create(CacheProviderType::REDIS);
        $this->assertInstanceOf('OC\Cache\CacheProvider\CacheProviderBuilderImpl', $builder);
    }
}
