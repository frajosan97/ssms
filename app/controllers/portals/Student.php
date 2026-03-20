<?php

/**
 * Student controller
 */

class Student
{
    use Controller;

    public function index($switch = "")
    {
        $data = [];
        $appData = new App;
        $data['switch'] = $switch;
        $allStudents = $appData->sch_students();
        // PREPARE HEADING
        $data['heading'] = "";
        if (empty($switch)) {
            $data['heading'] = "managing all students";
        } else {
            if (is_numeric($switch)) {
                $data['heading'] = "managing form " . $switch . " students";
            } else {
                $data['heading'] = "managing form " . str_replace("-", " ", $switch) . " students";
            }
        }
        // GET STUDENTS DATA
        if ($allStudents) {
            if (empty($switch)) {
                $studentData = $allStudents;
            } else {
                foreach ($allStudents as $key => $value) {
                    if (is_numeric($switch)) {
                        if ($value->stud_form == trim($switch)) {
                            $studentData[] = $value;
                        }
                    } else {
                        if (smartKey($value->stud_form . " " . $value->stud_stream) == trim($switch)) {
                            $studentData[] = $value;
                        }
                    }
                }
            }
            if (isset($studentData))
                $data['studData'] = $studentData;
        }

        $this->view('Student', $data, __FUNCTION__);
    }

    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $StudentModel = new StudentModel;
            foreach ($_POST as $key => $value) {
                if (!empty($value)) {
                    $searchData[$key] = ltrim($value, 0);
                }
            }
            if (isset($searchData)) {
                $searchData['sch_token'] = APPINFO->sch_token;
                $voterRecord = $StudentModel->where($searchData);
                if ($voterRecord) {
                    $sno = 1;
                    foreach ($voterRecord as $key => $value) {
                        echo "<tr><td>" . $sno++ . "</td>";
                        foreach (STUDEXPORTDATA as $exportKey) {
                            echo "<td>" . $value->$exportKey . "</td>";
                        }
                        echo "<td><a href='" . ROOT . VIEWFOLDER . "/student/profile/" . $value->stud_key . "' class='btn btn-outline-custom btn-sm w-100'><i class='fas fa-briefcase'></i> Manage</a></td></tr>";
                    }
                }
            }
        } else {
            $data = [];
            $this->view('Student', $data, __FUNCTION__);
        }
    }

    public function create()
    {
        $appData = new App;
        $schToken = $appData->schoolToken;
        $StudentModel = new StudentModel;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_FILES['studentsExel'])) {
                $dataSheet = uploadExcel($_FILES);
                if ($dataSheet) {
                    $regData = [];
                    foreach ($dataSheet as $studKey => $studValue) {
                        if ($studKey > 2) {
                            foreach (STUDREGKEYS as $key => $value) {
                                $regData[$studKey][$value] = $studValue[$key];
                            }
                        }
                    }
                } else {
                    echo "Error uploading student excel data";
                }
            } else {
                $regData[] = $_POST;
            }

            if (count($regData) > 0) {
                $success = 0;
                $fail = 0;
                foreach ($regData as $key => $value) {
                    if (!($StudentModel->fetch(["sch_token" => $schToken, "stud_adm" => $value['stud_adm']]))) {
                        $studRegData['sch_token'] = trim($schToken);
                        $studRegData['stud_key'] = trim(smartKey($schToken . " " . $value['stud_adm']));
                        foreach ($value as $dataKey => $dataValue) {
                            if (!(empty($dataValue))) {
                                $studRegData[$dataKey] = trim($dataValue);
                            }
                        }
                        $studRegData['stud_reg_by'] = trim(CURRENTUSER);
                        // insert student to database
                        if (!($StudentModel->insert($studRegData))) {
                            $success += 1;
                            create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Registered student with adm [" . $value['stud_adm'] . "] successfully"));
                        } else {
                            $fail += 1;
                        }
                    }
                }
                echo $success . " - students registered successfully, " . $fail . " - failed registration!";
            } else {
                echo "You cannot register a blank students form data";
            }
        } else {
            $data = [];
            $this->view('Student', $data, __FUNCTION__);
        }
    }

    public function profile($studKey = "")
    {
        $data = [];
        $appData = new App;
        // get student information
        $studentInfo = $appData->studentInfo($studKey);
        if (isset($studentInfo['profile'])) {
            $studInfo = $studentInfo['profile'];
            $studId = $studInfo->id;
            $studDropped = explode(",", $studInfo->stud_drop_sub);
            // Profile data
            $data['title'] = $studInfo->stud_lname . " " . $studInfo->stud_fname . " " . $studInfo->stud_oname . "[" . $studInfo->stud_adm . "]";
            $data['stud_profile'] = $studInfo;
            $data['stud_subjects'] = $studentInfo['subjects'];
            $data['results'] = $studentInfo['results'];
            $data['finance'] = $studentInfo['finance'];
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $student = new StudentModel;
                if (isset($_POST['updateSubjects'])) {
                    // update subjects
                    if (isset($_POST['subCode'])) {
                        $checkedSub = $_POST['subCode'];
                        foreach ($_POST['subUp'] as $key => $value) {
                            if (in_array($_POST['subUp'][$key], $checkedSub)) {
                                $subCode = $_POST['subUp'][$key];
                                // check for action
                                if ($_POST['updateSubjects'] == "active") {
                                    foreach ($studDropped as $subKey => $subValue) {
                                        if ($subCode == $subValue) {
                                            unset($studDropped[$subKey]);
                                        }
                                    }
                                } else {
                                    if (!(in_array($subCode, $studDropped))) {
                                        array_push($studDropped, $subCode);
                                    }
                                }
                            }
                        }
                        // // final setups
                        $filteredSub = array_filter($studDropped);
                        $subtoUpdate = implode(",", $filteredSub);
                        if (!($student->update($studId, array("stud_drop_sub" => $subtoUpdate)))) {
                            create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Updated student subjects for adm [" . $studInfo->stud_adm . "] successfully"));
                            $_SESSION['status'] = "Subjects updated successfully!";
                            $_SESSION['status_code'] = 'success';
                        } else {
                            $_SESSION['status'] = "Error updating student subjects";
                            $_SESSION['status_code'] = 'error';
                        }
                    } else {
                        $_SESSION['status'] = "Kindly select subjects to update!";
                        $_SESSION['status_code'] = 'error';
                    }
                } else {
                    // update student record
                    $upData = [];
                    // get img upload
                    if ($_FILES['passport']['size'] > 0) {
                        $imgData = uploadSingleImg($_FILES['passport'], "profiles");
                        if (isset($imgData['imgData'])) {
                            $upData["stud_pass"] = $imgData['imgData']['name'];
                        } else {
                            $_SESSION['status'] = implode("<br>", $imgData);
                            $_SESSION['status_code'] = 'error';
                        }
                    }
                    // on successful image processing
                    foreach ($_POST as $key => $value) {
                        $upData[$key] = $value;
                    }
                    if (!($student->update($studId, $upData))) {
                        create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Updated student profile with adm [" . $studInfo->stud_adm . "] successfully"));
                        $_SESSION['status'] = "student record updated successfully!";
                        $_SESSION['status_code'] = 'success';
                    } else {
                        $_SESSION['status'] = "Error updating student record, kindly try again!";
                        $_SESSION['status_code'] = 'error';
                    }
                }
            }
        }
        $this->view('Student', $data, __FUNCTION__);
    }

    public function promote()
    {
        $appData = new App;
        $allStudents = $appData->sch_students();
        if ($allStudents) {
            if (empty($_POST['classType'])) {
                $studsList = $allStudents;
            } else {
                foreach ($allStudents as $key => $value) {
                    if (is_numeric($_POST['classType'])) {
                        if ($value->stud_form == trim($_POST['classType'])) {
                            $studsList[] = $value;
                        }
                    } else {
                        if (smartKey($value->stud_form . " " . $value->stud_stream) == trim($_POST['classType'])) {
                            $studsList[] = $value;
                        }
                    }
                }
            }
            if (isset($studsList)) {
                $success = 0;
                $failed = 0;
                $StudentModel = new StudentModel;
                foreach ($studsList as $key => $value) {
                    if ($value->stud_form == APPINFO->sch_cl_num) {
                        $newClass = "alumni";
                    } elseif ($value->stud_form == "alumni") {
                        $newClass = $value->stud_form;
                    } else {
                        $newClass = ($value->stud_form + 1);
                    }
                    if (!($StudentModel->update($value->id, ["stud_form" => $newClass]))) {
                        $success += 1;
                    } else {
                        $failed += 1;
                    }
                }
                echo $success . " students promoted successfully, " . $failed . " failed";
            } else {
                echo "No student available for promotion";
            }
        } else {
            echo "No student available for promotion";
        }
    }

    public function demote()
    {
        $appData = new App;
        $allStudents = $appData->sch_students();
        if ($allStudents) {
            if (empty($_POST['classType'])) {
                $studsList = $allStudents;
            } else {
                foreach ($allStudents as $key => $value) {
                    if (is_numeric($_POST['classType'])) {
                        if ($value->stud_form == trim($_POST['classType'])) {
                            $studsList[] = $value;
                        }
                    } else {
                        if (smartKey($value->stud_form . " " . $value->stud_stream) == trim($_POST['classType'])) {
                            $studsList[] = $value;
                        }
                    }
                }
            }
            if (isset($studsList)) {
                $success = 0;
                $failed = 0;
                $StudentModel = new StudentModel;
                foreach ($studsList as $key => $value) {
                    if ($value->stud_form == 1) {
                        $newClass = $value->stud_form;
                    } elseif ($value->stud_form == "alumni") {
                        $newClass = APPINFO->sch_cl_num;
                    } else {
                        $newClass = ($value->stud_form - 1);
                    }
                    if (!($StudentModel->update($value->id, ["stud_form" => $newClass]))) {
                        $success += 1;
                    } else {
                        $failed += 1;
                    }
                }
                echo $success . " students demoted successfully, " . $failed . " failed";
            } else {
                echo "No student available for demotion";
            }
        } else {
            echo "No student available for demotion";
        }
    }

    public function exportToAlumni()
    {
        $appData = new App;
        $allStudents = $appData->sch_students();
        if ($allStudents) {
            foreach ($allStudents as $key => $value) {
                if ($value->stud_form == "alumni") {
                    show($value);
                }
            }
        } else {
            echo "No student available for to export to alumni";
        }
    }

    public function moveStudents()
    {
        if (isset($_POST['stud_key'])) {
            $StudentModel = new StudentModel;
            $success = 0;
            foreach ($_POST['stud_key'] as $key => $value) {
                if (!($StudentModel->update($value, [$_POST['type'] => $_POST['moveTo']], "stud_key"))) {
                    $success += 1;
                }
            }
            echo $success . " student(s) moved successfully!";
        } else {
            echo "You MUST select at least 1 student to move!";
        }
    }

    public function delete()
    {
        if (isset($_POST['stud_key'])) {
            $ResultModel = new ResultModel;
            $FinanceModel = new FinanceModel;
            $StudentModel = new StudentModel;
            $success = 0;
            foreach ($_POST['stud_key'] as $key => $value) {
                if (!($ResultModel->delete($value, "re_studK"))) {
                    if (!($FinanceModel->delete($value, "fi_studK"))) {
                        if (!($StudentModel->delete($value, "stud_key"))) {
                            $success += 1;
                        }
                    }
                }
            }
            echo $success . " student(s) deleted successfully!";
        } else {
            echo "You MUST select at least 1 student to delete!";
        }
    }
}
