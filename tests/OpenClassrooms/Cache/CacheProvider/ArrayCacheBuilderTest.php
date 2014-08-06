<?php

namespace OpenClassrooms\Tests\Cache\CacheProvider;

use OpenClassrooms\Cache\CacheProvider\CacheProviderType;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class ArrayCacheBuilderTest extends AbstractCacheProviderBuilderTest
{
    /**
     * @test
     */
    public function Build()
    {
        $cacheProvider = $this->cacheProviderBuilder->create(CacheProviderType::ARRAY_CACHE)
            ->build();
        $this->assertInstanceOf('Doctrine\Common\Cache\ArrayCache', $cacheProvider);
    }
}
