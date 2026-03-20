<?php

/**
 * StudentModel Model
 */

class StudentModel
{
    use Model;

    protected $table = 'sch_students';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        "sch_token",
        "stud_key",
        "stud_adm",
        "stud_cat",
        "stud_pass",
        "stud_gender",
        "stud_lname",
        "stud_fname",
        "stud_oname",
        "stud_form",
        "stud_stream",
        "stud_phone",
        "stud_kcpe_index",
        "stud_kcpe_marks",
        "stud_birth_date",
        "stud_birth_cert",
        "stud_county",
        "stud_drop_sub",
        "stud_reg_by",
        "stud_up_by"
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
