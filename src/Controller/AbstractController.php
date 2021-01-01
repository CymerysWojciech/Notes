<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request;
use App\View;
use App\DataBase;
use App\Exception\ConfigurationException;

abstract class AbstractController
{
    protected const DEFAULT_ACTION = "list";

    protected static $configuration = [];
    protected DataBase $database;
    protected Request $request;
    protected View $view;

    public static function initConfiguration(array $configuration):void
    {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request)
    {
        if(empty(self::$configuration['db'])){
            throw new ConfigurationException('Configuration error');
        }
        $this->database = new DataBase(self::$configuration['db']);
        $this->request = $request;
        $this->view = new View();
    }
    public function run():void
    {
        $action = $this->action().'Action';
        if(!method_exists($this, $action))
        {
            $action = self::DEFAULT_ACTION;
        }else
        {
            $this->$action();
        }

    }
    private function action():string
    {
        return $this->request->getParam('action',self::DEFAULT_ACTION);
    }
    protected function redirect(string $to, array $params):void
    {
        $location = $to;

        if (count($params)) {
            $queryParams = [];
            foreach ($params as $key => $value) {
                $queryParams[] = urlencode($key) . '=' . urlencode($value);
            }
            $queryParams = implode('&', $queryParams);
            $location .= '?' . $queryParams;
        }

        header("Location: $location");
        exit;
    }
}