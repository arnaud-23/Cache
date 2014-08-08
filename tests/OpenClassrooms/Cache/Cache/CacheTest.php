<?php

namespace OpenClassrooms\Tests\Cache\Cache;

use Doctrine\Common\Cache\ArrayCache;
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

    const NAMESPACE_ID_VALUE = CacheProviderSpy::NAMESPACE_ID_VALUE;

    const NAMESPACE_DATA = CacheProviderSpy::NAMESPACE_DATA;

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
        $this->cacheProviderSpy->save(self::ID, self::DATA);

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
        $this->cacheProviderSpy->save(self::ID, self::DATA);

        $contained = $this->cache->contains(self::ID);

        $this->assertTrue($contained);
        $this->assertTrue($this->cacheProviderSpy->containsHasBeenCalled);
        $this->assertEquals(self::ID, $this->cacheProviderSpy->id);
    }

    /**
     * @test
     */
    public function Delete_Call_CacheProviderDelete()
    {
        $this->cacheProviderSpy->save(self::ID, self::DATA);

        $deleted = $this->cache->delete(self::ID);
        $this->assertTrue($deleted);
        $this->assertTrue($this->cacheProviderSpy->deleteHasBeenCalled);
        $this->assertEquals(self::ID, $this->cacheProviderSpy->id);
    }

    /**
     * @test
     */
    public function GetStats_Call_CacheProviderGetStats()
    {
        $this->assertNull($this->cache->getStats());
        $this->assertTrue($this->cacheProviderSpy->getStatsHasBeenCalled);
    }

    /**
     * @test
     */
    public function WithoutLifeTime_Save_SaveWithDefaultLifeTime()
    {
        $saved = $this->cache->save(self::ID, CacheProviderSpy::DATA);

        $this->assertTrue($saved);
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

        $this->assertTrue($saved);
        $this->assertTrue($this->cacheProviderSpy->saveHasBeenCalled);
        $this->assertEquals(self::ID, $this->cacheProviderSpy->id);
        $this->assertEquals(self::DATA, $this->cacheProviderSpy->data);
        $this->assertEquals(self::LIFE_TIME, $this->cacheProviderSpy->lifeTime);
    }

    /**
     * @test
     */
    public function WithoutNamespaceId_SaveWithNamespace()
    {
        $saved = $this->cache->saveWithNamespace(self::ID, self::DATA);

        $this->assertTrue($saved);
        $this->assertTrue($this->cacheProviderSpy->saveHasBeenCalled);
        $this->assertEquals(self::ID, $this->cacheProviderSpy->id);
        $this->assertEquals(self::DATA, $this->cacheProviderSpy->data);
        $this->assertEquals(Cache::DEFAULT_LIFE_TIME, $this->cacheProviderSpy->lifeTime);
    }

    /**
     * @test
     */
    public function SaveWithNamespace()
    {
        $saved = $this->cache->saveWithNamespace(self::ID, self::DATA, self::NAMESPACE_ID, self::LIFE_TIME);

        $this->assertTrue($saved);
        $this->assertTrue($this->cacheProviderSpy->saveHasBeenCalled);
        $this->assertStringStartsWith(self::NAMESPACE_ID_VALUE, $this->cacheProviderSpy->id);
        $this->assertEquals(self::DATA, $this->cacheProviderSpy->data);
        $this->assertEquals(self::LIFE_TIME, $this->cacheProviderSpy->lifeTime);
    }

    /**
     * @test
     */
    public function WithoutNamespaceId_FetchWithNamespace_ReturnData()
    {
        $this->cacheProviderSpy->save(self::ID, self::DATA);
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
        $this->cacheProviderSpy->cacheProvider->save(self::NAMESPACE_ID, self::NAMESPACE_ID_VALUE);
        $this->cacheProviderSpy->cacheProvider->save(self::NAMESPACE_ID_VALUE . self::ID, self::NAMESPACE_DATA);

        $data = $this->cache->fetchWithNamespace(self::ID, self::NAMESPACE_ID);

        $this->assertEquals(CacheProviderSpy::NAMESPACE_DATA, $data);
        $this->assertTrue($this->cacheProviderSpy->fetchHasBeenCalled);
        $this->assertEquals(
            self::NAMESPACE_ID_VALUE . self::ID,
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
        $this->cacheProviderSpy->cacheProvider->save(self::NAMESPACE_ID, self::NAMESPACE_ID_VALUE);
        $this->cacheProviderSpy->cacheProvider->save(self::NAMESPACE_ID_VALUE . self::ID, self::NAMESPACE_DATA);
        $invalidated = $this->cache->invalidate(self::NAMESPACE_ID);

        $this->assertTrue($invalidated);
        $this->assertTrue($this->cacheProviderSpy->saveHasBeenCalled);
        $this->assertEquals(CacheProviderSpy::NAMESPACE_ID, $this->cacheProviderSpy->id);
    }

    protected function setUp()
    {
        $this->cacheProviderSpy = new CacheProviderSpy();
        $this->cache = new CacheImpl($this->cacheProviderSpy);

        $this->cacheProviderSpy->cacheProvider = new ArrayCache();
    }
}
