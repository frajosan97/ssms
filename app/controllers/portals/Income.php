<?php

/**
 * Income controller
 */

class Income
{
    use Controller;

    public function index()
    {
        $data = [];
        $app = new App;
        $incomeSource = $app->sch_income_source();
        if ($incomeSource) {
            $data['incomeSource'] = $incomeSource;
        }
        $this->view('Income', $data, __FUNCTION__);
    }

    public function create()
    {
        $FinIncomeSource = new FinIncomeSource;
        $sch_token = APPINFO->sch_token;
        $source_key = smartKey($sch_token . ' ' . $_POST['type'] . ' ' . $_POST['source']);
        if (!($FinIncomeSource->fetch(["source_key" => $source_key]))) {
            if (!($FinIncomeSource->insert(["source_key" => $source_key, "sch_token" => $sch_token, "source" => $_POST['source'], "type" => $_POST['type']]))) {
                echo "Source of income added successfully!";
            } else {
                echo "Error adding source of income";
            }
        } else {
            echo "Source of income exists already!";
        }
    }

    public function receive($source_key = "")
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $FinanceModel = new FinanceModel;
        } else {
            $data = [];
            $app = new App;
            $incomeSource = $app->sch_income_source();
            if ($incomeSource) {
                foreach ($incomeSource as $key => $value) {
                    if ($value->source_key == $source_key) {
                        $data['source'] = $value;
                    }
                }
            }
            $this->view('Income', $data, __FUNCTION__);
        }
    }

    public function statement()
    {
        $data = [];
        $this->view('Income', $data, __FUNCTION__);
    }
}
