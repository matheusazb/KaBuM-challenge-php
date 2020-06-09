<?php

namespace System\Core;

use System\Core\Route;
use System\Http\Request;

/**
 * Router Class
 *
 * @version 0.0.2
 */
class Router
{

  /**
   * List of routes
   * 
   * @var array of routes
   */
  public $_routes = [];

  /**
   * @var Request $_request current request
   */
  private $_request = null;

  /**
   * @var Bool $_done is done?
   */
  private $_done = false;

  /**
   * @var Array $_mapControllers map of controllers to use routes
   */
  private $_mapControllers = [];

  public function __construct(array $routes = null, array $mapControllers = null)
  {
    $this->_request = new Request();
    if (!empty($routes) && !is_null($routes)) {
      $this->_routes = $routes;
    }
    if (!empty($mapControllers) && !is_null($mapControllers)) {
      $this->_mapControllers = $mapControllers;
    }
  }

  /**
   * Add GET route
   * 
   * @param String $pattern used to match route
   * @param Object $controller to execute
   * @param String $function function of controller to run when match
   */
  public function get(String $pattern, Object $controller = null, String $function = 'index')
  {
    $this->_addRoute('GET', $pattern, $controller, $function);
  }

  /**
   * Add POST route
   * 
   * @param String $pattern used to match route
   * @param Object $controller to execute
   * @param String $function function of controller to run when match
   */
  public function post(String $pattern, Object $controller = null, String $function = 'index')
  {
    $this->_addRoute('POST', $pattern, $controller, $function);
  }

  /**
   * Add DELETE route
   * 
   * @param String $pattern used to match route
   * @param Object $controller to execute
   * @param String $function function of controller to run when match
   */
  public function delete(String $pattern, Object $controller = null, String $function = 'remove')
  {
    $this->_addRoute('DELETE', $pattern, $controller, $function);
  }

  /**
   * Execute the Router
   */
  public function run()
  {
    $enabledRoutes = $this->_getEnabledRoutes();
    foreach ($enabledRoutes as $route) {
      if (!$this->_done) {
        $foundMatch = $this->_match($route->url, $this->_request->uri);
        if (!empty($foundMatch)) {
          $this->_done = true;
          if (is_array($foundMatch) && count($foundMatch) === 1) {
            $routeController = new $route->controller();
            $routeController->{$route->function}();
          } else {
            $controller = new $route->controller();
            $action = $route->function;
            if (!empty($foundMatch['controller'])) {
              $controller = $this->_getControllerByRoute($foundMatch['controller']);
              if (!is_null($controller)) {
                if (!empty($foundMatch['action'])) {
                  if ($this->_checkIfMethodExists($controller, $foundMatch['action'])) {
                    $action = $foundMatch['action'];
                  } else {
                    die();
                  }
                }
              }
            }
            $controller->{$action}();
          }
          die();
        }
      }
    }
  }

  /**
   * Get enabled routes based on REQUEST METHOD
   */
  private function _getEnabledRoutes()
  {
    return array_filter($this->_routes, function ($object) {
      return $object->method === $this->_request->method;
    }, ARRAY_FILTER_USE_BOTH);
  }

  /**
   * Check if Method exist on Controller\Class
   * 
   * @param Object $class controller\class
   * @param String $action method name
   * 
   * @return Bool
   */
  private function _checkIfMethodExists(Object $class, String $action)
  {
    return (int) method_exists($class, $action) === 1;
  }

  /**
   * Get a controller by Route segment using the mapped controllers
   * 
   * @param String $param
   * 
   * @return Object|Null
   */
  private function _getControllerByRoute(String $param)
  {
    if (count($this->_mapControllers) > 0) {
      $controllerFound = $this->_mapControllers[$param];
      if (empty($controllerFound)) {
        return null;
      }
      return new $controllerFound();
    }
  }

  /**
   * Find match routes
   * 
   * @param String $routeUrl route URL
   * @param String $currentUrl current URL 
   */
  private function _match(String $routeUrl, String $currentUrl)
  {
    $currentMatch = null;
    $routeRegex = $this->_generateRegexToMatchRoute($routeUrl);
    preg_match($routeRegex, $currentUrl, $currentMatch);
    return $currentMatch;
  }

  private function _generateRegexToMatchRoute(String $routeUrl)
  {
    $regex = null;
    $regex = preg_replace_callback('@:([\w]+)@', [$this, '_makeRegexWithParams'], $routeUrl);
    if (substr($routeUrl, -1) === '/')
      $regex = $regex . '?';
    $regex = '@^' . $regex . '$@';
    return $regex;
  }

  /**
   * Generate a Regex with Params
   */
  private function _makeRegexWithParams($results)
  {
    $keyPath = str_replace(':', '', $results[0]);
    return '(?P<' . $keyPath . '>[a-zA-Z0-9_\-\.\!\~\*\\\'\(\)\:\@\&\=\$\+,%]+)';
  }

  /**
   * Method to add new Route
   * 
   * @param String $method [GET\POST\PUT\DELETE]
   * @param String $pattern pattern to match route
   * @param Object $controller Controller or class
   * @param String $function Function name to run of Controller
   */
  private function _addRoute(String $method, String $pattern, Object $controller, String $function)
  {
    $route = new Route($method, $pattern, $controller, $function);
    array_push($this->_routes, $route);
  }
}
