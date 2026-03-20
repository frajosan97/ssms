<?php

/**
 * SchoolModel Model
 */

class SchoolModel
{
    use Model;

    protected $table = 'sch_account';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        'sch_token',
        'sch_domain',
        'sch_name',
        'sch_about',
        'sch_moto',
        'sch_mission',
        'sch_vision',
        'sch_metadesc',
        'sch_metakey',
        'sch_prim_theme',
        'sch_sec_theme',
        'sch_pdf_theme',
        'sch_cl_num',
        'sch_type',
        'sch_category',
        'sch_sum_type',
        'sch_rank_by',
        'sch_fsNotes',
        'sch_status',
        'sch_mode',
        'sch_sms_mode',
        'sch_sms_api',
        'sch_partner_id',
        'sch_short_code',
        'sch_lag',
        'addby',
        'addon',
        'upon'
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

    public function reg_validate($data)
    {
        $this->errors = [];

        // validate email address
        if (isValidEmail($_POST['schoolEmail'])) {
            $this->errors[] = strtoupper($_POST['schoolEmail']) . " - is invalid email address!";
        }
        // Make sure at least 1 invoice is selected
        if (!(isset($_POST['invoiceItem']))) {
            $this->errors[] = "You MUST select at least 1 invoice item to continue!";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
