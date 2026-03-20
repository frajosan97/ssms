<?php

/**
 * TeacherSubjectModel Model
 */

class TeacherSubjectModel
{
    use Model;

    protected $table = 'sch_tsub';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        "sch_token",
        "tsub_teacher",
        "tsub_form",
        "tsub_stream",
        "tsub_code",
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
