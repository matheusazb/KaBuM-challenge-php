<?php

namespace Application\Model;

use System\Core\Model;

/**
 * AddressModel Class
 *
 * @version 0.0.1
 */
class AddressModel extends Model
{
  /**
   * @var String $indexField index field on database table
   */
  public $indexField = 'address_id';

  /**
   * @var Array $fields fields on database table
   */
  public $fields = ['client_id', 'cep', 'street', 'number', 'complement', 'neighborhood', 'city', 'state'];

  public $id;
  public $client_id;
  public $cep;
  public $street;
  public $number;
  public $complement;
  public $neighborhood;
  public $state;
  public $city;

  public function __construct()
  {
    parent::__construct('address');
    $this->id = null;
  }
}
