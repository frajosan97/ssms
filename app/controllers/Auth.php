<?php

/**
 * Auth controller
 */

class Auth
{
    use Controller;

    public function index($type = "")
    {
        if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
            $data = [];
            $data['user'] = $type;
            $data['formTitle'] = $type . " login";
            $this->view('Auth', $data, __FUNCTION__);
        } else {
            $appData = new App;
            $schToken = $appData->schoolToken;
            $UserModel = new UserModel;
            if ($UserModel->validate($_POST)) {
                if (in_array($type, array_keys(PORTALS))) {
                    $allUsers = $UserModel->fetchAll();
                    if ($allUsers) {
                        foreach ($allUsers as $user) {
                            if ((($user->user_email == $_POST['username']) && in_array($user->sch_token, array("sch", $schToken)))) {
                                $userInfo = $user;
                            } else {
                                if ((($user->user_name == $_POST['username']) && in_array($user->sch_token, array("sch", $schToken))))
                                    $userInfo = $user;
                            }
                        }
                        /** final validations */
                        if (isset($userInfo)) {
                            if ($userInfo->user_status == 2) {
                                if (in_array($userInfo->user_role, PORTALS[$type])) {
                                    $_SESSION['userData'] = $userInfo;
                                    $_SESSION['userMode'] = $type;
                                    $UserModel->errors[] = "success";
                                } else {
                                    $UserModel->errors[] = "This account is restricted to " . strtoupper($type) . " members only!";
                                }
                            } else {
                                $UserModel->errors[] = "Your account is locked, Kindly contact admin for assistance!";
                            }
                        } else {
                            $UserModel->errors[] = "Incorrect Email or User Name!";
                        }
                    } else {
                        $UserModel->errors[] = "No users registered for this school, contact admin for more information!";
                    }
                } else {
                    $UserModel->errors[] = "Unauthorized user access!";
                }
            }
            // load errors
            echo implode("<br>", $UserModel->errors);
        }
    }

    public function student()
    {
        if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
            $data = [];
            $data['user'] = "student";
            $data['formTitle'] = "student login";
            $this->view('Auth', $data, __FUNCTION__);
        } else {
            $appData = new App;
            $schToken = $appData->schoolToken;
            $StudentModel = new StudentModel;
            if ($StudentModel->validate($_POST)) {
                $studentData = $StudentModel->fetch(array("sch_token" => $schToken, "stud_adm" => $_POST['adm']));
                if ($studentData) {
                    $_SESSION['userData'] = $studentData;
                    $_SESSION['userMode'] = "student";
                    $StudentModel->errors[] = "success";
                } else {
                    $StudentModel->errors['error'] = "Incorrect Admission Number!";
                }
            }
            // load errors
            echo implode("<br>", $StudentModel->errors);
        }
    }

    public function alumni()
    {
        if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
            $data = [];
            $data['user'] = "alumni";
            $data['formTitle'] = "alumni login";
            $this->view('Auth', $data, __FUNCTION__);
        } else {
            $appData = new App;
            $schToken = $appData->schoolToken;
            $AlumniModel = new AlumniModel;
            if ($AlumniModel->validate($_POST)) {
                $studentData = $AlumniModel->fetch(array("sch_token" => $schToken, "stud_adm" => $_POST['adm']));
                if ($studentData) {
                    $_SESSION['userData'] = $studentData;
                    $_SESSION['userMode'] = "student";
                    $AlumniModel->errors[] = "success";
                } else {
                    $AlumniModel->errors['error'] = "Incorrect Admission Number!";
                }
            }
            // load errors
            echo implode("<br>", $AlumniModel->errors);
        }
    }

    public function password()
    {
        $data = [];
        $data['user'] = "password";
        $data['formTitle'] = "enter your password";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userPassword = md5($_POST['password']);
            if ($_SESSION['userMode'] == "student") {
                $savedPassword = $_SESSION['userData']->stud_password;
                $logUserKey = $_SESSION['userData']->stud_key;
                $logUserName = $_SESSION['userData']->stud_adm;
            } else {
                $savedPassword = $_SESSION['userData']->user_password;
                $logUserKey = $_SESSION['userData']->user_key;
                $logUserName = $_SESSION['userData']->user_name;
            }
            if ($userPassword == $savedPassword) {
                $_SESSION[$_SESSION['userMode']] = $_SESSION['userData'];
                create_log([time(), APPINFO->sch_token, $_SESSION['userMode'], $logUserKey, $logUserName, "logged in successfully"]);
                echo ROOT . $_SESSION['userMode'];
            } else {
                echo "Incorrect password!";
            }
        } else {
            $this->view('Auth', $data, __FUNCTION__);
        }
    }

    public function forgot_password()
    {
        $data = [];
        $appData = new App;
        $userModel = new UserModel;
        $data['user'] = "forgot_password";
        $data['formTitle'] = "password reset request";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($userModel->validate($_POST)) {
                $otp = genOtp();
                $message = "Hi " . ucwords($_SESSION['userData']->user_fname) . ", your password reset request OTP is " . $otp . ". Kindly dont share with anyone";
                if (!($userModel->update($_SESSION['userData']->id, array("user_otp" => $otp)))) {
                    if ($_POST['verType'] == "email") { // send otp via email
                        $email = $_SESSION['userData']->user_email;
                        $mailInfo = array("to" => $email, "subject" => "Password change OTP", "message" => $message);
                        if (!($appData->sendMail($mailInfo))) {
                            $_SESSION['otpstatus'] = "OTP sent to your email <b>" . hide_email($email) . "</b> successfully!";
                            $userModel->errors[] = $_SESSION['otpstatus'];
                        } else {
                            $userModel->errors[] = "Error encountered sending OTP, kindly try again!";
                        }
                    } else { // send otp via text sms
                        $phoneNum = $_SESSION['userData']->user_phone;
                        $smsInfo = array("to" => $phoneNum, "message" => $message);
                        if (APPINFO->sch_sms_mode == 1) {
                            $response = $appData->modemSMS($smsInfo);
                        } else {
                            $response = $appData->apiSMS($smsInfo);
                        }
                        if ($response) {
                            $response = json_decode($response, true);
                            $responsecode = $response['responses'][0]['response-code'];
                            if ($responsecode == 200) {
                                $_SESSION['otpstatus'] = "OTP sent to <b>" . hide_phone(smartPhone($phoneNum)) . "</b> successfully!";
                                $userModel->errors[] = $_SESSION['otpstatus'];
                            } else {
                                $userModel->errors[] = "Error encountered sending OTP, kindly try again!";
                            }
                        } else {
                            $userModel->errors[] = "Error encountered sending OTP, kindly try again!";
                        }
                    }
                } else {
                    $userModel->errors[] = "Error encountered sending OTP, kindly try again!";
                }
            }
            // load errors
            echo implode("<br>", $userModel->errors);
        } else {
            $this->view('Auth', $data, __FUNCTION__);
        }
    }

    public function reset_password()
    {
        $data = [];
        $userModel = new UserModel;
        $data['user'] = "reset_password";
        $data['formTitle'] = "password reset";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($userModel->validate($_POST)) {
                $otp = $_POST['otp'];
                $password = $_POST['password'];
                $userId = $_SESSION['userData']->id;
                if ($password == $_POST['confirm_password']) {
                    $getUser = $userModel->fetch(array("id" => $userId));
                    if ($getUser->user_otp == $otp) {
                        if (!($userModel->update($userId, array("user_password" => md5($password))))) {
                            $userModel->errors[] = "Your password have been reset successfully!";
                        } else {
                            $userModel->errors[] = "Error encountered changing password, kindly try again!";
                        }
                    } else {
                        $userModel->errors[] = "Incorrect OTP!";
                    }
                } else {
                    $userModel->errors[] = "The two password MUST be the same!";
                }
            }
            // load errors
            echo implode("<br>", $userModel->errors);
        } else {
            $this->view('Auth', $data, __FUNCTION__);
        }
    }

    public function account()
    {
        $data = [];
        $data['user'] = "account";
        $data['formTitle'] = "account";
        $this->view('Auth', $data, __FUNCTION__);
    }
}
