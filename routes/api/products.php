<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteCollectorProxy as Group;

return function ($app) {
    $app->group('/product', function(Group $group) {
        $group->get('/detail', function(ServerRequestInterface $request, ResponseInterface $response) {
            $response->getBody()->write(json_encode(["product_detail" => "success"]));
            return $response->withHeader("Content-Type", "application/json")->withStatus(200);
        });
    });
};