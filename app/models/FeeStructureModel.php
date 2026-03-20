<?php

/**
 * FeeStructureModel Model
 */

class FeeStructureModel
{
    use Model;

    protected $table = 'sch_fin_structure';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        "unique_key",
        "sch_token",
        "vote_key",
        "class",
        "term",
        "category",
        "amount",
        "addby"
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
