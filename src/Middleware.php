<?php

namespace Mix\Middleware;

/**
 * Class Middleware
 * @package Mix\Middleware
 * @author liu,jian <coder.keda@gmail.com>
 */
class Middleware
{

    /**
     * 实例集合
     * @var array
     */
    protected $_instances = [];

    /**
     * 使用静态方法创建实例
     * @param string $namespace
     * @param array $handlerNames
     * @return Middleware
     */
    public static function new(string $namespace, array $handlerNames)
    {
        return new static($namespace, $handlerNames);
    }

    /**
     * Middleware constructor.
     * @param string $namespace
     * @param array $handlerNames
     */
    public function __construct(string $namespace, array $handlerNames)
    {
        $this->_instances = static::newInstances($namespace, $handlerNames);
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
     * @param array $handlerNames
     * @return array
     */
    protected static function newInstances(string $namespace, array $handlerNames): array
    {
        $instances = [];
        foreach ($handlerNames as $key => $name) {
            $class  = "{$namespace}\\{$name}Middleware";
            $object = new $class();
            if (!($object instanceof MiddlewareHandlerInterface)) {
                throw new \RuntimeException("{$class} type is not '" . MiddlewareHandlerInterface::class . "'");
            }
            $instances[$key] = $object;
        }
        return $instances;
    }

}
