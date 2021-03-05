<?php


namespace app\core;


class Request
{
    //gets request uri and returns normal url without params
    public function getUrl()
    {
        $url = $_SERVER["REQUEST_URI"] ?? '/';
        $position = strpos($url, '?');

        if($position === false) {
            return $url;
        }
        $url = substr($url, 0, $position);
        return $url;
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}