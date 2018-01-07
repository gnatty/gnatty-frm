<?php

namespace site\controller;

use \gnatty\core\Request;
use \gnatty\core\Response;

class DefaultController
{
  public $name = 'ok';

  public function home(Request $request, Response $response, string $ok) {
    return 'ok default controller';
  }

}