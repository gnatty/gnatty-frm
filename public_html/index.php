<style>
* {
  background-color: #333;
  color: white;
}
</style>
<?php

function test_oui() {
  echo 'oui test';
}

// ----------------------------------------------------------
// --- DEFAULT CONFIG
// ----------------------------------------------------------

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use \gnatty\core\Log;
use \gnatty\core\Request;
use \gnatty\core\Response;

$app = new \gnatty\Gnatty();
$app->add_route('GET', '/', '');
$app->add_route('GET', '/home', '');
$app->add_route('GET', '/news', '');
$app->add_route('GET', '/home/{name}', 'test_oui');
$app->add_route('GET', '/home/sercan', '\site\controller\DefaultController=>home');
$app->add_route('GET', '/home/{name}/doc', function(Request $request, Response $response) {
  echo 'ok';
});

$app->run();



foreach($app->router->getRoutes() as $route) {
  $route->getAction();
}
