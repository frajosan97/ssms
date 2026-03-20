<?php

/**
 * BlogModel Model
 */

class BlogModel
{
    use Model;

    protected $table = 'sch_blog';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        'sch_token',
        'blog_key',
        'blog_title',
        'blog_img',
        'blog_short_desc',
        'blog_story',
        "addby"
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
