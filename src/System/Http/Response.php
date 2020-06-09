<?php

namespace System\Http;

use System\Http\HttpStatus;

/**
 * Response Class
 *
 * @version 0.0.1
 */
class Response
{
  /**
   * @var Array $_headers
   */
  protected $_headers = [];

  /**
   * @var Bool $_useHeaders already used headers
   */
  private $_useHeaders = false;

  /**
   * @var String $_statusCode by default is 200 OK
   */
  private $_statusCode = "HTTP/1.1 200 OK";

  /**
   * @var Any $_data
   */
  private $_data = null;

  /**
   * Add a new header
   * 
   * @param String $header
   */
  public function addHeader(String $header)
  {
    $this->_headers[] = $header;
  }

  /**
   * Get all headers
   * 
   * @return Array
   */
  public function getHeader()
  {
    return $this->_headers;
  }

  /**
   * Set the content of Response
   * 
   * @param Any $content
   * @param Bool $isJson by default is False
   */
  public function setContent($content, Bool $isJson = false)
  {
    $this->_data = $isJson ? json_encode($content) : $content;
  }

  /**
   * Set a status code to response
   * 
   * @param Int $statusCode by default is 200 OK
   */
  public function setStatusCode(Int $statusCode = 200)
  {
    $HttpStatus = new HttpStatus();
    $this->_statusCode = sprintf("HTTP/1.1 %s %s", $statusCode, $HttpStatus->getStatusByCode($statusCode));
    // echo $this->_statusCode;
  }

  /**
   * Apply headers on page
   */
  private function _applyHeaders()
  {
    if (!$this->_useHeaders) {
      $this->_useHeaders = true;
      header($this->_statusCode);
      foreach ($this->_headers as $header) {
        header($header);
      }
    }
  }

  /**
   * Redirect to another page
   * 
   * @param String $redirectTo path to redirect
   * @param Int $statusCode [301/302]
   */
  public function redirect(String $redirectTo, Int $statusCode = 302)
  {
    header("Location: " . $redirectTo, TRUE, $statusCode);
    exit();
  }

  /**
   * Render a response
   */
  public function render()
  {
    if (FINISH_REQUEST == FALSE) {
      $this->_applyHeaders();
      echo $this->_data;
      define("FINISH_REQUEST", true);
    }
  }
}
