<?php

/**
 * FinExpItemModel Model
 */

class FinExpItemModel
{
    use Model;

    protected $table = 'sch_fin_exp_items';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        'exp_item_key',
        'sch_token',
        'fi_key',
        'exp_item',
        'exp_item_amnt',
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
