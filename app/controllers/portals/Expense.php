<?php

use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

/**
 * Expense controller
 */

class Expense
{
    use Controller;

    public function index()
    {
        $data = [];
        $appData = new App;
        $allExpenses = $appData->sch_finance();
        if ($allExpenses) {
            foreach ($allExpenses as $key => $value) {
                if ($value->fi_type == "expense") {
                    $data['expense'][] = $value;
                }
            }
        }
        $this->view('Expense', $data, __FUNCTION__);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $invoiceSum = array_sum($_POST['exp_amnt']);
            if ($invoiceSum > 0) {
                $FinanceModel = new FinanceModel;
                $FinExpItemModel = new FinExpItemModel;
                if (!($FinanceModel->fetch(["fi_key" => $_POST['fi_key']]))) {
                    foreach ($_POST as $key => $value) {
                        if (!(is_array($value))) {
                            $expPostData[$key] = $value;
                        }
                    }
                    $expPostData['sch_token'] = APPINFO->sch_token;
                    $expPostData['fi_amnt'] = $invoiceSum;
                    $expPostData['fi_by'] = CURRENTUSER;
                    if (isset($expPostData)) {
                        if (!($FinanceModel->insert($expPostData))) {
                            foreach ($_POST['exp_item'] as $key => $value) {
                                $itemKey = smartKey($value . " " . time());
                                $itemAmnt = $_POST['exp_amnt'][$key];
                                if ($itemAmnt > 0) {
                                    if ($FinExpItemModel->fetch(["exp_item_key" => $itemKey])) {
                                        $FinExpItemModel->update($itemKey, ["fi_key" => $_POST['fi_key'], "exp_item" => $value, "exp_item_amnt" => $itemAmnt, "upby" => CURRENTUSER], "exp_item_key");
                                    } else {
                                        $FinExpItemModel->insert(["exp_item_key" => $itemKey, "sch_token" => APPINFO->sch_token, "fi_key" => $_POST['fi_key'], "exp_item" => $value, "exp_item_amnt" => $itemAmnt, "addby" => CURRENTUSER]);
                                    }
                                }
                            }
                            if (setcookie("recent_exp_inv", $_POST['fi_key'], time() + (365 * 24 * 60 * 60), "/")) {
                                echo "Expense invoice added successfully!";
                            }
                        } else {
                            echo "Error adding the expense record, kindy try again!";
                        }
                    } else {
                        echo "Error adding the expense record, kindy try again!";
                    }
                } else {
                    echo "This expense already exists in our database!";
                }
            } else {
                echo "Expense Invoice total cannot be zero (0)!";
            }
        } else {
            $data = [];
            $this->view('Expense', $data, __FUNCTION__);
        }
    }

    public function update($expenseKey = "")
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $invoiceSum = array_sum($_POST['exp_amnt']);
            if ($invoiceSum > 0) {
                $FinanceModel = new FinanceModel;
                $FinExpItemModel = new FinExpItemModel;
                if ($FinanceModel->fetch(["fi_key" => $_POST['updateKey']])) {
                    foreach ($_POST as $key => $value) {
                        if (!(is_array($value))) {
                            $expPostData[$key] = $value;
                        }
                    }
                    $expPostData['fi_amnt'] = $invoiceSum;
                    $expPostData['fi_upby'] = CURRENTUSER;
                    if (isset($expPostData)) {
                        if (!($FinanceModel->update($_POST['updateKey'], $expPostData, "fi_key"))) {
                            foreach ($_POST['exp_item'] as $key => $value) {
                                $itemKey = $_POST['exp_item_key'][$key];
                                $itemAmnt = $_POST['exp_amnt'][$key];
                                if ($itemAmnt > 0) {
                                    if ($FinExpItemModel->fetch(["exp_item_key" => $itemKey])) {
                                        $FinExpItemModel->update($itemKey, ["fi_key" => $_POST['updateKey'], "exp_item" => $value, "exp_item_amnt" => $itemAmnt, "upby" => CURRENTUSER], "exp_item_key");
                                    } else {
                                        $FinExpItemModel->insert(["exp_item_key" => $itemKey, "sch_token" => APPINFO->sch_token, "fi_key" => $_POST['updateKey'], "exp_item" => $value, "exp_item_amnt" => $itemAmnt, "addby" => CURRENTUSER]);
                                    }
                                }
                            }
                            if (setcookie("recent_exp_inv", $_POST['updateKey'], time() + (365 * 24 * 60 * 60), "/")) {
                                echo "Expense invoice added successfully!";
                            }
                        } else {
                            echo "Error adding the expense record, kindy try again!";
                        }
                    } else {
                        echo "Error adding the expense record, kindy try again!";
                    }
                } else {
                    echo "You cannot update a none existing expense invoice!";
                }
            } else {
                echo "Expense Invoice total cannot be zero (0)!";
            }
        } else {
            $data = [];
            $app = new App;
            $expenseData = $app->expInvInfo($expenseKey);
            if ($expenseData) {
                $data['expenseInfo'] = $expenseData;
            }
            $this->view('Expense', $data, __FUNCTION__);
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $FinanceModel = new FinanceModel;
            $FinExpItemModel = new FinExpItemModel;
            if (!($FinExpItemModel->delete($_POST['fi_key'], "fi_key"))) {
                if (!($FinanceModel->delete($_POST['fi_key'], "fi_key"))) {
                    echo "Expense invoice deleted successfully!";
                } else {
                    echo "Error deleting the expense";
                }
            } else {
                echo "Error deleting the expense";
            }
        }
    }
}
