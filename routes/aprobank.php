<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


$routes = array_diff(scandir(__DIR__.'/api'), array('..', '.'));
require_routes($routes);

function require_routes($routes)
{
    foreach($routes as $route) {
        require_once("api/$route");
    }
}