<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Cache;


use Zf\Cache\Abstracts\ACache;
use Zf\Helper\Exceptions\RuntimeException;

/**
 * @author      qingbing<780042175@qq.com>
 * @describe    memcache 的缓存管理
 *
 * Class MemCache
 * @package Zf\Cache
 */
class MemoryCache extends ACache
{
    /**
     * @describe    memcache 缓存管理组件
     *
     * @var \Memcache
     */
    public $mem;

    /**
     * @describe    属性赋值后执行函数
     *
     * @throws RuntimeException
     */
    public function init()
    {
        if (!$this->mem instanceof \Memcache) {
            throw new RuntimeException('MemoryCache必须指定mem实例');
        }
    }

    /**
     * @describe    覆盖父类方法，因为memcache支持数组，对象的存储，没有必要再转化成字符串
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function encodeSaveValue($value)
    {
        return $value;
    }

    /**
     * @describe    覆盖父类方法，因为memcache支持数组，对象的存储，没有必要再转化成字符串
     *
     * @param mixed $saveValue
     *
     * @return mixed
     */
    protected function decodeSaveValue($saveValue)
    {
        return $saveValue;
    }

    /**
     * @describe    获取缓存id
     *
     * @param mixed $key
     *
     * @return string
     */
    protected function buildId($key): string
    {
        return $this->namespace . '_' . md5((is_string($key) ? $key : json_encode($key)));
    }

    /**
     * @describe    通过缓存id获取信息
     *
     * @param string $id
     *
     * @return mixed
     */
    protected function getValue($id)
    {
        return $this->mem->get($id);
    }

    /**
     * @describe    设置缓存id的信息
     *
     * @param string $id
     * @param mixed $value
     * @param int $ttl
     *
     * @return bool
     */
    protected function setValue(string $id, $value, $ttl): bool
    {
        return $this->mem->set($id, $value, 0, $ttl);
    }

    /**
     * @describe    删除缓存信息
     *
     * @param string $id
     *
     * @return bool
     */
    protected function deleteValue(string $id): bool
    {
        return $this->mem->delete($id);
    }

    /**
     * @describe    清理当前命名空间的缓存
     *
     * @return bool
     */
    protected function clearValues(): bool
    {
        return $this->mem->flush();
    }

    /**
     * @describe    通过缓存ids获取信息
     *
     * @param array $ids
     *
     * @return array
     */
    protected function getMultiValue($ids)
    {
        return $this->mem->get($ids);
    }

    /**
     * @describe    设置多个缓存
     *
     * @param mixed $kvs
     * @param null|int $ttl
     *
     * @return bool
     */
    protected function setMultiValue($kvs, $ttl = null): bool
    {
        foreach ($kvs as $id => $value) {
            $this->setValue($id, $value, $ttl);
        }
        return true;
    }

    /**
     * @describe    删除多个缓存
     *
     * @param array $ids
     *
     * @return bool
     */
    protected function deleteMultiValue($ids)
    {
        return $this->mem->delete($ids);
    }

    /**
     * @describe    判断缓存是否存在
     *
     * @param string $id
     *
     * @return bool
     */
    protected function exist(string $id): bool
    {
        return false !== $this->mem->get($id);
    }
}