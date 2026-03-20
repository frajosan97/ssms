<?php

/**
 * SubCatModel Model
 */

class SubCatModel
{
    use Model;

    protected $table = 'sys_subcat';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [];

    public function validate($data)
    {
        $this->errors = [];

        /** DATA VALIDATION EXAMPLE START */
        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                $this->errors[] = strtoupper($key) . " - Cannot be empty";
            }
            if (isset($_POST['email'])) {
                if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $this->errors['email'] = strtoupper($data['email']) . " - is not valid email address";
                }
            }
        }
        /** DATA VALIDATION EXAMPLE END */

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
