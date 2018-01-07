<?php

namespace gnatty\core;

class Route
{
  private $method;
  private $route;
  private $action;
  private $name;
  private $params;
  private $http_path_args;
  private $parameter;

  public function __construct(string $method, string $route, $action, string $name = null) 
  {
    $this->method   = $method;
    $this->route    = $route;
    $this->action   = $action;
    $this->name     = $name;
  }

  public function setParameter($parameter) {
    $this->parameter = $parameter;
  }

  public function getParameter() {
    return $this->parameter;
  }

  public function setParams($params) {
    $this->params = $params;
  }

  public function getParams() {
    return $this->params;
  }

  public function getMethod(): string 
  {
    return $this->method;
  }

  public function getRoute(): string
  {
    return $this->route;
  }

  public function getAction()
  {
    return $this->action;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function get_http_path_args() {
    if( $this->route != '/' ) {
      $this->route = rtrim($this->route, '/');
    }
    $this->http_path_args = explode('/', $this->route);
    return $this->http_path_args;
  }

}