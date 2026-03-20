<?php

/**
 * FinVotesModel Model
 */

class FinVotesModel
{
    use Model;

    protected $table = 'sch_fin_votes';
    protected $limit = 10000000000;
    protected $order_type   = "ASC";
    protected $order_column = "id";
    protected $allowedColumns = [
        "sch_token",
        "vote_head_key",
        "vote_head_name",
        "addby",
        "upby"
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
