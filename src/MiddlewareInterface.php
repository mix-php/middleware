<?php

namespace Mix\Middleware;

/**
 * Interface MiddlewareHandlerInterface
 * @package Mix\Middleware
 * @author liu,jian <coder.keda@gmail.com>
 */
interface MiddlewareInterface
{

    /**
     * @param callable $callback
     * @param \Closure $next
     * @return mixed
     */
    public function process(callable $callback, \Closure $next);

}
