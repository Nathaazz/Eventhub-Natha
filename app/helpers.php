<?php

use Illuminate\Support\Facades\Request;

if (!function_exists('activeMenu')) {

    function activeMenu($route)
    {
        return Request::routeIs($route)
            ? 'active bg-warning text-dark fw-bold'
            : 'text-light';
    }
}