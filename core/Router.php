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

    public function post($url, $callback)
    {
        $this->routes["post"][$url] = $callback;
    }

    // get curent url and execute function by given url
    public function resolve()
    {
        $url = $this->request->getUrl();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$url] ?? false;

        if ($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderTemplate('_404');
        }
        if(is_string($callback)) {
            return $this->renderTemplate($callback);
        }
        if(is_array($callback)) {
            $callback[0] = new $callback[0]();
        }

        return call_user_func($callback, $this->request);
    }

    public function renderTemplate($template, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $templateContent = $this->renderOnlyTemplate($template, $params);
        return str_replace(' {{content}}', $templateContent, $layoutContent);
    }

    public function renderContent($templatContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace(' {{content}}', $templatContent, $layoutContent);
    }

    protected function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/templates/layouts/main.temp.php";
        return ob_get_clean();
    }

    protected function renderOnlyTemplate($template, $params)
    {   
        foreach ($params as $key => $value) {
            $$key  = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/templates/$template.temp.php";
        return ob_get_clean();
    }
}