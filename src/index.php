<?php
session_start();
require_once 'autoload.php';
date_default_timezone_set('America/Sao_Paulo');

use Application\Controller\AddressController;
use Application\Controller\AuthController;
use System\Core\Router;
use Application\Controller\ClientController;
use Application\Controller\PanelController;
use System\Http\Response;

$mappedControllersToRoutes = [
  'clients' => new ClientController,
  'address' => new AddressController,
  'auth' => new AuthController
];

$router = new Router(null, $mappedControllersToRoutes);

// PANEL Routes
$router->get('/', new PanelController);
$router->get('/login', new PanelController, 'login');
$router->get('/logout', new AuthController, 'logout');
$router->get('/clients/list', new PanelController, 'clientsList');
$router->get('/clients/create', new PanelController, 'clientsCreate');
$router->get('/clients/update/:id', new PanelController, 'clientsUpdate');

// PANEL Address
$router->get('/clients/address/list/:id', new PanelController, 'clientsListAddress');
$router->get('/clients/address/update/:id', new PanelController, 'clientsListAddressUpdate');
$router->get('/clients/address/create/:id', new PanelController, 'clientsListAddressCreate');

// API Routes
$router->post('/api/:controller/:action/:id', new ClientController, 'update');
$router->delete('/api/:controller/:id', new ClientController, 'remove');
$router->post('/api/:controller/:action', new ClientController, 'insert');
$router->get('/api/:controller', new ClientController);

$router->run();

// Default Error - 404
if (FINISH_REQUEST == FALSE) {
  $response = new Response();
  $response->setStatusCode(404);
  $response->render();
}
