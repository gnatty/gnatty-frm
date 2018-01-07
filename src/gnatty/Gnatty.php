<?php

namespace gnatty;

use \gnatty\core\Router;
use \gnatty\core\ServeRouteAction;
use \gnatty\core\Request;
use \gnatty\core\Response;
use \gnatty\core\Log;

class Gnatty
{

  public $release = 0.1;
  public $router;
  
  public $action_parameter = [
    [
      'type'  => 'gnatty\core\Request',
      'run'   => null
    ],
    [
      'type'  => 'gnatty\core\Response',
      'run'   => null
    ]
  ];

  public function __construct() {
    $this->init();
  }

  public function init() {
    $this->router = new Router();
  }

  public function add_route(string $method, string $route, $action) {
    return $this->router->add_route($method, $route, $action);
  }

  public function run() {
    // -- run router.
    $this->router->run();
    if( !empty($this->router->getRoute()) ) {
      $serve = new ServeRouteAction();
      $serve->run($this->router->getRoute());
      Log::pre($serve);
    }

  }

}