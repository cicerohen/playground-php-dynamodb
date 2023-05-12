<?php

use  Dotenv\Dotenv;

class LoadEnv
{
  public static function load()
  {
    $path = dirname(__DIR__) . DIRECTORY_SEPARATOR;

    $dotenv = Dotenv::createImmutable($path);
    $dotenv->load();
  }
}
