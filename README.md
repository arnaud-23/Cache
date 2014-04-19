# Cache
Cache adds features to Doctrine Cache implementation
- default lifetime
- fetch with a namespace
- cache invalidation through namespace strategy

## Installation
The easiest way to install Cache is via [composer](http://getcomposer.org/). Create the following `composer.json` file and run the `php composer.phar install` command to install it.

```json
{
    "require": {
        "OC/Cache": "*"
    }
}
```

```php
<?php
require 'vendor/autoload.php';

use OC\Cache\Cache;

//do things
```

<a name="install-nocomposer"/>


## Usage
### Instantiation

OC\Cache needs a DoctrineCacheProvider to be instantiate.

```
$cacheProvider = new ArrayCache();

$cache = new Cache($cacheProvider);
```

A Cache builder can be use.

```
// Default builder, build a cache using ArrayCache Provider
$cache = CacheBuilder::create()
    ->build();

// Using a CacheProvider
$cache = CacheBuilder::create(CacheProviderType::REDIS)
    ->withCacheProvider($redisCache)
    ->build();

// Using a server
$cache = CacheBuilder::create(CacheProviderType::REDIS)
    ->withServer($redis)
    ->build();

// Optional default lifetime
$cache = CacheBuilder::create(CacheProviderType::REDIS)
    ->withCacheProvider($redisCache)
    ->withDefaultLifetime(300)
    ->build();
```

### Default lifetime
```
$cache->setDefaultLifetime(300);
$cache->save($id, $data);
```

### Fetch with namespace
```
$data = $cache->fetch($id, $namespaceId);
```

### Invalidate cache
```
$cache->invalidate($namespaceId);
``
