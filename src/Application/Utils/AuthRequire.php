<?php

namespace Application\Utils;

use System\Http\Request;
use System\Http\Response;

/**
 * AuthRequire Class
 *
 * @version 0.0.1
 */
class AuthRequire
{
  /**
   * Require login to access functions
   */
  static function loginIsRequired()
  {
    if (REQUIRE_AUTH) {
      $request = new Request();
      if ($request->getSession()['auth'] != true) {
        $response = new Response();
        if ($request->method === "GET") {
          $response->redirect("/login", 302);
          exit();
        }
        $response->setStatusCode(401);
        $response->render();
        exit();
      }
    }
  }
}
