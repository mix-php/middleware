<?php

namespace Mix\Middleware;

/**
 * Interface MiddlewareInterface
 * @package Mix\Middleware
 * @author liu,jian <coder.keda@gmail.com>
 */
interface MiddlewareInterface
{

    /**
     * 处理
     * @param callable $callback
     * @param \Closure $next
     * @return mixed
     */
    public function handle(callable $callback, \Closure $next);

}
