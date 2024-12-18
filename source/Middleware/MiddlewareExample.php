<?php

namespace Source\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * MiddlewareExample Middleware
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Middleware
 */
class MiddlewareExample
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $response->getBody()->write(json_encode(["middleware" => "success"]));
        return $response;
    }
}
