<?php

namespace Application\Controller;

use Application\Model\AddressModel;
use Application\Utils\AuthRequire;
use System\Core\ApiController;
use System\Http\Request;

/**
 * AddressController Class
 *
 * @version 0.0.1
 */
class AddressController extends ApiController
{
  /**
   * @var AddressModel $_model
   */
  private $_model = null;

  /**
   * @var Response $response 
   */
  public $response = null;

  /**
   * @var Request $request
   */
  public $request = null;

  /**
   * @var String $_indexField
   */
  private $_indexField = 'address_id';

  public function __construct()
  {
    parent::__construct();
    $this->response = parent::getResponse();
    $this->_model = new AddressModel();
    $this->request = new Request();
  }

  /**
   * List all records
   */
  public function index()
  {
    AuthRequire::loginIsRequired();
    $this->response->setContent($this->_model->select(), true);
    $this->response->render();
  }

  /**
   * Insert a new record
   */
  public function insert()
  {
    AuthRequire::loginIsRequired();
    $cep = $this->request->post('cep');
    $cep = preg_replace('/\D/', '', $cep);

    $clientId = intval($this->request->post('client_id'));
    if (!$clientId || !is_numeric($clientId)) {
      $refererLastSegment = explode('/', $this->request->referer);
      $clientId = intval(end($refererLastSegment));
    }

    $this->_model->id = null;
    $this->_model->client_id = $clientId;
    $this->_model->cep = $cep;
    $this->_model->street = $this->request->post('street');
    $this->_model->number = $this->request->post('number');
    $this->_model->complement = $this->request->post('complement');
    $this->_model->neighborhood = $this->request->post('neighborhood');
    $this->_model->city = $this->request->post('city');
    $this->_model->state = $this->request->post('state');

    $created = $this->_model->insert($this->_model);
    $responseData = array(
      'success' => $created,
    );
    $this->response->setStatusCode(201);
    if ($created == false) {
      $this->response->setStatusCode(400);
    }
    $this->response->setContent($responseData, true);
    $this->response->render();
  }

  /**
   * Remove record by index field
   */
  public function remove()
  {
    AuthRequire::loginIsRequired();
    $this->_model->id = $this->request->uriSegments[count($this->request->uriSegments) - 1];
    $deleted = $this->_model->remove($this->_indexField, $this->_model->id);
    $responseData = array(
      'success' => $deleted,
      'message' => $deleted ? 'Deleted with success!' : 'Error on delete'
    );
    if ($deleted == false) {
      $this->response->setStatusCode(400);
    }
    $this->response->setContent($responseData, true);
    $this->response->render();
  }

  /**
   * Update record by index field
   */
  public function update()
  {
    AuthRequire::loginIsRequired();
    $clientId = intval($this->request->post('client_id'));
    if (!$clientId || !is_numeric($clientId)) {
      $refererLastSegment = explode('/', $this->request->referer);
      $clientId = intval(end($refererLastSegment));
    }
    $addressId = intval(end($this->request->uriSegments));
    $cep = $this->request->post('cep');
    $cep = preg_replace('/\D/', '', $cep);

    $this->_model->id = $addressId;
    $this->_model->client_id = $clientId;
    $this->_model->cep = $cep;
    $this->_model->street = $this->request->post('street');
    $this->_model->number = $this->request->post('number');
    $this->_model->complement = $this->request->post('complement');
    $this->_model->neighborhood = $this->request->post('neighborhood');
    $this->_model->city = $this->request->post('city');
    $this->_model->state = $this->request->post('state');

    $updated = $this->_model->update($this->_model);
    $responseData = array(
      'success' => $updated,
    );
    // $this->response->setStatusCode(200);
    if ($updated == false) {
      $this->response->setStatusCode(400);
    }
    $this->response->setContent($responseData, true);
    $this->response->render();
  }
}
