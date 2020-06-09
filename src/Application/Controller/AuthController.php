<?php

namespace Application\Controller;

use Application\Model\UserModel;
use System\Http\Request;
use System\Http\Response;

class AuthController
{
  public function login()
  {
    $request = new Request();
    $username = $request->post('username');
    $password = $request->post('password');
    $userModel = new UserModel();
    $userModel->setUsername($username);
    $userModel->setPassword($password);

    $logged = $userModel->login();
    if ($logged) {
      $_SESSION['auth'] = true;
      header('Location: /', false, 302);
    } else {
      header('Location: /login', false, 302);
    }
    exit();
  }

  public function logout()
  {
    unset($_SESSION['auth']);
    $response = new Response();
    $response->redirect("/login");
  }
}
