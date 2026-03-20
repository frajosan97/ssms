<?php

/**
 * FinAccountModel Model
 */

class FinAccountModel
{
    use Model;

    protected $table = 'sch_fin_accounts';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        'acc_key',
        'sch_token',
        'acc_bank_name',
        'acc_bank_branch_name',
        'acc_name',
        'acc_number',
        'acc_votes',
        'addby',
        'upby',
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
