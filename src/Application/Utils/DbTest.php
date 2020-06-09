<?php

namespace Application\Utils;

use PDO;
use PDOException;

/**
 * DbTest Class
 *
 * @version 0.0.1
 */
class DbTest
{
  /**
   * @var PDO $_connection connection of database
   */
  private static $_connection = null;

  public function __construct()
  {
    try {
      $this->_connection = new PDO(sprintf("mysql:host=%s;dbname=%s", DB_HOST, DB_DATABASE), DB_USER, DB_PASS);
    } catch (PDOException $e) {
      echo '[DbTest] ' . $e->getMessage();
      die();
    }
  }

  /**
   * Function to check database status
   */
  public function getStatus()
  {
    if (!$this->_connection) {
      echo '[DbTest] FAILED ON CONNECT ON MYSQL';
    } else {
      echo '[DbTest] Connection Success!';
    }
    return $this->_connection ? true : false;
  }
}
