<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Settings', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->scope('/settings', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });
});