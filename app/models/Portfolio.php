<?php

class Portfolio extends Model
{

    public function getAllTransactions()
    {

        $this->db->query("SELECT * FROM transactions ORDER BY date ASC");

        $result = $this->db->resultSet();

        return $result;
    }


    public function getAllTransactionsForUser($userid)
    {

        $this->db->query("SELECT * FROM transactions WHERE user_id = :user_id ORDER BY date ASC");
        $this->db->bind(":user_id", $userid);

        $result = $this->db->resultSet();

        return $result;
    }


    public function getAllInputsOutputsForUser($userid)
    {

        $this->db->query("SELECT * FROM ios WHERE user_id = :user_id ORDER BY date ASC");
        $this->db->bind(":user_id", $userid);

        $result = $this->db->resultSet();

        return $result;
    }


    public function getCoinIDsFromTransactions($transactions)
    {
        $coins = [];

        foreach ($transactions as $row) {
            $coins[] = $row->coin_id;
        }

        return array_values(array_unique($coins));
    }


    public function getSumValueForCoin($coinid, $transactions)
    {

        $sum = 0;
        foreach ($transactions as $row) {
            if ($row->coin_id == $coinid) {
                $sum = $sum + floatval($row->coinnum);
            }
        }

        return $sum;
    }


    public function getSumValueForInputsOutputs($inputsOutputs)
    {

        $sum = 0;
        foreach ($inputsOutputs as $row) {
            $sum = $sum + floatval($row->amount);
        }

        return $sum;
    }


    public function getCoinSumValuesArray($transactions)
    {

        $coinIDs = $this->getCoinIDsFromTransactions($transactions);

        $coinSumValues = [];

        foreach ($coinIDs as $coinID) {
            $coinPrice = $this->getCoinNameFromID($coinID)->latestprice;
            $coinName = $this->getCoinNameFromID($coinID)->name;
            $sum = $this->getSumValueForCoin($coinID, $transactions);
            $totalValue = $sum * $coinPrice;
            $coinSumValues[$coinName] = ["sum" => $sum, 'price' => $coinPrice, "totalValue" => $totalValue];
        }

        return $coinSumValues;
    }

    public function getCoinNameFromID($coinID)
    {
        $this->db->query("SELECT * FROM coins WHERE id = :id");

        $this->db->bind(':id', $coinID);

        return $this->db->single();
    }


    public function getExchangeNameFromID($exchangeID)
    {
        $this->db->query("SELECT name FROM exchanges WHERE id = :id");

        $this->db->bind(':id', $exchangeID);

        return $this->db->single();
    }


    public function addTransaction($userid, $coinid, $date, $coinvalue, $coinnum, $exchangeid)
    {
        $this->db->query('INSERT INTO transactions (user_id, coin_id, date, coinvalue, coinnum, exchange_id) VALUES (:user_id, :coin_id, :date, :coinvalue, :coinnum, :exchange_id)');

        $this->db->bind(':user_id', $userid);
        $this->db->bind(':coin_id', $coinid);
        $this->db->bind(':date', $date);
        $this->db->bind(':coinvalue', $coinvalue);
        $this->db->bind(':coinnum', $coinnum);
        $this->db->bind(':exchange_id', $exchangeid);

        $success = $this->db->execute();

        return $success;
    }


    public function addInputOutput($userID, $date, $amount, $exchangeID)
    {
        $this->db->query('INSERT INTO ios (user_id, date, amount, exchange_id) VALUES (:user_id, :date, :amount, :exchange_id)');

        $this->db->bind(':user_id', $userID);
        $this->db->bind(':date', $date);
        $this->db->bind(':amount', $amount);
        $this->db->bind(':exchange_id', $exchangeID);

        $success = $this->db->execute();

        return $success;
    }


    public function getAllCoins()
    {
        $this->db->query("SELECT * FROM coins ORDER BY name ASC");

        $coins =  $this->db->resultSet();

        return $coins;
    }


    public function getAllExchanges()
    {
        $this->db->query("SELECT * FROM exchanges ORDER BY name ASC");

        $exchanges =  $this->db->resultSet();

        return $exchanges;
    }



