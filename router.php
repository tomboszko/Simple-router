<?php

class Router {
    // This array will store all the routes
    protected $routes = [];

    // This function adds a route to the routes array
    public function addRoute(string $method, string $url, Closure $target) {
        // The route is stored as an array within an array, with the outer array's key being the HTTP method
        $this->routes[$method][$url] = $target;
    }

    // This function matches the current request to a route
    public function matchRoute() {
        // Get the HTTP method and URL from the server superglobal
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];

        // Check if there are any routes for this HTTP method
        if (isset($this->routes[$method])) {
            // Loop through all the routes for this HTTP method
            foreach ($this->routes[$method] as $routeUrl => $target) {
                // If the current route URL matches the requested URL
                if ($routeUrl === $url) {
                    // Call the target function for this route
                    call_user_func($target);
                    // Stop processing further
                    return;
                }
            }
        }
        // If no matching route was found, throw an exception
        throw new Exception('Route not found');
    }
}