<?php

namespace OC\Cache\Cache\CacheProvider;

use OC\Cache\CacheProvider\Exception\InvalidCacheProviderTypeException;
use OC\Cache\CacheProvider\Exception\InvalidCacheServerException;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface CacheProviderFactory
{

    /**
     * @return \Doctrine\Common\Cache\CacheProvider
     * @throws InvalidCacheProviderTypeException
     * @throws InvalidCacheServerException
     */
    public function make($cacheProviderType, $server = null);
}
