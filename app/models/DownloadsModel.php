<?php

/**
 * DownloadsModel Model
 */

class DownloadsModel
{
    use Model;

    protected $table = 'sch_downloads';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        'sch_token',
        'down_key',
        'down_title',
        'down_link',
        'down_type',
        'down_size',
        'down_count',
        'addby',
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
