# zf-mem-cache
Mem缓存，继承自"zf-abstract-cache"

# 简介
- Memory缓存类 "\Zf\Cache\MemoryCache" 提供了 memory 缓存的相关操作
- 该缓存继承自抽象类 "\Zf\Cache\Abstracts\ACache"

# 使用范例
```php
$mem = new \Memcache();
$mem->connect('172.16.37.128', 10000);

// 实例化
$cache = Object::create([
    'class' => MemoryCache::class,
    'namespace' => 'name',
    'mem' => $mem,
]);

$value = $cache->get('name');
var_dump($value);

/* @var $cache ACache */
// ====== 普通用法 ======
// 生成一个缓存
$cache->set('name', 'qingbing', 20);
$cache->set('sex', 'nan');

$value = $cache->get('name');
var_dump($value);

$cache->delete('sex');
var_dump($cache);

$has = $cache->has('grade');
var_dump($has);
$has = $cache->has('name');
var_dump($has);

//$cache->clear();

// ====== 批量用法 ======
$cache->setMultiple([
    'age' => 19,
    'class' => 1,
    'grade' => 2,
], 2000);

$data = $cache->getMultiple([
    'class',
    'name',
    'grade',
    'age',
]);
var_dump($data);

$cache->deleteMultiple(['class', 'name']);

// ====== 键、值随意化 ======
$key = ["sex", "name"];
// 设置缓存
$status = $cache->set($key, ["女", ["xxx"]]);
var_dump($status);
// 获取缓存
$data = $cache->get($key);
var_dump($data);
// 删除缓存
$status = $cache->delete($key);
var_dump($status);
```