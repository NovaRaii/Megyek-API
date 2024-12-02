<?php

namespace App\Repositories;

class CityRepository extends BaseRepository
{
    function __construct($host = self::HOST, $user = self::USER, $password = self::PASSWORD, $db = self::DATABASE)
    {
        parent::__construct($host, $user, $password, $db);
        $this->tableName = 'cities';
    }

    public function getAllCity(): array {
        $query = $this->select() . " ORDER BY city"; 
        error_log("Executing query: " . $query); 
    
        $result = $this->mysqli->query($query);
    
        if (!$result) {
            error_log("Query Error: " . $this->mysqli->error);
            return [];
        }
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findByCountyId(int $countyId): array {
        $query = $this->select() . " WHERE id_county = $countyId ORDER BY city";
        error_log("Executing query: " . $query); 

        $result = $this->mysqli->query($query);
    
        if (!$result) {
            error_log("Query Error: " . $this->mysqli->error);
            return [];
        }
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}