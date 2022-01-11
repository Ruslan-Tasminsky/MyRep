<?php

namespace app\controllers;

use app\models\UserModel;

class UserController extends AppController
{
    public function signupAction()
    {
        if (!empty($_POST)) {
            $user = new UserModel;
            $data = $_POST;
            $user->load($data);
            if (!$user->validate($data) || !$user->checkUnique()) {
                $user->getErrors();
                $_SESSION["form_data"] = $data;
            } else {
                $user->attributes["password"] = password_hash($user->attributes["password"], PASSWORD_DEFAULT);
                if ($user->save("user")) {
                    $user->login();
                    $_SESSION["success"] = "User registered and entered!";
                } else {
                    $_SESSION["error"] = "Error";
                }
            }
            redirect();
        }
        $this->setMeta("SignUp");
    }
    public function loginAction()
    {
        if (!empty($_POST)) {
            $user = new UserModel();
            if ($user->login()) {
                $_SESSION["success"] = "You successfully logined!";
            } else {
                $_SESSION["error"] = "Login / Password entered incorrectly!";
            }
            redirect();
        }
        $this->setMeta("LogIn");
    }
    public function logoutAction()
    {
        if (isset($_SESSION["user"])) unset($_SESSION["user"]);
        redirect();
    }
}
