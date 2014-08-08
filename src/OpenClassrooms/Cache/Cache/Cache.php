<?php

namespace OpenClassrooms\Cache\Cache;

//use Doctrine\Common\Cache\Cache as BaseCache;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface Cache extends \Doctrine\Common\Cache\Cache
{
    const DEFAULT_LIFE_TIME = 0;

    public function setDefaultLifetime($defaultLifetime);

    /**
     * Fetches an entry from the cache.
     *
     * @param string $id          The id of the cache entry to fetch.
     * @param string $namespaceId The id of the namespace entry to fetch.
     *
     * @return mixed The cached data or FALSE, if no cache entry exists for the given namespace and id.
     */
    public function fetchWithNamespace($id, $namespaceId = null);

    /**
     * Invalidate a namespace.
     *
     * @param string $namespaceId The id of the namespace to invalidate.
     *
     * @return boolean TRUE if the namespace entry was successfully regenerated, FALSE otherwise.
     */
    public function invalidate($namespaceId);

    /**
     * Puts data into the cache.
     *
     * @param string $id       The cache id.
     * @param mixed  $data     The cache entry/data.
     * @param int    $lifeTime The cache lifetime.
     *                         If != 0, sets a specific lifetime for this cache entry (0 => infinite lifeTime).
     *
     * @return boolean TRUE if the entry was successfully stored in the cache, FALSE otherwise.
     */
    public function save($id, $data, $lifeTime = null);

    /**
     * Puts data into the cache.
     *
     * @param string $id          The cache id.
     * @param mixed  $data        The cache entry/data.
     * @param string $namespaceId The namespace id.
     * @param int    $lifeTime    The cache lifetime.
     *                            If != 0, sets a specific lifetime for this cache entry (0 => infinite lifeTime).
     *
     * @return boolean TRUE if the entry was successfully stored in the cache, FALSE otherwise.
     */
    public function saveWithNamespace($id, $data, $namespaceId = null, $lifeTime = null);
}
