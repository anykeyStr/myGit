<?php
if (!isset($_SESSION)) session_start ();

class DatabaseController
{
    protected $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=localhost;dbname=total;charset=utf8", 'root', '');
        } catch (PDOException $e) {
            throw new Exception("Could not connect to database: " . $e->getMessage());
        }
    }

    public function request($query, $params = [])
    {
        $statement = $this->prepareStatement($query);
        $statement->execute($params);
      //  return $statement->fetch(PDO::FETCH_ASSOC);
        $sh = $statement->fetch(PDO::FETCH_ASSOC);
        return $sh;
    }

    public function request_all($query, $params = [])
    {
        $statement = $this->prepareStatement($query);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function prepareStatement($query)
    {
        try {
            return $this->connection->prepare($query);
        } catch (PDOException $e) {
            throw new Exception("Could not prepare statement: " . $e->getMessage());
        }
    }
}
