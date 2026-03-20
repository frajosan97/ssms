<?php

/**
 * DynamicPagesModel Model
 */

class DynamicPagesModel
{
    use Model;

    protected $table = 'sch_dynamic_pages';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        'page_key',
        'sch_token',
        'main_page',
        'page_sub_title',
        'page_article',
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
