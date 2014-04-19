<?php

namespace OC\Tests\Cache\CacheProvider;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class RedisStub extends \Redis
{
    public function setOption($name, $value)
    {
        return true;
    }

}
