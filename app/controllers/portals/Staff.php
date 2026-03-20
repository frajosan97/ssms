<?php

/**
 * Staff controller
 */

class Staff
{
    use Controller;

    public function index()
    {
        $data = [];
        $appData = new App;
        $allStaff = $appData->sch_staff();
        if ($allStaff) {
            $data['staffData'] = $allStaff;
        }
        $this->view('Staff', $data, __FUNCTION__);
    }

    public function checkUserName()
    {
        $staff = new UserModel;
        if ($staff->validate($_POST)) {
            if (!(detect_blanks($_POST['userName']))) {
                if ($staff->fetch(array("sch_token" => APPINFO->sch_token, "user_key" => $_POST['userName']))) {
                    $staff->errors[] = $_POST['userName'] . " - username is already in use by another user, kindly try a different one!";
                } else {
                    $staff->errors[] = $_POST['userName'] . " - approved for registration!";
                }
            } else {
                $staff->errors[] = "User name MUST not contain spaces!";
            }
        }
        // Loop errors
        echo implode("<br>", $staff->errors);
    }

    public function create()
    {
        $appData = new App;
        $schToken = $appData->schoolToken;
        if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
            $data = [];
            $this->view('Staff', $data, __FUNCTION__);
        } else {
            $staff = new UserModel;
            if ($staff->validate($_POST)) {
                $staffKey = strtolower(esc(trim(smartKey($schToken . " " . $_POST['user_name']))));
                if (!($staff->fetch(array("sch_token" => $schToken, "user_key" => $staffKey)))) {
                    if (!($staff->fetch(array("sch_token" => $schToken, "user_email" => $_POST['user_email'])))) {
                        $staffData["sch_token"] = $schToken;
                        $staffData["user_key"] = $staffKey;
                        foreach ($_POST as $key => $value) {
                            $staffData[$key] = strtolower(esc(trim($value)));
                        }
                        $staffData["user_regby"] = CURRENTUSER;
                        if (!($staff->insert($staffData))) {
                            create_log(array(time(), $schToken, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Created new staff member with username " . $_POST['user_name']));
                            $smsInfo = [
                                "phone" => $_POST['user_phone'], "email" => $_POST['user_email'], "subject" => strtoupper(APPINFO->sch_name . " staff account creation"),
                                "message" => ucwords(greeting_msg()) . ", Your " . strtoupper(APPINFO->sch_name) . " staff account has been created successfully. User name: " . $_POST['user_name'] . ", Email: " . $_POST['user_email'] . ", Password: 12345678"
                            ];
                            $appData->apiSMS($smsInfo);
                            $appData->sendMail($smsInfo);
                            $staff->errors[] = "Staff registered successfully, you will be contacted shortly!";
                        } else {
                            $staff->errors[] = "Error encountered registering staff member, kindly try again!";
                        }
                    } else {
                        $staff->errors[] = "Email already taken by another staff member!";
                    }
                } else {
                    $staff->errors[] = "User already exists in our database!";
                }
            }
            // Loop errors
            echo implode("<br>", $staff->errors);
        }
    }

    public function profile($staffKey = "")
    {
        $data = [];
        $appData = new App;
        $userModel = new UserModel;
        $staffInfo = $appData->staffInfo($staffKey);
        if (isset($staffInfo['profile'])) {
            foreach ($staffInfo as $key => $value) {
                $data[$key] = $value;
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($userModel->validate($_POST)) {
                    if ($_FILES['passport']['size'] > 0) {
                        $imgData = uploadSingleImg($_FILES['passport'], "profiles");
                        if (isset($imgData['imgData'])) {
                            $upData["user_pass"] = $imgData['imgData']['name'];
                        } else {
                            $_SESSION['status'] = implode("<br>", $imgData);
                            $_SESSION['status_code'] = 'error';
                        }
                    }
                    foreach ($_POST as $key => $value) {
                        $upData[$key] = $value;
                    }
                    if (!($userModel->update($staffKey, $upData, "user_key"))) {
                        create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Updated staff member with username " . $staffKey));
                        $_SESSION['status'] = "Staff information updated successfully!";
                        $_SESSION['status_code'] = 'success';
                    } else {
                        $_SESSION['status'] = "Error encountered updating user information, kindly try again!";
                        $_SESSION['status_code'] = 'error';
                    }
                }
            }
        }
        $this->view('Staff', $data, __FUNCTION__);
    }

    public function delTeacherSubject()
    {
        $TeacherSubjectModel = new TeacherSubjectModel;
        if (!($TeacherSubjectModel->delete($_POST['id']))) {
            create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Subject deleted from the teacher account successfully!"));
            echo "Subject deleted successfully!";
        } else {
            echo "Error deleting the subject";
        }
    }

    public function delete()
    {
        $userModel = new UserModel;
        $TeacherSubjectModel = new TeacherSubjectModel;
        if (!($TeacherSubjectModel->delete($_POST['user_key'], "tsub_teacher"))) {
            if (!($userModel->delete($_POST['user_key'], "user_key"))) {
                create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Deleted staff member record for user key - " . $_POST['user_key']));
                echo "Staff member deleted successfully, all information regarding the staff removed!";
            } else {
                echo "Error encountered deleting the staff member!<br>EC: 002";
            }
        } else {
            echo "Error encountered deleting the staff member!<br>EC: 001";
        }
    }
}
