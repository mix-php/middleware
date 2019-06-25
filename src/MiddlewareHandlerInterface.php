<?php

namespace Mix\Middleware;

/**
 * Interface MiddlewareHandlerInterface
 * @package Mix\Middleware
 * @author liu,jian <coder.keda@gmail.com>
 */
interface MiddlewareHandlerInterface
{

    /**
     * 处理
     * @param callable $callback
     * @param \Closure $next
     * @return mixed
     */
    public function handle(callable $callback, \Closure $next);

}
