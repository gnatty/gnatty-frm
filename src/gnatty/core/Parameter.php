<?php

namespace gnatty\core;

class Parameter
{

  private $params = array();

  public function __construct() {
  }

  public function resetParams() {
    $this->params = array();
  }

  public function setParam($key, $value) {
    $this->params[ $key ] = $value;
  }

  public function setParams($params) {
    $this->params = $params;
  }

  public function getParams() {
    return $this->params;
  }

  public function getParam($key) {
    if( !empty($this->params[$key]) ) {
      return $this->params[$key];
    }
    return null;
  }

}