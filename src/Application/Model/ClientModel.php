<?php

namespace Application\Model;

use System\Core\Model;

/**
 * ClientModel Class
 *
 * @version 0.0.1
 */
class ClientModel extends Model
{
  /**
   * @var String $indexField index field on database table
   */
  public $indexField = 'client_id';

  /**
   * @var Array $fields fields on database table
   */
  public $fields = ['name', 'birthdate', 'phone', 'rg', 'cpf'];

  public $id;
  public $name;
  public $birthdate;
  public $cpf;
  public $rg;
  public $phone;
  public $addressList = [];

  public function __construct()
  {
    parent::__construct('clients');
    $this->id = null;
  }
}
