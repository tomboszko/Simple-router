<?php
// Include the Router class from router.php
include_once "router.php";
// Create a new instance of the Router class
$router = new Router();
// Add a route to the router
// This route matches GET requests to the /blogs URL
// When this route is matched, it will echo a message and then exit
$router->addRoute('GET', '/blogs', function () {
   include 'blogs.php';
    exit;
});

//added homepage route
$router->addRoute('GET', '/', function () {
    include 'home.php';
});

// Try to match the current request to a route
// If a matching route is found, its associated function will be called
// If no matching route is found, an exception will be thrown
$router->matchRoute();