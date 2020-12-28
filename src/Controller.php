<?php
declare(strict_types=1);

namespace App;

require_once 'src/View.php';


class Controller
{
    private const DEFAULT_ACTION = "list";
    private $request;
    private View $view;
    public function __construct($request)
    {
        $this->request = $request;
        $this->view = new View();
    }
    public function run():void
    {
        $viewParams = [];
        switch ($this->action())
        {
            case 'create':
                $page = 'create';
                $created = false;
                $data = $this->getRequestPost();
                if (!empty($_POST))
                {
                    $created = true;
                    $viewParams=[
                        'title' => $data['title'],
                        'description' => $data['description']
                    ];
                }
                $viewParams['created']=$created;
                break;
            case 'show':
                break;
            default:
                $page = 'list';

                break;
        }
        $this->view->render($page, $viewParams);
    }
    private function action():string
    {
        $data = $this->getRequestGet();
        return $data['action'] ?? self::DEFAULT_ACTION;
    }
    private function getRequestGet():array
    {
       return $this->request['get'] ??[];
    }
    private function getRequestPost():array
    {
        return $this->request['post'] ?? [];
    }

}