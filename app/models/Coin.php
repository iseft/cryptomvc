<?php

class Coin extends Model
{

    public function getAllCoins()
    {
        $this->db->query("SELECT * FROM coins ORDER BY name ASC");

        $coins =  $this->db->resultSet();

        return $coins;
    }


    public function getCoin($coinID)
    {
        $this->db->query('SELECT * FROM coins WHERE id=:id');
        $this->db->bind(':id', $coinID);

        return $this->db->single();
    }


    public function addCoin($coinname, $coinsymbol, $apiID)
    {
        $this->db->query("INSERT INTO coins (name, symbol, api_id) VALUES (:name, :symbol, :api_id)");
        $this->db->bind(':name', $coinname);
        $this->db->bind(':symbol', $coinsymbol);
        $this->db->bind(':api_id', $apiID);
        $success = $this->db->execute();

        return $success;
    }


    public function updateCoin($coinID, $coinName, $coinSymbol, $apiID)
    {
        $this->db->query("UPDATE coins SET name = :name, symbol = :symbol, api_id = :api_id WHERE id = :id");
        $this->db->bind(':name', $coinName);
        $this->db->bind(':symbol', $coinSymbol);
        $this->db->bind(':id', $coinID);
        $this->db->bind(':api_id', $apiID);

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


    public function getCoinNameFromID($coinID)
    {
        $this->db->query('SELECT * FROM coins WHERE id=:id');
        $this->db->bind(':id', $coinID);
        return $this->db->single()->name;
    }


    public function updateCoinPrices()
    {

        $allCoins = $this->getAllCoins();

        foreach ($allCoins as $coin) {

            if ($coin->api_id != null) {

                try {
                    $price = $this->getCoinPrice($coin->api_id);
                    $this->updateCoinPrice($coin->api_id, $price);
                } catch (\Throwable $th) {
                    die("Could not get coin price.");
                }
            }
        }

        header('location:http://' . URLROOT . '/portfolios/show');
    }


    public function getCoinPrice($api_id)
    {
        $response = file_get_contents("https://api.coingecko.com/api/v3/coins/$api_id");

        $price = json_decode($response, true)['market_data']['current_price']['usd'];

        return $price;
    }


    public function updateCoinPrice($apiID, $price)
    {
        $this->db->query('UPDATE coins SET latestprice = :latestprice WHERE api_id = :api_id');
        $this->db->bind(':latestprice', $price);
        $this->db->bind(':api_id', $apiID);
        $this->db->execute();
    }
}
