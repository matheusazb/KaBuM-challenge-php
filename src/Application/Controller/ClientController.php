<?php

namespace Application\Controller;

use Application\Model\AddressModel;
use Application\Model\ClientModel;
use Application\Utils\AuthRequire;
use System\Core\ApiController;
use System\Http\Request;

/**
 * ClientController Class
 *
 * @version 0.0.1
 */
class ClientController extends ApiController
{
  /**
   * @var ClientModel $_model
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
  private $_indexField = 'client_id';

  public function __construct()
  {
    parent::__construct();
    $this->response = parent::getResponse();
    $this->_model = new ClientModel();
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
    $birthdate = $this->request->post('birthdate');
    $cpf = $this->request->post('cpf');
    $phone = $this->request->post('phone');

    $cpf = preg_replace('/\D/', '', $cpf);
    $phone = preg_replace('/[^\d\s]+/', '', $phone);
    $phone = preg_replace('/[\s]+/', '-', $phone);

    $date = explode('/', $birthdate);
    $birthdate = sprintf("%s-%s-%s 00:00:00", $date[2], $date[1], $date[0]);

    $this->_model->id = null;
    $this->_model->name = $this->request->post('name');
    $this->_model->birthdate = $birthdate;
    $this->_model->cpf = $cpf;
    $this->_model->rg = $this->request->post('rg');
    $this->_model->phone = $phone;

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
    $addressModel = new AddressModel();
    $addressModel->remove($this->_indexField, $this->_model->id);
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
    $birthdate = $this->request->post('birthdate');
    $cpf = $this->request->post('cpf');
    $phone = $this->request->post('phone');

    $cpf = preg_replace('/\D/', '', $cpf);
    $phone = preg_replace('/[^\d\s]+/', '', $phone);
    $phone = preg_replace('/[\s]+/', '-', $phone);

    $date = explode('/', $birthdate);
    $birthdate = sprintf("%s-%s-%s 00:00:00", $date[2], $date[1], $date[0]);

    $clientId = intval(end($this->request->uriSegments));
    $this->_model->id = $clientId;
    $this->_model->name = $this->request->post('name');
    $this->_model->birthdate = $birthdate;
    $this->_model->cpf = $cpf;
    $this->_model->rg = $this->request->post('rg');
    $this->_model->phone = $phone;

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
