<?php

/**
 * SchContactModel Model
 */

class SchContactModel
{
    use Model;

    protected $table = 'sch_contacts';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        'sch_token',
        'sch_phone',
        'sch_email',
        'sch_map',
        'sch_address',
        'sch_postcode',
        'sch_town',
        'sch_city'
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
