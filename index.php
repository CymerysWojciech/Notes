<?php
declare(strict_types=1);

spl_autoload_register(function (string $classNamespace)
    {
      $name = str_replace(['\\', 'App/'], ['/',''], $classNamespace);
      $path = "src/$name.php";
        if (!empty($path)) {
            require_once($path);
        }
    }
);

require_once 'src/utils/debug.php';
$configuration = require_once("config/config.php");

use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Request;
use App\Exception\AppException;
use App\Exception\ConfigurationException;

$request = new Request($_GET, $_POST, $_SERVER);

try {
    AbstractController::initConfiguration($configuration);
    (new NoteController($request))->run();
}catch (ConfigurationException $e){
    echo 'Wystopił błąd w aplikacji ' ;
    echo $e->getMessage();
}catch (AppException $e){

    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo '<h3>' . $e->getMessage() . '</h3>';

}catch (\Throwable $e){
    echo '<div class="alert alert-warning">Wystopił błąd aplikacji</div>';
    echo '<h3>' . $e->getMessage() . '</h3>';
}