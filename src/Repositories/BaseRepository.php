<?php

namespace App\Repositories;

use App\Database\DB;

class BaseRepository extends DB
{
    protected string $tableName;

    public function getAll(): array
    {
        $query = $this->select() . "ORDER BY name";

        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function select(): string
    {
        return "SELECT * FROM `{$this->tableName}` ";
    }

    public function find($id): array 
    {
        $query = "SELECT * FROM `{$this->tableName}` WHERE id = {$id}";
        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function delete($id) {
        $query = "SELECT * FROM `{$this->tableName}` WHERE id = {$id}";
        return $query;
    }

}
