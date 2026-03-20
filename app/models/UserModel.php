<?php

/**
 * UserModel Model
 */

class UserModel
{
    use Model;

    protected $table = 'sch_users';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        "sch_token",
        "user_key",
        "user_role",
        "user_name",
        "user_pass",
        "user_gender",
        "user_salutation",
        "user_fname",
        "user_lname",
        "user_snumber",
        "user_id",
        "user_toemp",
        "user_county",
        "user_phone",
        "user_email",
        "user_status",
        "user_otp",
        "user_password",
        "user_regby"
    ];

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
