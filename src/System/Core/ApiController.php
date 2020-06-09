<?php

namespace System\Core;

use System\Http\Response;

/**
 * ApiController Class
 *
 * @version 0.0.1
 */
class ApiController
{
  /**
   * @var Response $response
   */
  public $response = null;

  public function __construct()
  {
    $this->response = new Response();
    $this->response->addHeader('Content-Type: application/json; charset=UTF-8');
  }

  /**
   * Get response of ApiController
   */
  public function getResponse()
  {
    return $this->response;
  }
}
