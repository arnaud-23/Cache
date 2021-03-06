<?php

namespace OpenClassrooms\Tests\Cache\CacheProvider;

use OpenClassrooms\Cache\CacheProvider\CacheProviderBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
abstract class AbstractCacheProviderBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CacheProviderBuilder
     */
    protected $cacheProviderBuilder;

    protected function setUp()
    {
        $this->cacheProviderBuilder = new CacheProviderBuilderMock();
    }

}
