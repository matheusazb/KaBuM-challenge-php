<?php

namespace System\Http;

/**
 * Request Class
 *
 * @version 0.0.1
 */
class Request
{
  /**
   * @var Array $_request $_REQUEST
   */
  private $_request;

  /**
   * @var Array $_cookies $_COOKIE
   */
  private $_cookies;

  /**
   * @var Array $_server $_SERVER
   */
  private $_server;

  /**
   * @var Array $_server $_SERVER
   */
  private $_session;

  /**
   * @var String $uri current URI
   */
  public $uri;

  /**
   * @var Array $uriSegments current URI segments on array
   */
  public $uriSegments;

  /**
   * @var String $referer
   */
  public $referer;

  /**
   * @var String $userAgent
   */
  public $userAgent;

  /**
   * @var String $method [GET/POST/PUT/DELETE]
   */
  public $method;

  public function __construct()
  {
    $this->_request = $_REQUEST;
    $this->_cookies = $_COOKIE;
    $this->_server = $_SERVER;
    $this->_session = $_SESSION;
    $this->uri = $this->_server['REQUEST_URI'];
    $this->uriSegments = explode("/", $this->uri);
    $this->userAgent = $this->_server['HTTP_USER_AGENT'];
    $this->referer = $this->_server['HTTP_REFERER'];
    $this->method = $this->_server['REQUEST_METHOD'];
  }

  /**
   * Get a Query String params
   * 
   * @param String $param param name
   * @param Any $defaultValue default value when not exist parameter
   */
  public function get(String $param, $defaultValue = null)
  {
    return $_GET[$param] ? $_GET[$param] : $defaultValue;
  }

  /**
   * Get a Post data
   * 
   * @param String $param param name
   * @param Any $defaultValue default value when not exist parameter
   */
  public function post(String $param, $defaultValue = null)
  {
    $postData = $_POST[$param];
    if (is_null($postData)) {
      $jsonString = file_get_contents('php://input');
      if (!is_null($jsonString)) {
        $json = json_decode($jsonString);
        if ($json) {
          $postData = $json->{$param};
        }
      }
    }
    return $postData ? $postData : $defaultValue;
  }

  /**
   * Get all $_REQUEST data
   */
  public function getRequest()
  {
    return $this->_request;
  }

  /**
   * Get all $_COOKIE data
   */
  public function getCookies()
  {
    return $this->_cookies;
  }

  /**
   * Get all $_COOKIE data
   */
  public function getSession()
  {
    return $this->_session;
  }
}
