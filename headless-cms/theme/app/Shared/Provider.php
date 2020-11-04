<?php

namespace App\Shared;

use App\Shared\Model\Options;

class Provider
{

  public static function init()
  {
    self::listeners();
  }

  protected static function listeners()
  {
//        Options::init();
  }
}
