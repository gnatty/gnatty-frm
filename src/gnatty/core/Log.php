<?php

namespace gnatty\core;

class Log
{

  public static function log_compare($val1, $val2, $resp = null) {
    echo $val1 . ' == vs == ' . $val2 . ' =====> ' . $resp . '<hr>';
  }

  public static function pre($e) {
    echo '<pre>';
    print_r($e);
    echo '</pre><hr>';
  }

}