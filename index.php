<?php
declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;

require_once 'src/utils/debug.php';
require_once 'src/Controller.php';
require_once 'src/Exception/AppException.php';

$configuration = require_once("config/config.php");

$request = [
    'get'=> $_GET,
    'post' => $_POST
];

try {
    Controller::initConfiguration($configuration);
    (new Controller($request))->run();
}catch (ConfigurationException $e){
    echo '<div class="alert alert-warning">Wystopił błąd w aplikacji<br>Prosze skontaktowaś się z administrorem </div>';
}catch (AppException $appException){
    echo '<div class="alert alert-warning">Wystopił błąd w aplikacji. ' . $appException->getMessage().'</div>';

}catch (\Throwable $e){
    echo '<div class="alert alert-warning">Wystopił błąd aplikacji</div>';
}