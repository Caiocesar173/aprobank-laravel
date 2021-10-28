<?php

if (!function_exists('require_routes')) 
{
    function require_routes($routes, $path = 'api')
    {
        foreach($routes as $route) {
            require_once("$path/$route");
        }
    }
}

$routes = array_diff(scandir(__DIR__.'/api'), array('..', '.'));

(env('APROBANK_ROUTES_ENABLE') === TRUE) ? require_routes($routes) : '';

