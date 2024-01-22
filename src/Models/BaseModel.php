<?php

namespace TestePratico\Models;

use TestePratico\Connection;
use Throwable;

abstract class BaseModel
{

    protected string $table = "";

    public function __construct(
        private Connection $connection
    )
    {

    }

    /**
     * @throws Throwable
     */
    public function insert(array $data): string|bool
    {
        $conn = $this->connection->getConnection();
        $cols = array_keys($data);
        $colsPlaceholder = implode(",", $cols);
        $valuesPlaceholder = implode(",", array_fill(0, count($data), "?"));
        $conn->beginTransaction();
        try {
            $query = "INSERT INTO $this->table ($colsPlaceholder) VALUES($valuesPlaceholder)";
            $stmt = $conn->prepare($query);
            $stmt->execute(array_values($data));
            $lastInsertId = $conn->lastInsertId();
        } catch (Throwable $e) {
            $conn->rollBack();
            throw $e;
        }

        $conn->commit();
        return $lastInsertId;
    }


    /**
     * @throws Throwable
     */
    public function delete(mixed $id): bool
    {
        $conn = $this->connection->getConnection();
        $query = <<<QUERY
DELETE FROM $this->table WHERE id = ?
QUERY;
        $conn->beginTransaction();
        try {
            $stmt = $conn->prepare($query);
            $stmt->execute( [ $id ] );
        }catch (\Throwable $e){
            $conn->rollBack();
            throw $e;
        }
        $conn->commit();
        return true;
    }
}