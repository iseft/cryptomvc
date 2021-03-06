<?php

class Coins extends Controller
{
    public function __construct()
    {
        $this->coinModel = $this->model('Coin');
    }

    public function show()
    {

        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {

            $coins = $this->coinModel->getAllCoins();

            $data = [
                'coins' => $coins
            ];

            if (isset($_SESSION['addedCoinName']) && isset($_SESSION['addedCoinSymbol'])) {
                $data['addedCoinName'] = $_SESSION['addedCoinName'];
                $data['addedCoinSymbol'] = $_SESSION['addedCoinSymbol'];
                unset($_SESSION['addedCoinName']);
                unset($_SESSION['addedCoinSymbol']);
            }

            if (isset($_SESSION['coinDeleteSuccess']) && isset($_SESSION['deletedCoinName'])) {
                $data['coinDeleteSuccess'] = $_SESSION['coinDeleteSuccess'];
                $data['deletedCoinName'] = $_SESSION['deletedCoinName'];
                unset($_SESSION['coinDeleteSuccess']);
                unset($_SESSION['deletedCoinName']);
            }

            $this->view("coins/coins", $data);
        } else {
            $this->view('noaccess');
        }
    }


    public function add()
    {

        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {

            if (isset($_POST['coinname']) && isset($_POST['coinsymbol']) && isset($_POST['apiID'])) {
                $added = $this->coinModel->addCoin($_POST['coinname'], $_POST['coinsymbol'], $_POST['apiID']);

                if ($added) {
                    $_SESSION['addedCoinName'] = $_POST['coinname'];
                    $_SESSION['addedCoinSymbol'] = $_POST['coinsymbol'];
                    header('location:https://' . URLROOT . '/coins/show');
                } else {
                    die("Could not add coin, something went wrong.");
                }
            }
        }
    }


    public function edit($coinID)
    {

        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {

            $coin = $this->coinModel->getCoin($coinID);
            $data['coin'] = $coin;

            if (isset($_POST['coinID']) && isset($_POST['coinName']) && isset($_POST['coinSymbol']) && isset($_POST['apiID'])) {
                $success = $this->coinModel->updateCoin($_POST['coinID'], $_POST['coinName'], $_POST['coinSymbol'], $_POST['apiID']);

                if ($success) {
                    $coin = $this->coinModel->getCoin($coinID);
                    $data['coin'] = $coin;

                    $data['updated'] = true;
                    $this->view('coins/edit_coin', $data);
                } else {
                    die("nonono");
                }
            } else {

                $this->view('coins/edit_coin', $data);
            }
        }
    }


    public function delete($coinID = null)
    {

        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {

            $_SESSION['deletedCoinName'] = $this->coinModel->getCoinNameFromID($coinID);

            $result = $this->coinModel->deleteCoin($coinID);

            if (!is_object($result) && $result == true) {
                $_SESSION['coinDeleteSuccess'] = true;
            } else {
                $_SESSION['coinDeleteSuccess'] = false;
            }
            
            header('location:https://' . URLROOT . '/coins/show');
        } else {
            $this->view('noaccess');
        }
    }


    public function updatePrice() {
        $this->coinModel->updateCoinPrices();
    }
}
