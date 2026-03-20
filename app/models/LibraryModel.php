<?php

/**
 * LibraryModel Model
 */

class LibraryModel
{
    use Model;

    protected $table = 'sch_resources';
    protected $limit = 10000000000;
    protected $order_type   = "DESC";
    protected $order_column = "id";
    protected $allowedColumns = [
        "sch_token",
        "el_key",
        "el_doc",
        "el_ext",
        "el_form",
        "el_stream",
        "el_sub",
        "el_category",
        "el_sub_cat",
        "el_desc",
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

    function resourceUpload($data)
    {
        $uploadInfo = [];
        foreach ($data as $key => $value) {
            $fileType = explode("/", $value['type']);
            if (!($fileType[0] == "image")) {
                //save the file
                $path = LIB_PATH . "public/assets/docs/library/";
                $filename = $value['name'];
                move_uploaded_file($value['tmp_name'], $path . $filename);
                $uploadInfo["docData"] = array(
                    "docName" => $filename,
                    "docExt" => $fileType[1],
                );
            } else {
                $uploadInfo["errors"] = "Only documents are allowed for upload here, NOT IMAGES!";
            }
        }

        return $uploadInfo;
    }
}
