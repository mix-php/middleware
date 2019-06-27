<?php

namespace Mix\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface MiddlewareHandlerInterface
 * @package Mix\Middleware
 * @author liu,jian <coder.keda@gmail.com>
 */
interface MiddlewareInterface extends \Psr\Http\Server\MiddlewareInterface
{

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface;

}