    public function getTransaction($transactionID)
    {
        $this->db->query('SELECT * FROM transactions WHERE id=:id');
        $this->db->bind(':id', $transactionID);

        return $this->db->single();
    }


    public function getInputOutput($ioID)
    {
        $this->db->query('SELECT * FROM ios WHERE id=:id');
        $this->db->bind(':id', $ioID);

        return $this->db->single();
    }


    public function updateTransaction($transactionID, $userID, $coinID, $date, $coinValue, $coinNum, $exchangeID)
    {
        $this->db->query('UPDATE transactions SET coin_id = :coin_id, date = :date, coinvalue = :coinvalue, coinnum = :coinnum, exchange_id = :exchange_id WHERE id = :id');

        $this->db->bind(':coin_id',  $coinID);
        $this->db->bind(':date',  $date);
        $this->db->bind(':coinvalue',  $coinValue);
        $this->db->bind(':coinnum',  $coinNum);
        $this->db->bind(':exchange_id',  $exchangeID);
        $this->db->bind(':id',  $transactionID);

        $success = $this->db->execute();

        return $success;
    }


    public function updateInputOutput($ioID, $userID, $date, $amount, $exchangeID)
    {
        $this->db->query('UPDATE ios SET date = :date, amount = :amount, exchange_id = :exchange_id WHERE id = :id');

        $this->db->bind(':date',  $date);
        $this->db->bind(':amount',  $amount);
        $this->db->bind(':exchange_id',  $exchangeID);
        $this->db->bind(':id',  $ioID);

        $success = $this->db->execute();

        return $success;
    }


    public function deleteTransaction($transactionID)
    {
        $this->db->query('DELETE FROM transactions WHERE id = :id');
        $this->db->bind(':id', $transactionID);

        try {
            $success = $this->db->execute();
            return $success;
        } catch (Throwable $e) {
            return $e;
        }
    }


    public function deleteInputOutput($ioID)
    {
        $this->db->query('DELETE FROM ios WHERE id = :id');
        $this->db->bind(':id', $ioID);

        try {
            $success = $this->db->execute();
            return $success;
        } catch (Throwable $e) {
            return $e;
        }
    }


    public function checkAccess($userID, $ID, $type)
    {

        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
            return true;
        } elseif ($type == "transaction") {
            $this->db->query('SELECT * FROM transactions WHERE id = :id AND user_id = :user_id');
            $this->db->bind(':id', $ID);
            $this->db->bind(':user_id', $userID);

            $result = $this->db->single();

            if ($result != false) {
                return true;
            }
            return false;
        } elseif ($type == "input_output") {

            $this->db->query('SELECT * FROM ios WHERE id = :id AND user_id = :user_id');
            $this->db->bind(':id', $ID);
            $this->db->bind(':user_id', $userID);

            $result = $this->db->single();

            if ($result != false) {
                return true;
            }
            return false;
        }
    }


    public function getUserNameByTransactionID($transactionID)
    {
        $this->db->query('SELECT user_name FROM transactions as t INNER JOIN users as u ON t.user_id = u.user_id WHERE t.id = :transactionID');
        $this->db->bind(':transactionID', $transactionID);
        return $this->db->single()->user_name;
    }


    public function getUserNameByInputOutputID($ioID)
    {
        $this->db->query('SELECT user_name FROM ios as i INNER JOIN users as u ON i.user_id = u.user_id WHERE i.id = :ioID');
        $this->db->bind(':ioID', $ioID);
        return $this->db->single()->user_name;
    }


    public function getAllUserIDs()
    {
        $this->db->query('SELECT user_id FROM users');

        $users = $this->db->resultSet();

        $userIDs = [];

        foreach ($users as $user) {
            $userIDs[] = $user->user_id;
        }

        return $userIDs;
    }


    public function getUserNameByUserID($userID)
    {
        $this->db->query('SELECT user_name FROM users WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userID);
        return $this->db->single()->user_name;
    }
}
