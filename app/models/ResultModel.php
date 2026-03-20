<?php

/**
 * ResultModel Model
 */

class ResultModel
{
    use Model;

    protected $table = 'sch_results';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        "sch_token",
        "re_key",
        "re_term",
        "re_exam",
        "re_studK",
        "re_studF",
        "re_studS",
        "re_subC",
        "re_OutOf",
        "re_s101",
        "re_s102",
        "re_s121",
        "re_s122",
        "re_s231",
        "re_s232",
        "re_s233",
        "re_s236",
        "re_s237",
        "re_s311",
        "re_s312",
        "re_s313",
        "re_s314",
        "re_s315",
        "re_s441",
        "re_s442",
        "re_s443",
        "re_s444",
        "re_s445",
        "re_s446",
        "re_s447",
        "re_s448",
        "re_s449",
        "re_s450",
        "re_s451",
        "re_s501",
        "re_s502",
        "re_s503",
        "re_s504",
        "re_s511",
        "re_s565",
        "re_tt",
        "re_mean",
        "re_pnt",
        "re_avgpnt",
        "re_grade",
        "re_fRank",
        "re_sRank",
        "re_status",
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
