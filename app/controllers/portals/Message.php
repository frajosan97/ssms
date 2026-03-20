<?php

/**
 * Message controller
 */

class Message
{
    use Controller;

    public function index()
    {
        $data = [];
        $appData = new App;
        $data['studsData'] = [];
        $allStudents = $appData->sch_students();
        if ($allStudents) {
            foreach ($allStudents as $key => $value) {
                // get main info
                $studInfo = $appData->studentInfo($value->stud_key);
                if ($studInfo) {
                    if ($studInfo['finSummary']['ttBalance'] > 0) {
                        $data['studsData'][$value->stud_key] = array(
                            "stud_name" => $value->stud_lname . " " . $value->stud_fname . " " . $value->stud_oname,
                            "stud_adm" => $value->stud_adm,
                            "stud_phone" => $value->stud_phone,
                            "stud_class" => $value->stud_form . " " . $value->stud_stream,
                            "stud_billed" => $studInfo['finSummary']['ttBilled'],
                            "stud_paid" => $studInfo['finSummary']['ttPaid'],
                            "stud_balance" => $studInfo['finSummary']['ttBalance']
                        );
                    }
                }
            }
        }
        $this->view('Message', $data);
    }

    public function sendFeeBalance()
    {
        $appData = new App;
        if (!(empty($_POST['message']))) {
            $message = explode("_", $_POST['message']);
            if (isset($_POST['studKey'])) {
                $success = 0;
                $failed = 0;
                foreach ($_POST['studKey'] as $studKey) {
                    // get student data
                    $studInfo = $appData->studentInfo($studKey);
                    if ($studInfo) {
                        $STUDNAME = $studInfo['profile']->stud_lname . " " . $studInfo['profile']->stud_fname . " " . $studInfo['profile']->stud_oname;
                        $STUDGENDER = studSalutation($studInfo['profile']->stud_gender);
                        $STUDADM = $studInfo['profile']->stud_adm;
                        $STUDCLASS = $studInfo['profile']->stud_form . " " . $studInfo['profile']->stud_stream;
                        $FEESBALANCE = number_format($studInfo['finSummary']['ttBalance'], 2);
                        $phoneNum = $studInfo['profile']->stud_phone;
                        // create each student message
                        $newMess = [];
                        foreach ($message as $messkey) {
                            if (array_key_exists("_" . $messkey . "_", MESSVAR)) {
                                $newMess[] = ucwords($$messkey);
                            } else {
                                $newMess[] = $messkey;
                            }
                        }
                        // log message
                        $newMess = implode("", $newMess);
                        $newMess = preg_replace("/\r|\n/", "", $newMess);
                        // $newMess = htmlentities($newMess);
                        $smsInfo = array("phone" => $phoneNum, "message" => $newMess);
                        if (APPINFO->sch_sms_mode == 1) {
                            $response = $appData->modemSMS($smsInfo);
                        } else {
                            $response = $appData->apiSMS($smsInfo);
                        }
                        if ($response) {
                            $response = json_decode($response, true);
                            $responsecode = $response['responses'][0]['response-code'];
                            if ($responsecode == 200) {
                                $success += 1;
                            } else {
                                $failed += 1;
                            }
                        } else {
                            $failed += 1;
                        }
                    }
                }
                echo "Messages send successfully, with " . $success . " successfully send and " . $failed . " failed!";
            } else {
                echo "Kindly select at least 1 student to send fees balance for!";
            }
        } else {
            echo "You cannot send a blank message!";
        }
    }
}
