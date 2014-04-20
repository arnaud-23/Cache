<?php

namespace OpenClassrooms\Cache\Cache;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface Cache extends \Doctrine\Common\Cache\Cache
{
    const DEFAULT_LIFE_TIME = 0;

    public function setDefaultLifetime($defaultLifetime);

    /**
     * @return mixed The cached data or FALSE, if no cache entry exists for the given id.
     */
    public function fetchWithNamespace($id, $namespaceId = null);

    public function invalidate($namespaceId);

    public function save($id, $data, $lifeTime = null);
}
