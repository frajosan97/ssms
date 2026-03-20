<?php

/**
 * Library controller
 */

class Library
{
    use Controller;

    public function index()
    {
        $data = [];
        $appData = new App;
        $allResources = $appData->sch_lib_res();
        if ($allResources)
            $data['resources'] = $allResources;
        $this->view('Library', $data, __FUNCTION__);
    }

    public function create()
    {
        $data = [];
        $appData = new App;
        foreach (SCHSUBJECTS as $key => $value) {
            $thisSub = $appData->subInfo($key);
            $data['sch_sub'][$key] = $thisSub;
        }
        // upload
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $libPost = [];
            $LibraryModel = new LibraryModel;
            $schToken = $appData->schoolToken;
            $resKey = smartKey($schToken . " " . $_POST['keyGen']);
            if (!($LibraryModel->fetch(["el_key" => $resKey]))) {
                $libPost["sch_token"] = $schToken;
                $libPost["el_key"] = $resKey;
                $libPost['addby'] = CURRENTUSER;
                if ($_FILES['doc']['size'] > 0) {
                    $docInfo = docUpload($_FILES, "library");
                    if (isset($docInfo['docInfo'])) {
                        $libPost["el_doc"] = $docInfo['docInfo']['name'];
                        $libPost["el_ext"] = $docInfo['docInfo']['type'];
                    } else {
                        $_SESSION['status'] = implode("<br>", $docInfo);
                        $_SESSION['status_code'] = 'error';
                    }
                }
                foreach ($_POST as $key => $value) {
                    $libPost[$key] = $value;
                }
                if (!($LibraryModel->insert($libPost))) {
                    $_SESSION['status'] =  "Library resource uploaded successfully!";
                    $_SESSION['status_code'] = 'success';
                } else {
                    $_SESSION['status'] =  "Error uploading library resource, kindly try again!";
                    $_SESSION['status_code'] = 'error';
                }
            } else {
                $_SESSION['status'] =  "The resource you are trying to upload exists in our database!";
                $_SESSION['status_code'] = 'error';
            }
        }
        $this->view('Library', $data, __FUNCTION__);
    }

    public function list($class, $category = "")
    {
        $data = [];
        $appData = new App;
        $allResources = $appData->sch_lib_res();
        $data['resCount'] = 0;
        $data['resHeading'] = "";
        $data['resCat'] = str_replace("_", " ", $category);
        if ($allResources) {
            foreach ($allResources as $resource) {
                if ($resource->el_form == $class && $resource->el_category == $category) {
                    $data['resCount'] += 1;
                    $data['resources'][] = $resource;
                }
            }
        }
        $data['resHeading'] = "form " . toWords($class) . " " . $data['resCat'] . " [ <i>" . $data['resCount'] . " records</i> ]";
        $this->view('Library', $data, __FUNCTION__);
    }

    public function read($docKey = "")
    {
        $data = [];
        $appData = new App;
        $data['resHeading'] = "";
        $data['resCount'] = 0;
        $allResources = $appData->sch_lib_res();
        if ($allResources) {
            foreach ($allResources as $resource) {
                if ($resource->el_key == $docKey) {
                    $thisSub = $appData->subInfo($resource->el_sub);
                    $data['resCount'] += 1;
                    $data['resHeading'] = "form " . $resource->el_form . " " . $resource->el_stream . " " . $thisSub->sub_name . " " . $resource->el_category;
                    $data['resources'] = $resource;
                }
            }
        }
        $this->view('Library', $data, __FUNCTION__);
    }
}
