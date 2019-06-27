<?php

namespace Mix\Middleware;

/**
 * Class MiddlewareAware
 * @package Mix\Middleware
 * @author liu,jian <coder.keda@gmail.com>
 */
class MiddlewareAware
{

    /**
     * 实例集合
     * @var array
     */
    protected $_instances = [];

    /**
     * 使用静态方法创建实例
     * @param string $namespace
     * @param array $middlewares
     * @return Middleware
     */
    public static function new(string $namespace, array $middlewares)
    {
        return new static($namespace, $middlewares);
    }

    /**
     * Middleware constructor.
     * @param string $namespace
     * @param array $middlewares
     */
    public function __construct(string $namespace, array $middlewares)
    {
        $this->_instances = static::newInstances($namespace, $middlewares);
    }

    /**
     * 执行中间件
     * @param callable $callback
     * @param mixed ...$params
     * @return mixed
     */
    public function run(callable $callback, ...$params)
    {
        $item = array_shift($this->_instances);
        if (empty($item)) {
            return call_user_func_array($callback, $params);
        }
        return $item->handle($callback, function () use ($callback, $params) {
            return $this->run($callback, ...$params);
        });
    }

    /**
     * 实例化中间件
     * @param string $namespace
     * @param array $middlewares
     * @return MiddlewareInterface[]
     */
    protected static function newInstances(string $namespace, array $middlewares): array
    {
        $instances = [];
        foreach ($handlerNames as $key => $name) {
            $class  = "{$namespace}\\{$name}Middleware";
            $object = new $class();
            if (!($object instanceof MiddlewareInterface)) {
                throw new \RuntimeException("{$class} type is not '" . MiddlewareInterface::class . "'");
            }
            $instances[$key] = $object;
        }
        return $instances;
    }

}
