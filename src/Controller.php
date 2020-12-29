<?php
declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use Throwable;

require_once 'src/View.php';
require_once 'src/DataBase.php';
require_once 'src/Exception/ConfigurationException.php';

class Controller
{
    private const DEFAULT_ACTION = "list";

    private static $configuration = [];
    private DataBase $database;
    private $request;
    private View $view;

    public static function initConfiguration(array $configuration):void
    {
        self::$configuration = $configuration;
    }

    public function __construct($request)
    {
        if(empty(self::$configuration['db'])){
            throw new ConfigurationException('<div class="alert alert-warning">Configuration error</div>');
        }
        $this->database = new DataBase(self::$configuration['db']);
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
                $data = $this->getRequestPost();
                if (!empty($data)) {
                    $noteData = [
                        'title' => $data['title'],
                        'description' => $data['description']
                    ];
                    $this->database->createNote($noteData);
                    header('Location: /notes/?before=created');
                }
                break;
            case 'show':
                $page = 'show';
                $data = $this->getRequestGet();
                $noteId =(int) ($data['id'] ?? null);

                if(!$noteId)
                {
                    header('Location:/Notes/?error=missingNotId');
                    exit;
                }

                try {
                    $viewParams = [
                        'note' => $this->database->getNote($noteId)
                    ];
                }catch (NotFoundException $e){
                    header('Location:/Notes/?error=noteNotFound');
                    exit;
                }
                break;
            default:
                $page = 'list';
                $data = $this->getRequestGet();
                $viewParams = [
                    'notes' => $this->database->getNotes(),
                    'before' => $data['before'] ?? null,
                    'error' => $data['error'] ?? null
               ] ;

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