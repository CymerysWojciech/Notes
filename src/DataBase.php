<?php

declare(strict_types=1);

namespace App;

require_once 'Exception/StorageException.php';
require_once 'Exception/NotFoundException.php';

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Exception\StorageException;
use Exception;
use PDO;
use Throwable;

class DataBase
{
    private PDO $conn;
    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $this->createConnection($config);
        }catch (\PDOExceptionS $e){
            throw new StorageException('<div class="alert alert-warning">Connection error</div>');
        }
    }
    public function createNote(array $date):void
    {
       try{
           $title = $this->conn->quote($date['title']);
           $description = $this->conn->quote($date['description']);
           $created = date('Y-m-d H:i:s');
            $query = "INSERT INTO notes(title, description, created) VALUES ($title,$description,'$created')";

            $this->conn->exec($query);
       } catch (Throwable $e){
            throw new StorageException('<div class="alert alert-warning">Nie udało sie stworzyć notatki</div>');
       }
    }
    public function getNote(int $id):array
    {
        try {
            $query = "SELECT * FROM notes WHERE id=$id";
            $result = $this->conn->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);

        }catch (Throwable $e)
        {
            throw new StorageException('Nie udało pobrać notatki');
        }

        if(!$note){
            throw new NotFoundException("Notatka o id: $id nie istnieje");
        }

        return $note;
    }
    public function getNotes():array
    {
        try {
            $query = "SELECT id, title, created FROM notes";
            $result = $this->conn->query($query);
            return  $result->fetchAll(PDO::FETCH_ASSOC);
        }catch (Throwable $e){
            throw new StorageException('<div class="alert alert-warning">Nie udało się utworzyć nowej notatki</div>');
        }
    }
    private function createConnection(array $config):void
    {
        $dns = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO(
            $dns,
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
            ]
        );
    }
    private function validateConfig(array $config):void
    {
        if(empty($config['database'])
            || empty($config['host'])
            || empty($config['user'])
            || empty($config['password'])
        ){
            throw new ConfigurationException('<div class="alert alert-warning">Storage configuration error</div>');
        }
    }

}