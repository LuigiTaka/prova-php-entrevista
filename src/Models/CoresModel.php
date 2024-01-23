<?php

namespace TestePratico\Models;

class CoresModel extends BaseModel
{
    protected string $table = "colors";


    public function getCoresByUserId(string $id): bool|array
    {
        $query = <<<SQL
SELECT C.* FROM user_colors as UC LEFT JOIN colors as C ON C.id = UC.color_id WHERE UC.user_id = ?
SQL;
        $conn = $this->connection->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}