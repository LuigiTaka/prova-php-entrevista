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

    public function all(): bool|array
    {
        $conn = $this->connection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll();
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
            $stmt->execute([$id]);
        } catch (\Throwable $e) {
            $conn->rollBack();
            throw $e;
        }
        $conn->commit();
        return true;
    }

    public function update(mixed $id, array $updateData)
    {
        $conn = $this->connection->getConnection();
        $cols = array_keys($updateData);
        $setStatements = array_map(fn($col) => "$col = ?", $cols);
        $setClause = implode(", ", $setStatements);

        $conn->beginTransaction();

        try {
            $query = "UPDATE $this->table SET $setClause WHERE id = ?";
            $stmt = $conn->prepare($query);
            $params = array_merge(array_values($updateData), [$id]);
            $stmt->execute($params);
        } catch (\Throwable $e) {
            $conn->rollBack();
            throw $e;
        }
        $conn->commit();

        return $this->id($id);
    }

    public function id(mixed $id)
    {
        $conn = $this->connection->getConnection();
        $query = <<<QUERY
SELECT * FROM $this->table WHERE id = ?
QUERY;
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

}