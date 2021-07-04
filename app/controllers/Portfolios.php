<?php

class Portfolios extends Controller
{

    public function __construct()
    {
        $this->portfolioModel = $this->model('Portfolio');
    }


    public function show()
    {

        if (isset($_SESSION['user_id'])) {

            $data = [
                'coinSumValues' => [],
                'userNamesAndIDs' => []
            ];

            if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
                $userIDs = $this->portfolioModel->getAllUserIDs();
            } else {
                $userIDs = [$_SESSION['user_id']];
            }

            foreach ($userIDs as $userID) {

                $userName = $this->portfolioModel->getUserNameByUserID($userID);

                $data['userNamesAndIDs'][$userName] = $userID;

                $allTransactions = $this->portfolioModel->getAllTransactionsForUser($userID);

                $data['coinSumValues'][$userName] = $this->portfolioModel->getCoinSumValuesArray($allTransactions);
            }

            $this->view('portfolios/portfolio', $data);
        } else {
            $this->view('noaccess');
        }
    }


    public function transactions()
    {
        if (isset($_SESSION['user_id'])) {

            $data = [
                'transactions' => [],
                'userNamesAndIDs' => []
            ];

            if (isset($_SESSION['transactionAddSuccess'])) {
                $data['transactionAddSuccess'] = $_SESSION['transactionAddSuccess'];
                unset($_SESSION['transactionAddSuccess']);
            }

            if (isset($_SESSION['transactionDeleteSuccess'])) {
                $data['transactionDeleteSuccess'] = $_SESSION['transactionDeleteSuccess'];
                unset($_SESSION['transactionDeleteSuccess']);
            }

            if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
                $userIDs = $this->portfolioModel->getAllUserIDs();
            } else {
                $userIDs = [$_SESSION['user_id']];
            }

            foreach ($userIDs as $userID) {

                $userName = $this->portfolioModel->getUserNameByUserID($userID);

                $data['userNamesAndIDs'][$userName] = $userID;

                $data['transactions'][$userName] = [];
                $allTransactions = $this->portfolioModel->getAllTransactionsForUser($userID);

                foreach ($allTransactions as $transaction) {
                    $data['transactions'][$userName][] = [
                        'coinName' => $this->portfolioModel->getCoinNameFromID($transaction->coin_id)->name,
                        'date' => $transaction->date,
                        'coinValue' => $transaction->coinvalue,
                        'coinNum' => $transaction->coinnum,
                        'exchangeName' => $this->portfolioModel->getExchangeNameFromID($transaction->exchange_id)->name,
                        'id' => $transaction->id,
                        'user_id' => $transaction->user_id
                    ];
                }
            }

            $data['coins'] = $this->portfolioModel->getAllCoins();
            $data['exchanges'] = $this->portfolioModel->getAllExchanges();

            $this->view('portfolios/transactions', $data);
        } else {
            $this->view('noaccess');
        }
    }


    public function addTransaction()
    {

        if (isset($_SESSION['user_id'])) {

            if (isset($_POST['user_id']) && isset($_POST['coin_id']) && isset($_POST['date']) && isset($_POST['coinvalue']) && isset($_POST['coinnum']) && isset($_POST['exchange_id'])) {
                $added = $this->portfolioModel->addTransaction($_POST['user_id'], $_POST['coin_id'], $_POST['date'], $_POST['coinvalue'], $_POST['coinnum'], $_POST['exchange_id']);

                if ($added) {
                    $_SESSION['transactionAddSuccess'] = true;
                    header('location:http://' . URLROOT . '/portfolios/transactions');
                } else {
                    die("Could not add transaction, something went wrong.");
                }
            }
        }
    }


    public function edit_transaction($transactionID = null)
    {

        if (isset($_SESSION['user_id']) && $transactionID != null && $this->portfolioModel->checkAccess($_SESSION['user_id'], $transactionID)) {

            $transaction = $this->portfolioModel->getTransaction($transactionID);
            $data['transaction'] = $transaction;

            $data['transactionUser'] = $this->portfolioModel->getUserNameByTransactionID($transactionID);

            $data['exchangeName'] = $this->portfolioModel->getExchangeNameFromID($transaction->exchange_id);

            $data['allExchanges'] = $this->portfolioModel->getAllExchanges();
            $data['allCoins'] = $this->portfolioModel->getAllCoins();


            if (isset($_POST['transactionID']) && isset($_POST['userID']) && isset($_POST['coinID']) && isset($_POST['date']) && isset($_POST['coinValue']) && isset($_POST['coinNum']) && isset($_POST['exchangeID'])) {

                $success = $this->portfolioModel->updateTransaction($_POST['transactionID'], $_POST['userID'], $_POST['coinID'], $_POST['date'], $_POST['coinValue'], $_POST['coinNum'], $_POST['exchangeID']);

                if ($success) {
                    $transaction = $this->portfolioModel->getTransaction($transactionID);
                    $data['transaction'] = $transaction;

                    $data['updated'] = true;
                    $this->view('portfolios/edit-transaction', $data);
                } else {
                    die("nonono");
                }
            } else {
                $this->view('portfolios/edit-transaction', $data);
            }
        } else {
            $this->view('noaccess');
        }
    }


    public function delete_transaction($transactionID = null)
    {

        if (isset($_SESSION['user_id']) && $transactionID != null && $this->portfolioModel->checkAccess($_SESSION['user_id'], $transactionID)) {

            $result = $this->portfolioModel->deleteTransaction($transactionID);

            if (!is_object($result) && $result == true) {
                $_SESSION['transactionDeleteSuccess'] = true;
            } else {
                $_SESSION['transactionDeleteSuccess'] = false;
            }

            header('location:http://' . URLROOT . '/portfolios/transactions');
        } else {
            $this->view('noaccess');
        }
    }
}
