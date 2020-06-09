<?php

namespace System\Core;

/**
 * Route Class
 *
 * @version 0.0.1
 */
class Route
{
  /**
   * @var String $method [GET\POST\PUT\DELETE]
   */
  public $method;

  /**
   * @var String $url url pattern to match
   */
  public $url;

  /**
   * @var Controller $controller
   */
  public $controller;

  /**
   * @var String $function function to execute on match
   */
  public $function;

  public function __construct(String $method, String $url, Object $controller, String $function)
  {
    $this->method = $method;
    $this->url = $url;
    $this->controller = $controller;
    $this->function = $function;
  }
}
