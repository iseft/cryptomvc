<?php

class Exchanges extends Controller
{
    public function __construct()
    {
        $this->exchangeModel = $this->model('Exchange');
    }

    public function show()
    {

        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
            $exchanges = $this->exchangeModel->getAllExchanges();

            $data = [
                'exchanges' => $exchanges
            ];

            if (isset($_SESSION['addedExchangeName'])) {
                $data['addedExchangeName'] = $_SESSION['addedExchangeName'];
                unset($_SESSION['addedExchangeName']);
            }

            if (isset($_SESSION['exchangeDeleteSuccess']) && isset($_SESSION['deletedExchangeName'])) {
                $data['exchangeDeleteSuccess'] = $_SESSION['exchangeDeleteSuccess'];
                $data['deletedExchangeName'] = $_SESSION['deletedExchangeName'];
                unset($_SESSION['exchangeDeleteSuccess']);
                unset($_SESSION['deletedExchangeName']);
            }

            $this->view("exchanges/exchanges_show", $data);
        } else {
            $this->view('noaccess');
        }
    }


    public function add()
    {

        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {

            if (isset($_POST['exchangename'])) {
                $added = $this->exchangeModel->addExchange($_POST['exchangename']);

                if ($added) {
                    $_SESSION['addedExchangeName'] = $_POST['exchangename'];
                    header('location:https://' . URLROOT . '/exchanges/show');
                } else {
                    die("Could not add exchange, something went wrong.");
                }
            }
        }
    }


    public function edit($exchangeID = null)
    {

        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {

            $exchange = $this->exchangeModel->getExchange($exchangeID);
            $data['exchange'] = $exchange;

            if (isset($_POST['exchangeID']) && isset($_POST['exchangeName'])) {
                $success = $this->exchangeModel->updateExchange($_POST['exchangeID'], $_POST['exchangeName']);

                if ($success) {
                    $exchange = $this->exchangeModel->getExchange($exchangeID);
                    $data['exchange'] = $exchange;

                    $data['updated'] = true;
                    $this->view('exchanges/edit_exchange', $data);
                } else {
                    die("nonono");
                }
            } else {

                $this->view('exchanges/edit_exchange', $data);
            }
        } else {
            $this->view('noaccess');
        }
    }



    public function delete($exchangeID = null)
    {

        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {

            $_SESSION['deletedExchangeName'] = $this->exchangeModel->getExchangeNameFromID($exchangeID);

            $result = $this->exchangeModel->deleteExchange($exchangeID);

            if (!is_object($result) && $result == true) {
                $_SESSION['exchangeDeleteSuccess'] = true;
            } else {
                $_SESSION['exchangeDeleteSuccess'] = false;
            }

            header('location:https://' . URLROOT . '/exchanges/show');
        } else {
            $this->view('noaccess');
        }
    }
}
