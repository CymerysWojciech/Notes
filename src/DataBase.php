<?php

declare(strict_types=1);

namespace App;

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
    public function deleteNote(int $id):void
    {
        try
        {
            $query = "DELETE FROM notes WHERE id=$id LIMIT 1 ";
            $this->conn->exec($query);
        }
        catch (Throwable $e)
        {
            throw new StorageException('Nie udało się usunąć notatki');
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
    public function searchNotes(string $phrase, int $pageNumber, int $pageSize, string $sortBy, string $sortOrder):array
    {
        try {
            $limit = $pageSize;
            $offset = ($pageNumber-1) * $pageSize;
            if(!in_array($sortBy, ['created', 'title']))
            {
                $sortBy = 'title';

            }
            if(!in_array($sortOrder, ['asc', 'desc']))
            {
                $sortOrder = 'desc';
            }

            $phrase =$this->conn->quote('%'. $phrase . '%', PDO::PARAM_STR);


            $query = "SELECT id, title, created 
                      FROM notes
                      WHERE title LIKE($phrase)
                      ORDER BY $sortBy $sortOrder
                      LIMIT $offset, $limit";
            $result = $this->conn->query($query);
            return  $result->fetchAll(PDO::FETCH_ASSOC);
        }catch (Throwable $e){
            throw new StorageException('Nie udało się wyszukać notatek');
        }
    }
    public function getsearchCount(string $phrase):int
    {
        try {
            $phrase =$this->conn->quote('%'. $phrase . '%', PDO::PARAM_STR);

            $query = "SELECT count(*) AS cm FROM notes WHERE title LIKE ($phrase)";
            $result = $this->conn->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            if($result === false)
            {
                throw new StorageException('Błąd przy prubie pobierania ilości notatek');
            }
            return (int)$result['cm'];
        }catch (Throwable $e)
        {
            throw new StorageException('Nie udało się pobrać informacji o liście notatek 1', 100, $e);
        }

    }
    public function getNotes(int $pageNumber, int $pageSize, string $sortBy, string $sortOrder):array
    {

        try {
            $limit = $pageSize;
            $offset = ($pageNumber-1) * $pageSize;
            if(!in_array($sortBy, ['created', 'title']))
            {
                $sortBy = 'title';

            }
            if(!in_array($sortOrder, ['asc', 'desc']))
            {
                $sortOrder = 'desc';
            }


            $query = "SELECT id, title, created 
                      FROM notes
                      ORDER BY $sortBy $sortOrder
                      LIMIT $offset, $limit";
            $result = $this->conn->query($query);
            return  $result->fetchAll(PDO::FETCH_ASSOC);
        }catch (Throwable $e){
            throw new StorageException('<div class="alert alert-warning">Nie udało się pobrać nowej notatki</div>');
        }
    }
    public function getCount():int
    {
        try {
            $query = "SELECT count(*) AS cm FROM notes";
            $result = $this->conn->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            if($result === false)
            {
                throw new StorageException('Błąd przy prubie pobierania ilości notatek');
            }
            return (int)$result['cm'];
        }catch (Throwable $e)
        {
            throw new StorageException('Nie udało się pobrać informacji o liście notatek 2');
        }
    }
    public function editNote(int $id, array $data):void
    {
        try
        {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $query = "UPDATE notes 
                      SET title = $title, description = $description 
                      WHERE id = $id";
            $this->conn->exec($query);
        }catch (Throwable $e)
        {
            throw new StorageException('Nie udało się zaktualizować notatki');
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