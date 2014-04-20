<?php

namespace OpenClassrooms\Tests\Cache\Cache;

use OpenClassrooms\Cache\Cache\Cache;
use OpenClassrooms\Cache\Cache\CacheImpl;
use OpenClassrooms\Tests\Cache\CacheProvider\CacheProviderSpy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheTest extends \PHPUnit_Framework_TestCase
{
    const ID = CacheProviderSpy::ID;

    const NAMESPACE_ID = CacheProviderSpy::NAMESPACE_ID;

    const NON_EXISTING_NAMESPACE_ID = -1;

    const DATA = CacheProviderSpy::DATA;

    const LIFE_TIME = 100;

    /**
     * @var CacheProviderSpy
     */
    private $cacheProviderSpy;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @test
     */
    public function Fetch_Call_CacheProviderFetch()
    {
        $data = $this->cache->fetch(self::ID);
        $this->assertEquals(CacheProviderSpy::DATA, $data);
        $this->assertTrue($this->cacheProviderSpy->fetchHasBeenCalled);
        $this->assertEquals(self::ID, $this->cacheProviderSpy->id);
    }

    /**
     * @test
     */
    public function Contains_Call_CacheProviderContains()
    {
        $contained = $this->cache->contains(self::ID);
        $this->assertEquals(CacheProviderSpy::CONTAINS, $contained);
        $this->assertTrue($this->cacheProviderSpy->containsHasBeenCalled);
        $this->assertEquals(self::ID, $this->cacheProviderSpy->id);
    }

    /**
     * @test
     */
    public function Delete_Call_CacheProviderDelete()
    {
        $deleted = $this->cache->delete(self::ID);
        $this->assertEquals(CacheProviderSpy::DELETED, $deleted);
        $this->assertTrue($this->cacheProviderSpy->deleteHasBeenCalled);
        $this->assertEquals(self::ID, $this->cacheProviderSpy->id);
    }

    /**
     * @test
     */
    public function GetStats_Call_CacheProviderGetStats()
    {
        $stats = $this->cache->getStats();
        $this->assertEquals(array(), $stats);
        $this->assertTrue($this->cacheProviderSpy->getStatsHasBeenCalled);
    }

    /**
     * @test
     */
    public function WithoutLifeTime_Save_SaveWithDefaultLifeTime()
    {
        $saved = $this->cache->save(self::ID, CacheProviderSpy::DATA);
        $this->assertEquals(CacheProviderSpy::SAVED, $saved);
        $this->assertTrue($this->cacheProviderSpy->saveHasBeenCalled);
        $this->assertEquals(self::ID, $this->cacheProviderSpy->id);
        $this->assertEquals(self::DATA, $this->cacheProviderSpy->data);
        $this->assertEquals(Cache::DEFAULT_LIFE_TIME, $this->cacheProviderSpy->lifeTime);
    }

    /**
     * @test
     */
    public function Save_SaveWithLifeTime()
    {
        $saved = $this->cache->save(self::ID, self::DATA, self::LIFE_TIME);
        $this->assertEquals(CacheProviderSpy::SAVED, $saved);
        $this->assertTrue($this->cacheProviderSpy->saveHasBeenCalled);
        $this->assertEquals(self::ID, $this->cacheProviderSpy->id);
        $this->assertEquals(self::DATA, $this->cacheProviderSpy->data);
        $this->assertEquals(self::LIFE_TIME, $this->cacheProviderSpy->lifeTime);
    }

    /**
     * @test
     */
    public function WithoutNamespaceId_FetchWithNamespace_ReturnData()
    {
        $data = $this->cache->fetchWithNamespace(self::ID);
        $this->assertEquals(CacheProviderSpy::DATA, $data);
        $this->assertTrue($this->cacheProviderSpy->fetchHasBeenCalled);
        $this->assertEquals(self::ID, $this->cacheProviderSpy->id);
    }

    /**
     * @test
     */
    public function WithNamespaceId_FetchWithNamespace_ReturnData()
    {
        $data = $this->cache->fetchWithNamespace(self::ID, self::NAMESPACE_ID);
        $this->assertEquals(CacheProviderSpy::NAMESPACE_DATA, $data);
        $this->assertTrue($this->cacheProviderSpy->fetchHasBeenCalled);
        $this->assertEquals(
            CacheProviderSpy::NAMESPACE_ID_DATA . self::ID,
            $this->cacheProviderSpy->id
        );
    }

    /**
     * @test
     */
    public function NonExistingNamespace_Invalidate_ReturnFalse()
    {
        $invalidated = $this->cache->invalidate(self::NON_EXISTING_NAMESPACE_ID);
        $this->assertFalse($invalidated);
    }

    /**
     * @test
     */
    public function Invalidate_ReturnTrue()
    {
        $invalidated = $this->cache->invalidate(self::NAMESPACE_ID);
        $this->assertTrue($invalidated);
        $this->assertTrue($this->cacheProviderSpy->saveHasBeenCalled);
        $this->assertEquals(CacheProviderSpy::NAMESPACE_ID, $this->cacheProviderSpy->id);
    }

    protected function setUp()
    {
        $this->cacheProviderSpy = new CacheProviderSpy();
        $this->cache = new CacheImpl($this->cacheProviderSpy);
    }
}
