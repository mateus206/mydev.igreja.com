<?php

class Databasesingle
{
  private static $connection;

  public static function connect()
  {
    if (!self::$connection) {
      self::$connection = new PDO(
        "mysql:host=localhost;dbname=igreja_system",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
      );
    }
    return self::$connection;
  }
}
