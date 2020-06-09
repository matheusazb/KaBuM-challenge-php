<?php

namespace System\Core;

use Application\Utils\Database;


/**
 * Model Class
 *
 * @version 0.0.1
 */
class Model
{
  /**
   * @var Database $DB Database instance
   */
  protected $DB = null;

  public function __construct(String $tableName)
  {
    $this->DB = new Database($tableName);
  }

  /**
   * Select records on database
   * 
   * @param String $select default is "*"
   * @param String $field
   * @param String $value
   */
  public function select(String $select = "*", String $field = null, String $value = null)
  {
    return $this->DB->select(null, true, $select, $field, $value);
  }

  /**
   * Insert record on database
   * 
   * @param Model $model
   */
  public function insert(Object $model = null)
  {
    return $this->DB->insert(null, $model);
  }

  /**
   * Update record on database
   * 
   * @param Model $model
   */
  public function update(Object $model = null)
  {
    return $this->DB->update(null, $model);
  }

  /**
   * Remove record on database
   * 
   * @param String $field
   * @param Int $id
   */
  public function remove(String $field = null, $id = null)
  {
    return $this->DB->remove(null, $field, $id);
  }
}
