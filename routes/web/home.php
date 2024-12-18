<?php

use Source\Controllers\Home;
use Slim\Routing\RouteCollectorProxy as Group;
use Source\Middleware\MiddlewareExample;
use Source\Controllers\Error;

return function ($app) {
    $app->group("/", function (Group $group) {
        $group->get("", [Home::class, 'index']);
        $group->get("form", [Home::class, 'form']);
        $group->post("form", [Home::class, 'form']);
        $group->get("form-ajax", [Home::class, 'formAjax']);
    })->add(new MiddlewareExample());

    $app->post("/form-ajax", [Home::class, 'formAjax']);
    $app->group("/ops", function (Group $group) {
        $group->get("/error/{status_code}", [Error::class, 'index']);
    });
};
