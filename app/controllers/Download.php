<?php

/**
 * Download controller
 */

class Download
{
    use Controller;

    public function index()
    {
        $data = [];
        $appData = new App;
        $allDownloads = $appData->sch_downloads();
        if ($allDownloads) {
            $data['downloads'] = $allDownloads;
        }
        $this->view('Download', $data, __FUNCTION__);
    }

    public function create()
    {
        $appData = new App;
        $schToken = $appData->schoolToken;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $downloadModel = new DownloadsModel;
            if ($downloadModel->validate($_POST)) {
                if ($_FILES['doc']['size'] > 0) {
                    $uploadKey = smartKey($schToken . " " . $_POST['down_title']);
                    if (!($downloadModel->fetch(array('down_key' => $uploadKey)))) {
                        $docInfo = docUpload($_FILES, "downloads");
                        if (isset($docInfo['docInfo'])) {
                            if (!($downloadModel->insert(['sch_token' => $schToken, 'down_key' => $uploadKey, 'down_title' => $_POST['down_title'], 'down_link' => $docInfo['docInfo']['name'], 'down_type' => $docInfo['docInfo']['type'], 'down_size' => $docInfo['docInfo']['size'], 'addby' => CURRENTUSER]))) {
                                $downloadModel->errors[] = "Download posted successfully!";
                            } else {
                                $downloadModel->errors[] = "Error uploading the download resource, kindly try again!";
                            }
                        } else {
                            $downloadModel->errors = $docInfo;
                        }
                    } else {
                        $downloadModel->errors[] = "The file that you are trying to upload already exists in the school database, kindly try a different one, or change the title of the file";
                    }
                } else {
                    $downloadModel->errors[] = "You MUST chose a file to upload!";
                }
            }
            // echo errors
            echo implode("<br>", $downloadModel->errors);
        } else {
            $data = [];
            $this->view('Download', $data, __FUNCTION__);
        }
    }

    public function read($downKey = "")
    {
        $data = [];
        $appData = new App;
        $allDownloads = $appData->sch_downloads();
        if ($allDownloads) {
            foreach ($allDownloads as $key => $value) {
                if ($value->down_key == $downKey) {
                    $data['downInfo'] = $value;
                }
            }
        }
        $this->view('Download', $data, __FUNCTION__);
    }

    public function update()
    {
        $data = [];
        $this->view('Download', $data, __FUNCTION__);
    }

    public function delete()
    {
        $downloadModel = new DownloadsModel;
        $downData = $downloadModel->fetch(["down_key" => $_POST['down_key']]);
        if ($downData) {
            if (!(delDoc($downData->down_link, "downloads"))) {
                if (!($downloadModel->delete($_POST['down_key'], "down_key"))) {
                    echo "Download record deleted successfully!";
                } else {
                    echo "Error deleting the download record, kindly try again!";
                }
            } else {
                echo "Error deleting the download record, kindly try again!";
            }
        } else {
            echo "Error deleting the download record, kindly try again!";
        }
    }
}
