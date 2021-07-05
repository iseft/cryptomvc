<?php

class Exchange extends Model
{

    public function getAllExchanges()
    {
        $this->db->query("SELECT * FROM exchanges ORDER BY name ASC");

        $exchanges =  $this->db->resultSet();

        return $exchanges;
    }


    public function addExchange($exchangename)
    {
        $this->db->query("INSERT INTO exchanges (name) VALUES (:name)");
        $this->db->bind(':name', $exchangename);
        $success = $this->db->execute();

        return $success;
    }


    public function getExchange($exchangeID)
    {
        $this->db->query('SELECT * FROM exchanges WHERE id=:id');
        $this->db->bind(':id', $exchangeID);

        return $this->db->single();
    }


    public function updateExchange($exchangeID, $exchangeName)
    {
        $this->db->query("UPDATE exchanges SET name = :name WHERE id = :id");
        $this->db->bind(':name', $exchangeName);
        $this->db->bind(':id', $exchangeID);

        $success = $this->db->execute();

        return $success;
    }


    public function getExchangeNameFromID($exchangeID)
    {
        $this->db->query("SELECT name FROM exchanges WHERE id = :id");

        $this->db->bind(':id', $exchangeID);

        return $this->db->single()->name;
    }


    public function deleteExchange($exchangeID)
    {
        $this->db->query('DELETE FROM exchanges WHERE id = :id');
        $this->db->bind(':id', $exchangeID);

        try {
            $success = $this->db->execute();
            return $success;
        } catch (Throwable $e) {
            return $e;
        }
    }
}
