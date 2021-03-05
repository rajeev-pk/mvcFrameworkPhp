<?php

namespace app\core;

class Router
{
    public Request $request;

    // stores get routes in a nested array
    protected array $routes = [];

    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }



    public function get($url, $callback)
    {
        $this->routes["get"][$url] = $callback;
    }

    // get curent url and execute function by given url
    public function resolve()
    {
        $url = $this->request->getUrl();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$url] ?? false;

        if ($callback === false) {
            $this->response->setStatusCode(404);
            return '404 page not found';
        }
        if(is_string($callback)) {
            return $this->renderTemplate($callback);
        }
        return call_user_func($callback);
    }

    public function renderTemplate($template)
    {
        $layoutContent =$this->layoutContent();
        $templateContent = $this->renderOnlyTemplate($template);
        return str_replace(' {{content}}', $templateContent, $layoutContent);
    }

    protected function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/templates/layouts/main.temp.php";
        return ob_get_clean();
    }

    protected function renderOnlyTemplate($template)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/templates/$template.temp.php";
        return ob_get_clean();
    }
}