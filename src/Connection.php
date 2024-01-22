<?php

namespace TestePratico;

use PDO;

class Connection
{

    private string|false $databaseFile;
    private PDO $connection;

    public function __construct()
    {
        $this->databaseFile = realpath(__DIR__ . "/../database/db.sqlite");
        $this->connect();
    }

    private function connect(): PDO
    {
        return $this->connection = new \PDO("sqlite:{$this->databaseFile}");
    }

    public function getConnection(): PDO
    {
        return $this->connection ?: $this->connection = $this->connect();
    }

    public function query($query): bool|\PDOStatement
    {
        $result = $this->getConnection()->query($query);

        $result->setFetchMode(PDO::FETCH_INTO, new \stdClass);

        return $result;
    }
}