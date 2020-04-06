<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Test\Web;


use DebugBootstrap\Abstracts\Tester;
use Zf\Cache\Abstracts\ACache;
use Zf\Cache\MemoryCache;
use Zf\Helper\Object;

/**
 * @author      qingbing<780042175@qq.com>
 * @describe    MemCacheTester
 *
 * Class MemCacheTester
 * @package Test\Web
 */
class MemCacheTester extends Tester
{
    /**
     * @describe    执行函数
     *
     * @throws \ReflectionException
     * @throws \Zf\Helper\Exceptions\ClassException
     * @throws \Zf\Helper\Exceptions\ParameterException
     */
    public function run()
    {
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

//        $cache->clear();

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
    }
}