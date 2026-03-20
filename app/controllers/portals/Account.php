<?php

/**
 * Account controller
 */

class Account
{
    use Controller;

    public function index()
    {
        $data = [];
        $appData = new App;
        $schAcc = $appData->sch_fin_accounts();
        if ($schAcc)
            $data['account'] = $schAcc;
        $this->view('Account', $data, __FUNCTION__);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $appData = new App;
            $FinAccountModel = new FinAccountModel;
            $schToken = $appData->schoolToken;
            $accKey = smartKey($schToken . " " . $_POST['acc_name']);
            if (!($FinAccountModel->fetch(array("acc_key" => $accKey)))) {
                $acc_votes = [];
                if (isset($_POST['acc_votes'])) {
                    $acc_votes = $_POST['acc_votes'];
                }
                $acc_votes = implode(",", $acc_votes);
                if (!($FinAccountModel->insert(['acc_key' => $accKey, 'sch_token' => $schToken, 'acc_bank_name' => $_POST['acc_bank_name'], 'acc_bank_branch_name' => $_POST['acc_bank_branch_name'], 'acc_name' => $_POST['acc_name'], 'acc_number' => $_POST['acc_number'], 'acc_votes' => $acc_votes, 'addby' => CURRENTUSER]))) {
                    echo "Account added successfully!";
                } else {
                    echo "Error adding account to the system, kindly try again!";
                }
            } else {
                echo "This account already exists in our database!";
            }
        } else {
            $data = [];
            $this->view('Account', $data, __FUNCTION__);
        }
    }

    public function read($accKey = "")
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $FinAccountModel = new FinAccountModel;
            $accKey = $_POST['acc_key'];
            if ($FinAccountModel->fetch(array("acc_key" => $accKey))) {
                $acc_votes = [];
                if (isset($_POST['acc_votes'])) {
                    $acc_votes = $_POST['acc_votes'];
                }
                $acc_votes = implode(",", $acc_votes);
                // post array
                if (!($FinAccountModel->update($accKey, ['acc_bank_name' => $_POST['acc_bank_name'], 'acc_bank_branch_name' => $_POST['acc_bank_branch_name'], 'acc_name' => $_POST['acc_name'], 'acc_number' => $_POST['acc_number'], 'acc_votes' => $acc_votes, 'upby' => CURRENTUSER], "acc_key"))) {
                    echo "Account updated successfully!";
                } else {
                    echo "Error updating account to the system, kindly try again!";
                }
            } else {
                echo "This account you are trying to update does not exists!";
            }
        } else {
            $data = [];
            $appData = new App;
            $accVotes = $appData->sch_fin_acc_votes($accKey);
            if ($accVotes) {
                $data['account'] = $accVotes['acc'];
                $data['accVotes'] = explode(",", $accVotes['acc']->acc_votes);
            } else {
                $data['notFount'] = "Account record not found!";
            }
            $this->view('Account', $data, __FUNCTION__);
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $FinAccountModel = new FinAccountModel;
            if (!($FinAccountModel->delete($_POST['id']))) {
                echo "Account deleted successfully!";
            } else {
                echo "Error deleting the account to the system, kindly try again!";
            }
        }
    }
}
