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
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $target) {
                // Use named subpatterns in the regular expression pattern to capture each parameter value separately
                $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);
                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                    // Pass the captured parameter values as named arguments to the target function
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY); // Only keep named subpattern matches
                    call_user_func_array($target, $params);
                    return;
                }
            }
        }
        throw new Exception('Route not found');
    }}