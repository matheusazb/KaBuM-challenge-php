<?php

namespace System\Core;

/**
 * ViewController Class
 *
 * @version 0.0.1
 */
class ViewController
{
  public $data = [];

  /**
   * Render the View page by name
   * 
   * @param String $view view file name
   * @param Array $data data to use on frontend page
   * @param String $extension extension of file, by default is ".php"
   */
  public function view(String $view, array $data = [], String $extension = 'php')
  {
    $viewFile = sprintf(VIEWS_PATH . '/%s.%s', $view, $extension);
    if (file_exists($viewFile)) {
      require_once $viewFile;
    }
  }
}
