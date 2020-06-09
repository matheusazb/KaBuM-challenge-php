<?php

namespace Application\Utils;

use PDO;
use PDOException;

/**
 * Database Class
 *
 * @version 0.0.1
 */
class Database
{
  /**
   * @var mysqli_connect $_connection
   */
  private static $_connection = null;

  /**
   * @var String $_tableName
   */
  private $_tableName = null;

  /**
   * Start a database using table name to start
   * @param String $tableName
   */
  public function __construct(String $tableName = null)
  {
    try {
      $this->_tableName = $tableName;
      $this->_connection = new PDO(sprintf("mysql:host=%s;dbname=%s", DB_HOST, DB_DATABASE), DB_USER, DB_PASS);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  /**
   * Make query to select data on Database
   * 
   * @param String $tableName
   * @param Bool $fetchAll
   * @param String $select
   * @param String $filterField
   * @param String $filterValue
   */
  public function select(String $tableName = null, Bool $fetchAll = true, String $select = "*", String $filterField = null, String $filterValue = null)
  {
    if ($tableName == null) {
      $tableName = $this->_tableName;
    }
    $sql = sprintf("select %s from %s", $select, $tableName);
    if (!empty($filterField) && !empty($filterValue)) {
      $sql .= sprintf(" WHERE %s = :0", $filterField);
    }
    $params = ['sql' => $sql, 'params' => [$filterValue]];
    return $this->execute($params, $fetchAll);
  }

  /**
   * Make query to insert data on Database
   * 
   * @param String $tableName
   * @param Model $model
   */
  public function insert(String $tableName = null, Object $model = null)
  {
    if ($tableName == null) {
      $tableName = $this->_tableName;
    }

    $params = [];
    foreach ($model->fields as $field) {
      $arr = [$field => $model->{$field}];
      $params = array_merge($params, $arr);
    }

    $sqlToInsert = sprintf("INSERT INTO %s ", $tableName);
    $insertColumns = "";
    $insertValues = "";
    $values = [];

    $countParams = 0;
    foreach ($params as $field => $value) {
      $templateString = "%s";
      if ($field != current($model->fields))
        $templateString = ",%s";
      $insertColumns .= sprintf($templateString, $field);
      $insertValues .= sprintf($templateString, ':' . ($countParams));
      $values[] = $value;
      $countParams++;
    }

    $sqlToInsert .= sprintf("(%s) VALUES (%s)", $insertColumns, $insertValues);
    return $this->execute(['sql' => $sqlToInsert, 'params' => $values, 'rowCount' => true]);
  }

  /**
   * Make query to update data on Database
   * 
   * @param String $tableName
   * @param Model $model
   */
  public function update(String $tableName = null, Object $model = null)
  {
    if ($tableName == null) {
      $tableName = $this->_tableName;
    }

    $checkIfExistSql = sprintf("SELECT %s FROM %s WHERE %s = :0", $model->indexField, $tableName, $model->indexField, $model->id);
    $existResult = $this->execute(['sql' => $checkIfExistSql, 'params' => [$model->id]], true, false);
    if (!is_null($existResult) && count($existResult) <= 0) {
      return false;
    }

    $params = [];
    foreach ($model->fields as $field) {
      $arr = [$field => $model->{$field}];
      $params = array_merge($params, $arr);
    }

    $sqlToUpdate = sprintf("UPDATE %s ", $tableName);
    $insertValues = "";
    $values = [];

    $countParams = 0;
    foreach ($params as $field => $value) {
      $templateString = "%s=%s";
      if ($field != current($model->fields))
        $templateString = ",%s=%s";
      $insertValues .= sprintf($templateString, $field, ':' . $countParams);
      $values[] = $value;
      $countParams++;
    }
    $values[] = $model->id;

    $sqlToUpdate .= sprintf("SET %s WHERE %s = %s", $insertValues, $model->indexField, ':' . $countParams);
    return $this->execute(['sql' => $sqlToUpdate, 'params' => $values, 'rowCount' => true]);
  }

  /**
   * Make query to remove data on Database
   * 
   * @param String $tableName
   * @param String $field
   * @param String $value
   */
  public function remove(String $tableName = null, String $field = null, $value = null)
  {
    if ($tableName == null) {
      $tableName = $this->_tableName;
    }
    $checkIfExistSql = sprintf("SELECT %s FROM %s WHERE %s = :0", $field, $tableName, $field);
    $existResult = $this->execute(['sql' => $checkIfExistSql, 'params' => [$value]], true, false);
    if (!is_null($existResult) && count($existResult) <= 0) {
      return false;
    }
    $sql = sprintf("DELETE FROM %s WHERE %s = :0", $tableName, $field, $value);
    return $this->execute(['sql' => $sql, 'params' => [$value], 'rowCount' => true]);
  }

  private function getQuery($queryConfig)
  {
    $sql = $queryConfig['sql'];
    $params = $queryConfig['params'];
    $query = $this->_connection->prepare($sql);
    if (!is_null($params) && count($params) > 0) {
      foreach ($params as $pIndex => $pValue) {
        $query->bindValue(sprintf(":%s", $pIndex), $pValue);
      }
    }
    return $query;
  }

  /**
   * Execute query on Database
   * 
   * @param String $sql
   * @param Bool $fetchAll
   * @param Bool $closeConnection
   */
  private function execute(array $queryConfig, Bool $fetchAll = false, Bool $closeConnection = true)
  {
    try {
      $query = $this->getQuery($queryConfig);
      $query->execute();
      if ($queryConfig['rowCount']) {
        return $query->rowCount() > 0;
      }
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      return false;
    }
  }

  public function executeSql(array $queryConfig, Bool $fetchAll, Bool $closeConnection)
  {
    return $this->execute($queryConfig, $fetchAll, $closeConnection);
  }
}
