<?php

class Portfolio extends Model
{

    public function getAllTransactions()
    {

        $this->db->query("SELECT * FROM transactions");

        $result = $this->db->resultSet();

        return $result;
    }


    public function getAllTransactionsForUser($userid)
    {

        $this->db->query("SELECT * FROM transactions WHERE user_id = :user_id");
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


    public function getCoinSumValuesArray($transactions)
    {

        $coinIDs = $this->getCoinIDsFromTransactions($transactions);

        $coinSumValues = [];

        foreach ($coinIDs as $coinID) {
            $coinName = $this->getCoinNameFromID($coinID)->name;
            $coinSumValues[$coinName] = $this->getSumValueForCoin($coinID, $transactions);
        }

        return $coinSumValues;
    }

    public function getCoinNameFromID($coinID)
    {
        $this->db->query("SELECT name FROM coins WHERE id = :id");

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


    public function getAllCoins()
    {
        $this->db->query("SELECT * FROM coins");

        $coins =  $this->db->resultSet();

        return $coins;
    }


    public function getAllExchanges()
    {
        $this->db->query("SELECT * FROM exchanges");

        $exchanges =  $this->db->resultSet();

        return $exchanges;
    }



    public function getTransaction($transactionID)
    {
        $this->db->query('SELECT * FROM transactions WHERE id=:id');
        $this->db->bind(':id', $transactionID);

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


    public function checkAccess($userID, $transactionID)
    {

        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
            return true;
        } else {
            $this->db->query('SELECT * FROM transactions WHERE id = :id AND user_id = :user_id');
            $this->db->bind(':id', $transactionID);
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
