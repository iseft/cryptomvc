<?php

class Coin extends Model
{

    public function getAllCoins()
    {
        $this->db->query("SELECT * FROM coins");

        $coins =  $this->db->resultSet();

        return $coins;
    }


    public function getCoin($coinID)
    {
        $this->db->query('SELECT * FROM coins WHERE id=:id');
        $this->db->bind(':id', $coinID);

        return $this->db->single();
    }


    public function addCoin($coinname, $coinsymbol)
    {
        $this->db->query("INSERT INTO coins (name, symbol) VALUES (:name, :symbol)");
        $this->db->bind(':name', $coinname);
        $this->db->bind(':symbol', $coinsymbol);
        $success = $this->db->execute();

        return $success;
    }


    public function updateCoin($coinID, $coinName, $coinSymbol)
    {
        $this->db->query("UPDATE coins SET name = :name, symbol = :symbol WHERE id = :id");
        $this->db->bind(':name', $coinName);
        $this->db->bind(':symbol', $coinSymbol);
        $this->db->bind(':id', $coinID);

        $success = $this->db->execute();

        return $success;
    }


    public function deleteCoin($coinID)
    {
        $this->db->query('DELETE FROM coins WHERE id = :id');
        $this->db->bind(':id', $coinID);

        try {
            $success = $this->db->execute();
            return $success;
        } catch (Throwable $e) {
            return $e;
        }
    }

    
    public function getCoinNameFromID($coinID) {
        $this->db->query('SELECT * FROM coins WHERE id=:id');
        $this->db->bind(':id', $coinID);
        return $this->db->single()->name;
    }
}
