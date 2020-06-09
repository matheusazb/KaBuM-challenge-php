<?php

namespace Application\Controller;

use Application\Model\AddressModel;
use Application\Model\ClientModel;
use Application\Utils\AuthRequire;
use System\Core\ViewController;
use System\Http\Request;

/**
 * PanelController Class
 *
 * @version 0.0.1
 */
class PanelController extends ViewController
{
  /**
   * @var Array $_js javascript files
   */
  private $_js = [];

  /**
   * @var Array $_css css files
   */
  private $_css = [];

  /**
   * @var Array $_metatags
   */
  private $_metatags = [];


  /**
   * @var Request $_request
   */
  private $_request = null;

  public function __construct()
  {
    $this->_request = new Request();
    $this->_metatags = [
      'title' => 'Painel KaBuM',
    ];
    $this->_js = [
      'main.js',
      'dashboard.js'
    ];

    $this->_css = [
      'style.css'
    ];
  }

  /**
   * Add or update metatag
   * 
   * @param String $tag
   * @param String $value
   * @param Bool $append
   */
  private function setMetatag(String $tag, String $value, Bool $append = false)
  {
    if ($append == true && !is_null($this->_metatags[$tag])) {
      $this->_metatags[$tag] .= $value;
    } else {
      $this->_metatags[$tag] = $value;
    }
  }

  /**
   * Add a js file
   * 
   * @param String $jsFilePath
   */
  private function addJsFile(String $jsFilePath)
  {
    array_push($this->_js, $jsFilePath);
  }

  /**
   * Index dashboard page
   * 
   * @GET("/")
   */
  public function index()
  {
    AuthRequire::loginIsRequired();
    $this->_redirect('/clients/list');
    // $this->setMetatag('title', ' - Dashboard', true);
    // $this->showView('index');
  }

  /**
   * Login page
   * 
   * @get("/login")
   */
  public function login()
  {
    // $this->_js = ['login.js'];
    if ($_SESSION['auth'] == true) {
      $this->_redirect("/", 302);
      exit();
    }
    $this->_js = ['main.js'];
    $this->setMetatag('title', ' - Login', true);
    $this->showView('login/index');
  }

  /**
   * Client list page
   * 
   * @get("/clients/list")
   */
  public function clientsList()
  {
    AuthRequire::loginIsRequired();
    $client = new ClientModel();
    $list = $client->select();
    $this->setMetatag('title', ' - Lista de Clientes', true);
    $this->showView('clients/list', ['list' => $list, 'count' => count($list), 'hasRecords' => count($list) > 0]);
  }

  /**
   * List of address client
   * 
   * @get("/clients/address/list/:clientId")
   */
  public function clientsListAddress()
  {
    AuthRequire::loginIsRequired();
    $clientId = intval(end($this->_request->uriSegments));
    $clientModel = new ClientModel();
    $clientRows = $clientModel->select("*", "client_id", $clientId);
    if (count($clientRows) > 0) {
      $clientRows = current($clientRows);
      $address = new AddressModel();
      $list = $address->select("*", "client_id", $clientId);
      $this->setMetatag('title', ' - Lista de Endereços', true);
      $this->showView('address/list', ['list' => $list, 'client' => $clientRows, 'client_id' => $clientId, 'count' => count($list), 'hasRecords' => count($list) > 0]);
    } else {
      $this->_redirect("/clients/list");
    }
  }

  private function _redirect(String $redirectTo, Int $statusCode = 302)
  {
    header("Location: " . $redirectTo, TRUE, $statusCode);
    exit();
  }

  public function clientsListAddressCreate()
  {
    AuthRequire::loginIsRequired();
    $clientId = intval(end($this->_request->uriSegments));
    $clientModel = new ClientModel();
    $clientRows = $clientModel->select("*", 'client_id', intval($clientId));
    if (count($clientRows) > 0) {
      $clientRows = current($clientRows);
      $this->addJsFile('clients-cep.js');
      $this->setMetatag('title', ' - Adicionar Endereço', true);
      $this->showView('address/create', ['client_id' => $clientId, 'client' => $clientRows]);
    } else {
      $this->_redirect("/clients/list");
    }
  }

  public function clientsListAddressUpdate()
  {
    AuthRequire::loginIsRequired();
    $addressId = intval(end($this->_request->uriSegments));
    $address = new AddressModel();
    $addressItem = $address->select("*", "address_id", $addressId);
    if (count($addressItem) > 0) {
      $addressItem = current($addressItem);
      $clientModel = new ClientModel();
      $clientRows = $clientModel->select("*", 'client_id', intval($addressItem['client_id']));
      if (count($clientRows) > 0) {
        $clientRows = current($clientRows);
        $this->setMetatag('title', ' - Atualizar endereço', true);
        $this->showView('address/create', ['address' => $addressItem, 'client' => $clientRows, 'address_id' => $addressId]);
      } else {
        $this->_redirect("/clients/list");
      }
    } else {
      $this->_redirect("/clients/list");
    }
  }

  /**
   * Client create page
   * 
   * @get("/clients/create")
   */
  public function clientsCreate()
  {
    $this->addJsFile('clients-cep.js');
    $this->setMetatag('title', ' - Adicionar Cliente', true);
    $this->showView('clients/create');
  }

  /**
   * Client update page
   * 
   * @get("/clients/update/:id")
   */
  public function clientsUpdate()
  {
    AuthRequire::loginIsRequired();
    $this->addJsFile('clients-cep.js');
    $clientId = end($this->_request->uriSegments);
    $client = new ClientModel();
    $clientFound = $client->select('*', 'client_id', $clientId);
    if (count($clientFound) > 0) {
      $clientFound = current($clientFound);
      $this->setMetatag('title', ' - Atualizar Cliente', true);
      $this->showView('clients/create', ['client' => $clientFound]);
    } else {
      $this->_redirect("/clients/list");
    }
  }

  /**
   * Render a view page
   * 
   * @param String $view
   * @param Array $data
   */
  public function showView(String $view, array $data = [])
  {
    parent::view($view, array_merge(['JS' => $this->_js, 'CSS' => $this->_css, 'metatags' => $this->_metatags], $data));
  }
}
