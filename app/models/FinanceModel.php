<?php

/**
 * FinanceModel Model
 */

class FinanceModel
{
    use Model;

    protected $table = 'sch_finance';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        "sch_token",
        "fi_key",
        "fi_group",
        "fi_type",
        "fi_cat",
        "fi_studK",
        "fi_studF",
        "fi_studS",
        "fi_termK",
        "fi_acc",
        "fi_head",
        "fi_desc",
        "fi_amnt",
        "fi_payM",
        "fi_ref",
        "fi_sms",
        "fi_status",
        "fi_by",
        "fi_upby",
    ];

    public function validate($data)
    {
        $this->errors = [];

        /** DATA VALIDATION EXAMPLE START */
        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                $this->errors[] = strtoupper($key) . " - Cannot be empty";
            }
        }
        /** DATA VALIDATION EXAMPLE END */

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
