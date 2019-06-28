<?php

namespace Mix\Middleware;

use Mix\Bean\BeanInjector;
use Mix\Middleware\Exception\InstantiationException;

/**
 * Class MiddlewareDispatcher
 * @package Mix\Middleware
 * @author liu,jian <coder.keda@gmail.com>
 */
class MiddlewareDispatcher
{

    /**
     * @var string
     */
    public $namespace;

    /**
     * @var array
     */
    public $middleware;

    /**
     * @var array
     */
    protected $objects = [];

    /**
     * MiddlewareDispatcher constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        BeanInjector::inject($this, $config);
        $this->init();
    }

    /**
     * 初始化
     */
    public function init()
    {
        $objects = [];
        foreach ($this->middleware as $key => $name) {
            $class  = "{$namespace}\\{$name}Middleware";
            $object = new $class();
            if (!($object instanceof MiddlewareInterface)) {
                throw new InstantiationException("{$class} type is not '" . MiddlewareInterface::class . "'");
            }
            $objects[$key] = $object;
        }
        $this->objects = $objects;
    }

    /**
     * 中间件调度
     * @param callable $callback
     * @param mixed ...$params
     * @return mixed
     */
    public function dispatch(callable $callback, ...$params)
    {
        $object = array_shift($this->objects);
        if (empty($object)) {
            return call_user_func_array($callback, $params);
        }
        return $object->handle($callback, function () use ($callback, $params) {
            return $this->run($callback, ...$params);
        });
    }

}
