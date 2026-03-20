<?php

/**
 * Grading controller
 */

class Grading
{
    use Controller;

    public function index()
    {
        $data = [];
        $appData = new App;
        $gradingSystem = $appData->sch_grading_cat();
        if ($gradingSystem) {
            $data['grdSys'] = $gradingSystem;
        }
        // ADD GRADING SYSTEM
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $Gradings = new GradingModel;
            $gradesModel = new GradingSystemModel;
            $schToken = $appData->schoolToken;
            $gradingCatKey = smartKey($schToken . " " . $_POST['grd_subcat']);
            if (!($Gradings->fetch(["grd_key" => $gradingCatKey]))) {
                if (!($Gradings->insert(["sch_token" => $schToken, "grd_key" => $gradingCatKey, "grd_subcat" => $_POST['grd_subcat'], "addby" => CURRENTUSER]))) {
                    // add grades
                    $gradesAdded = 0;
                    foreach (DEFAULTGRADES as $key => $value) {
                        $gradeKey = smartKey($gradingCatKey) . "-" . $key; // grade key
                        if (!($gradesModel->fetch(["grds_key" => $gradeKey]))) {
                            if (!($gradesModel->insert(["sch_token" => $schToken, "grds_key" => $gradeKey, "grds_cat_key" => $gradingCatKey, "grds_grade" => $key, "grds_min" => $value['min'], "grds_max" => $value['max'], "grds_point" => $value['point'], "grds_rem" => $value['rem'], "grds_lugha" => $value['lugha'], "addby" => CURRENTUSER]))) {
                                $gradesAdded += 1;
                            }
                        }
                    }
                    create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Created " . strtoupper($_POST['grd_subcat']) . " grading system"));
                    $_SESSION['status'] = "<b>" . strtoupper($_POST['grd_subcat']) . " Grading System</b><br>[" . $gradesAdded . " grades added]<br>Created successfully!";
                    $_SESSION['status_code'] = 'success';
                } else {
                    $_SESSION['status'] = "Error adding <b>" . strtoupper($_POST['grd_subcat']) . " grading system</b>";
                    $_SESSION['status_code'] = 'error';
                }
            } else {
                $_SESSION['status'] = "<b>" . strtoupper($_POST['grd_subcat']) . " grading system</b><br> For <b>" . strtoupper(APPINFO->sch_name) . " </b> already exists!";
                $_SESSION['status_code'] = 'error';
            }
        }
        $this->view('Grading', $data, __FUNCTION__);
    }

    public function manage($grd_key = "")
    {
        $data = [];
        $appData = new App;
        $gradingSystem = $appData->gradingSysInfo($grd_key);
        if ($gradingSystem) {
            $data['grdSys'] = $gradingSystem;
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $gradesModel = new GradingSystemModel;
                $success = 0;
                $failed = 0;
                foreach ($_POST['grds_key'] as $key => $value) {
                    $updateData = ["grds_min" => $_POST['grds_min'][$key], "grds_max" => $_POST['grds_max'][$key], "grds_grade" => $_POST['grds_grade'][$key], "grds_point" => $_POST['grds_point'][$key], "grds_rem" => $_POST['grds_rem'][$key], "grds_lugha" => $_POST['grds_lugha'][$key]];
                    if (!($gradesModel->update($value, $updateData, "grds_key"))) {
                        $success += 1;
                    } else {
                        $failed += 1;
                    }
                }
                create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Updated " . strtoupper($_POST['grading_type']) . " grading system"));
                $_SESSION['status'] = $success . " grades edited successfully, " . $failed . " grades failed";
                $_SESSION['status_code'] = 'success';
            }
        }
        $this->view('Grading', $data, __FUNCTION__);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $Gradings = new GradingModel;
            $dltKey = $_POST['grdKey'];
            $deleteGrd = $Gradings->delete($dltKey, "grd_key");
            if (!($deleteGrd)) {
                $gradesModel = new GradingSystemModel;
                $deleteGrdSys = $gradesModel->delete($dltKey, "grds_cat_key");
                if (!($deleteGrdSys)) {
                    create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Deleted " . strtoupper($dltKey) . " grading system"));
                    $_SESSION['status'] = "<b>" . strtoupper($_POST['grdName']) . "</b><br>Deleted successfully!";
                    $_SESSION['status_code'] = 'success';
                } else {
                    $_SESSION['status'] = "Error encountered deleting <b>" . strtoupper($_POST['grdName']) . "</b> the grading system";
                    $_SESSION['status_code'] = 'warning';
                }
            } else {
                $_SESSION['status'] =  "Error encountered deleting <b>" . strtoupper($_POST['grdName']) . "</b> the grading system";
                $_SESSION['status_code'] = 'warning';
            }
        }
    }
}
