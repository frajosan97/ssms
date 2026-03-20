<?php

/**
 * InvoiceItemModel Model
 */

class InvoiceItemModel
{
    use Model;

    protected $table = 'sys_inv_items';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        "sch_token",
        "inv_key",
        "inv_item",
        "inv_item_amnt",
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
