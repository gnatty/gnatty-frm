<?php

namespace gnatty\core;

use \gnatty\core\Closure;
use \gnatty\core\Request;
use \gnatty\core\Response;
use \gnatty\core\Log;

class ServeRouteAction
{

  private $class_delimiter = '=>';
  private $parameter = [];

  public function __construct() {

  }

  public function push_parameter($type, $name) {
    array_push(
      $this->parameter,
      array(
        'type' => $type,
        'name' => $name
      )
    );
  }

  public function is_closure($c) {
    return gettype($c)=='object' && get_class($c) == 'Closure';
  }

  public function is_named($c) {
    return gettype($c)=='string';
  }

  public function serve_closure($c) {
    if( !is_callable($c) ) {
      throw new \Exception('todo_exception_msg');
    } else {
      $ref = new \ReflectionFunction($c);
      $params = $ref->getParameters();
      // -- parameter.
      $this->parse_parameter($params);
      // -- todo
    }
  }

  public function parse_parameter($params) {
    foreach($params as $key => $param) {
      $this->push_parameter(
        $param->getType()->__toString(),
        $param->getName()
      );
    }
  }

  public function serve_method($c) {
    $ex = explode($this->class_delimiter, $c);
    if( count($ex) !== 2 ) {
      throw new \Exception('todo_exception_msg');
    } elseif( !method_exists($ex[0], $ex[1]) ) {
      throw new \Exception('todo_exception_msg');
    } else {
      $ref = new \ReflectionMethod($ex[0], $ex[1]); 
      $params = $ref->getParameters();
      // -- parameter.
      $this->parse_parameter($params);
      // -- todo
    }
  }

  public function run($route) {
    switch(true) {
      case $this->is_named($route->getAction()):
        $this->serve_method($route->getAction());
        break;
      case $this->is_closure($route->getAction()):
        $this->serve_closure($route->getAction());
        break;
    }
  }

  public function check_type($action) {

    if( $this->is_closure($action) ) {
      $request = new Request();
      $response = new Response();
      $action->call(new Closure(), $request, $response);
    }

  }


}
