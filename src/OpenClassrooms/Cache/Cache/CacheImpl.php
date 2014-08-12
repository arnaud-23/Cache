<?php

namespace OpenClassrooms\Cache\Cache;

use Doctrine\Common\Cache\CacheProvider;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheImpl implements Cache
{
    /**
     * @var CacheProvider
     */
    protected $cache;

    /**
     * @var int
     */
    protected $defaultLifetime = self::DEFAULT_LIFE_TIME;

    public function __construct(CacheProvider $cache)
    {
        $this->cache = $cache;
    }

    public function setDefaultLifetime($defaultLifetime)
    {
        $this->defaultLifetime = $defaultLifetime;
    }

    /**
     * Fetches an entry from the cache.
     *
     * @param string $id          The id of the cache entry to fetch.
     * @param string $namespaceId The id of the namespace entry to fetch.
     *
     * @return mixed The cached data or FALSE, if no cache entry exists for the given namespace and id.
     */
    public function fetchWithNamespace($id, $namespaceId = null)
    {
        if (null !== $namespaceId) {
            $namespace = $this->fetch($namespaceId);
            $id = $namespace . $id;
        }

        return $this->fetch($id);
    }

    /**
     * Fetches an entry from the cache.
     *
     * @param string $id The id of the cache entry to fetch.
     *
     * @return mixed The cached data or FALSE, if no cache entry exists for the given id.
     */
    public function fetch($id)
    {
        return $this->cache->fetch($id);
    }

    /**
     * Tests if an entry exists in the cache.
     *
     * @param string $id The cache id of the entry to check for.
     *
     * @return boolean TRUE if a cache entry exists for the given cache id, FALSE otherwise.
     */
    public function contains($id)
    {
        return $this->cache->contains($id);
    }

    /**
     * Deletes a cache entry.
     *
     * @param string $id The cache id.
     *
     * @return boolean TRUE if the cache entry was successfully deleted, FALSE otherwise.
     */
    public function delete($id)
    {
        return $this->cache->delete($id);
    }

    /**
     * Retrieves cached information from the data store.
     *
     * The server's statistics array has the following values:
     *
     * - <b>hits</b>
     * Number of keys that have been requested and found present.
     *
     * - <b>misses</b>
     * Number of items that have been requested and not found.
     *
     * - <b>uptime</b>
     * Time that the server is running.
     *
     * - <b>memory_usage</b>
     * Memory used by this server to store items.
     *
     * - <b>memory_available</b>
     * Memory allowed to use for storage.
     *
     * @since 2.2
     *
     * @return array|null An associative array with server's statistics if available, NULL otherwise.
     */
    public function getStats()
    {
        return $this->cache->getStats();
    }

    /**
     * Invalidate a namespace.
     *
     * @param string $namespaceId The id of the namespace to invalidate.
     *
     * @return boolean TRUE if the namespace entry was successfully regenerated, FALSE otherwise.
     */
    public function invalidate($namespaceId)
    {
        $namespace = $this->fetch($namespaceId);

        if (false === $namespace) {
            return false;
        }

        $newNamespace = rand(0, 10000);
        // @codeCoverageIgnoreStart
        while ($namespace === $newNamespace) {
            $newNamespace = rand(0, 10000);
        }

        // @codeCoverageIgnoreEnd
        return $this->save($namespaceId, $namespaceId . '_' . $newNamespace .'_', 0);
    }

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
    public function save($id, $data, $lifeTime = null)
    {
        if (null === $lifeTime) {
            $lifeTime = $this->defaultLifetime;
        }

        return $this->cache->save($id, $data, $lifeTime);
    }

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
    public function saveWithNamespace($id, $data, $namespaceId = null, $lifeTime = null)
    {
        if (null !== $namespaceId) {
            $namespace = $this->fetch($namespaceId);
            if (!$namespace) {
                $namespace = $namespaceId . '_' . rand(0, 10000);
                $this->save($namespaceId, $namespace, 0);
            }
            $id = $namespace . $id;
        }

        return $this->save($id, $data, $lifeTime);
    }
}
