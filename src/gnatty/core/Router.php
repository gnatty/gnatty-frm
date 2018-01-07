<?php

namespace gnatty\core;

use \gnatty\core\Route;
use \gnatty\core\Parameter;

class Router
{

  const ALLOWED_METHOD = 'GET|POST';
  const DIR_NAME_RETURN = ['\\', '/'];

  private $route;
  private $routes;
  private $http_dir;
  private $http_method;
  private $http_path;
  private $http_path_args;

  public function __construct() {
    $this->init();
    return $this;
  }

  public function getRoute() {
    return $this->route;
  }

  public function getRoutes() {
    return $this->routes;
  }

  public function init() {
    $this->routes = [];
    $this->http_dir    = dirname($_SERVER['SCRIPT_NAME']);
    $this->http_method = $_SERVER['REQUEST_METHOD'];
    $this->parse_url();
    $this->parse_http_path();
  }

  public function run() {
    $this->serve_route();
  }

  public function parse_url() {
    $parser = parse_url($_SERVER['REQUEST_URI']);
    $this->http_path  = substr($parser['path'], strlen($this->http_dir));
  }

  public function parse_http_path() {
    if( $this->http_path != '/' ) {
      $this->http_path = rtrim($this->http_path, '/');
    }
    $this->http_path_args = explode('/', $this->http_path);
  }

  public function add_route(string $method, string $route, $action) {
    $method = strtoupper($method);
    $route = new Route($method, $route, $action);
    return $this->check_route_before_add($route);
  }

  public function check_route_before_add(Route $route) {

    // -- check route method.
    $result = preg_match('/^(' . self::ALLOWED_METHOD . ')$/', $route->getMethod());
    if(!$result) {
      throw new \Exception('todo_exception_msg');
    }

    // -- check double route.
    $result = array_filter($this->routes, function($search_route) use ($route) {
      return ($search_route->getMethod() === $route->getMethod()
        && $search_route->getRoute() === $route->getRoute());
    });
    if(!empty($result)) {
      throw new \Exception('todo_exception_msg');
    }

    // -- add route.
    array_push($this->routes, $route);
    return end($this->routes);
  }
  
  public function serve_route() {
    if( empty($this->routes) ) {
      throw new \Exception('todo_exception_msg');
      return null;
    }

    $route_find;
    
    foreach($this->routes as $key => $route) {

      $parameter = new Parameter();

      // --- check method.
      if( $this->http_method != $route->getMethod() ) {
        continue;
      }

      // --- check route length.
      $cur_http_path_args = $route->get_http_path_args();

      if( count($this->http_path_args) !== count($cur_http_path_args) ) {
        continue;
      }

      if($route->getRoute() == $this->http_path ) {
        $route_find = $route;
        break;
      }

      for($i = 1; $i <= (count($this->http_path_args)-1); $i++) {

        if( $this->http_path_args[$i] != $cur_http_path_args[$i] ) {
          // --- check if param.
          $find_param = $this->find_param($cur_http_path_args[$i]);
          if( $find_param == $cur_http_path_args[$i] ) {
            break;
          } else {
            $parameter->setParam( $find_param, $this->http_path_args[$i] );
          }
        }
        if( $i === (count($this->http_path_args)-1) ) {
          $route->setParameter($parameter);
          $route_find = $route;
        }
      }

    }

    if( empty($route_find) ) {
      throw new \Exception('todo_exception_msg');
    }
    $this->route = $route_find;
    return $route_find;
  }

  public function find_param($value) {
    return preg_replace('/^{(.*)}$/', "$1", $value);
  }

}