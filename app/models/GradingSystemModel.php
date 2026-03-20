<?php

/**
 * GradingSystemModel Model
 */

class GradingSystemModel
{
    use Model;

    protected $table = 'sch_grading_system';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        "sch_token",
        "grds_key",
        "grds_cat_key",
        "grds_grade",
        "grds_min",
        "grds_max",
        "grds_point",
        "grds_rem",
        "grds_lugha",
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
