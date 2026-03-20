<?php

/**
 * PaymentModel Model
 */

class PaymentModel
{
    use Model;

    protected $table = 'sys_payments';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        "sch_token",
        "pay_key",
        "inv_key",
        "pay_mode",
        "pay_trans_code",
        "pay_amnt",
        "addby",
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