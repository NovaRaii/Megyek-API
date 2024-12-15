<?php
namespace App\Repositories;

use App\Database\DB;

class BaseRepository extends DB
{
    protected $tableName;

    public function getAll(): array
    {
        $query = $this->select() . " ORDER BY name";
        $result = $this->mysqli->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function select(): string
    {
        return "SELECT * FROM `{$this->tableName}` ";
    }

    public function find(int $id): array
    {
        $query = $this->select() . " WHERE id = $id";
        $result = $this->mysqli->query($query)->fetch_assoc();
        return $result ?: [];
    }
    
    public function delete($id): string
    {
        $query = "DELETE FROM `{$this->tableName}` WHERE id = $id";
        return $this->mysqli->query($query); 
    }

    public function create(array $data): ?int
    {
        $sql = "INSERT INTO `%s` (%s) VALUES (%s)";
        $fields = '';
        $values = '';
        foreach ($data as $field => $value) {
            $fields .= ($fields ? ',' : '') . $field;
            $values .= ($values ? ',' : '') . "'$value'";
        }
        $sql = sprintf($sql, $this->tableName, $fields, $values);
        $this->mysqli->query($sql);

        $lastInserted = $this->mysqli->query("SELECT LAST_INSERT_ID() id;")->fetch_assoc();
        return $lastInserted['id'];
    }

    public function update(int $id, array $data)
    {
        $query = "UPDATE `{$this->tableName}` SET %s ";
        $fields = [];
        foreach ($data as $field => $value) {
            $fields[] = "$field = '$value'";
        }
        $query = sprintf($query, implode(', ', $fields));
        $query .= " WHERE id = $id";
        return $this->mysqli->query($query);
    }
}