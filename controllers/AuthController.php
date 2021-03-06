<?php


namespace app\controllers;
use app\core\Controller;
use app\core\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if($request->isPost()) {
            return "Handel data login";
        }
        return $this->render('login');
    }

    public function register(Request $request)
    {
        if($request->isPost()) {
            return "Handel data register";
        }
        return $this->render('register');

    }
}