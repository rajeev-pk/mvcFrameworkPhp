<?php


namespace app\core;


class Controller
{
    public function render($template, $params = []) {
        return Application::$app->router->renderTemplate($template, $params);
    }
}