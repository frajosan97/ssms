<?php

/**
 * Api controller
 */

class Api
{
    use Controller;

    public function index($userType = "")
    {
        echo ucwords($userType . " - contacts in process of update!");
    }

    public function getOptionList()
    {
        $userType = $_POST['userType'];
        switch ($userType) {
            case 'parent':
                $html = '<li class="list-group-item border-0 px-0">';
                $html .= '<label for="" class="mb-1">USER CONTACTS TYPE</label>';
                $html .= '<select id="" class="form-control text-capitalize" onchange="getContacts(this)">';
                $html .= '<option value="">--Select ' . $userType . ' message type--</option>';
                $html .= "<optgroup label='single students'>";
                $html .= "<option value='s'>Single " . $userType . "</option>";
                $html .= "</optgroup>";
                $html .= "<optgroup label='all students'>";
                $html .= "<option value='a'>all " . $userType . "</option>";
                $html .= "</optgroup>";
                $html .= "<optgroup label='form or class'>";
                for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) {
                    $html .= "<option value='" . $classNum . "'>form " . $classNum . "</option>";
                }
                $html .= "</optgroup>";
                $html .= "<optgroup label='stream'>";
                for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) {
                    foreach (STREAMS as $stream) {
                        $html .= "<option value='" . rawSmartKey($classNum . " " . $stream->stream) . "'>form " . $classNum . " " . $stream->stream . "</option>";
                    }
                }
                $html .= '</select>';
                $html .= '</li>';
                break;
            default:
                $html = '<li class="list-group-item border-0 px-0">';
                $html .= '<label for="" class="mb-1">USER CONTACTS TYPE</label>';
                $html .= '<select id="" class="form-control text-capitalize" onchange="getContacts(this)">';
                $html .= '<option value="">--Select ' . $userType . ' message type--</option>';
                $html .= '<option value="s">Single ' . $userType . ' member</option>';
                $html .= '<option value="a">All ' . $userType . ' members</option>';
                $html .= '</select>';
                $html .= '</li>';
                break;
        }
        echo $html;
    }

    public function staff($contactType = "")
    {
        $appData = new App;
        $allStaff = $appData->sch_staff();
        if ($allStaff) {
            foreach ($allStaff as $contact) {
                $allContacts[] = smsPhone($contact->user_phone);
                $selectData[] = "<option value=" . smsPhone($contact->user_phone) . "><b>" . ucwords($contact->user_gender) . "</b> " . $contact->user_lname . " [ " . smsPhone($contact->user_phone) . " ]</option>";
            }
            // contacts
            if ($contactType == "a") {
                $response = "<li class='list-group-item border-0 px-0'><textarea name='MessageTo' class='form-control' placeholder='Contacts'>" . implode(",", $allContacts) . "</textarea></li>";
            } else {
                $response = "<li class='list-group-item border-0 px-0'><select name='MessageTo' class='form-control'>" . implode("", $selectData) . "</select></li>";
            }
            // text area
            $response .= "<li class='list-group-item border-0 px-0'><textarea name='MessageText' class='form-control' placeholder='Message here...'></textarea></li>";
            $response .= "<li class='list-group-item border-0 px-0'><button class='btn btn-sm btn-success float-end'>Send Message</button></li>";
        } else {
            $response = "<li class='list-group-item border-0 px-0'>No staff record found to print contacts for!</li>";
        }
        // final print
        echo $response;
    }

    public function parent($contactType = "")
    {
        $appData = new App;
        $allStudents = $appData->sch_students();
        if ($allStudents) {
            $avContacts = 0;
            if ($contactType == "s" || $contactType == "a") {
                foreach ($allStudents as $contact) {
                    if (!($contact->stud_form == "alumni")) {
                        $avContacts += 1;
                        $allContacts[] = smsPhone($contact->stud_phone);
                        $selectData[] = "<option value=" . smsPhone($contact->stud_phone) . "><b>" . ucwords($contact->stud_lname) . "</b> " . $contact->stud_fname . " " . $contact->stud_oname . " [ " . smsPhone($contact->stud_phone) . " ]</option>";
                    }
                }
            } else {
                if (is_numeric($contactType)) {
                    foreach ($allStudents as $contact) {
                        if (!($contact->stud_form == "alumni")) {
                            if ($contact->stud_form == $contactType) {
                                $avContacts += 1;
                                $allContacts[] = smsPhone($contact->stud_phone);
                            }
                        }
                    }
                } else {
                    $classData = explode("-", $contactType);
                    foreach ($allStudents as $contact) {
                        if (!($contact->stud_form == "alumni")) {
                            if (($contact->stud_form == $classData[0]) && ($contact->stud_stream == $classData[1])) {
                                $avContacts += 1;
                                $allContacts[] = smsPhone($contact->stud_phone);
                            }
                        }
                    }
                }
            }
            if ($avContacts > 0) {
                if (!($contactType == "s")) {
                    $response = "<a href='https://" . trim(APPINFO->sch_domain, '/') . "/Excel/parent/" . $contactType . "'><i class='fas fa-download'></i> Export contacts list</a>";
                    $response .= "<li class='list-group-item border-0 px-0'><textarea name='MessageTo' class='form-control' placeholder='Contacts'>" . implode(",", $allContacts) . "</textarea></li>";
                } else {
                    $response = "<li class='list-group-item border-0 px-0'><select name='MessageTo' class='form-control'>" . implode("", $selectData) . "</select></li>";
                }
                // text area
                $response .= "<li class='list-group-item border-0 px-0'><textarea name='MessageText' class='form-control' placeholder='Message here...'></textarea></li>";
                $response .= "<li class='list-group-item border-0 px-0'><button class='btn btn-sm btn-success float-end'>Send Message</button></li>";
            } else {
                $response = "<li class='list-group-item border-0 px-0'>No Students contacts found!</li>";
            }
        } else {
            $response = "<li class='list-group-item border-0 px-0'>No Students record found to print contacts for!</li>";
        }
        // final print
        echo $response;
    }

    public function results($getClass = "")
    {
        $appData = new App;
        $recentExam = $appData->recentExam();
        if ($recentExam) {
            $data = [];

            if (empty($getClass)) {
                for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) {
                    $results = $appData->results_analysis($recentExam['exam_key'], $classNum, "meritListData")['currentExam']['meritData'];
                    foreach ($results as $key => $value) {
                        $data[$key] = $value;
                    }
                }
            } else {
                $results = $appData->results_analysis($recentExam['exam_key'], $getClass, "meritListData")['currentExam']['meritData'];
                foreach ($results as $key => $value) {
                    $data[$key] = $value;
                }
            }

            // show($data);
            if (count($data) > 0) {
                $noneCount = 0;
                foreach ($data as $key => $value) {
                    if ($value['re_marks'] > 0) {
                        $noneCount += 1;
                    }
                }
                if ($noneCount > 0) {
                    foreach ($data as $key => $value) {
                        if ($value['re_marks'] > 0) {
                            $subNumIncre = 1;
                            $phoneNumber = $value['re_phone'];
                            $fullName = $value['re_lname'] . " " . $value['re_name'] . " [ ADM - " . $value['re_adm'] . " ]";
                            /** message introduction */
                            $message = ucwords(greeting_msg()) . ",\nResults for " . strtoupper($fullName) . " " . strtoupper("form " . $value['re_class']) . "\n";
                            /** subjects scores */
                            foreach (SCHSUBJECTS as $subject) {
                                $subInfo = $appData->subInfo($subject->sch_sub_code);
                                $re_subject = "re_s" . $subInfo->sub_code;
                                if (!($value[$re_subject] == "--")) {
                                    $subData = $appData->get_sub_data($subInfo->sub_code, $value[$re_subject]);
                                    $message .= ucwords($subNumIncre++ . ") " . $subInfo->sub_name . " : " . ucwords($subData['marks'] . " " . $subData['grade'])) . "\n";
                                }
                            }
                            /** final arithmetics */
                            $message .= "========================\n";
                            $message .= "TOTAL MARKS: " . $value['re_marks'] . "\n";
                            $message .= "TOTAL POINTS: " . $value['re_pnt'] . "\n";
                            $message .= "MEAN GRADE: " . strtoupper($value['re_grade']) . "\n";
                            $message .= "POSITION: " . $value['re_frank'] . "\n\n";
                            $message .= "NB: To download the report form, go to " . ROOT . "student \nAdm: " . $value['re_adm'] . "\nPassword: 12345678";
                            // Print out
                            $display = "<tr>";
                            $display .= "<td class='text-end'><input type='checkbox' name='studResults[]' value='" . $message . "'></td>";
                            $display .= "<input type='hidden' name='MessageTo[]' value='" . $phoneNumber . "'>";
                            $display .= "<input type='hidden' name='MessageText[]' value='" . $message . "'>";
                            $display .= "<td>" . smartPhone($phoneNumber) . "</td>";
                            $display .= "<td>" . $message . "</td>";
                            $display .= "<tr>";
                            echo $display;
                        }
                    }
                } else {
                    $error = "There is no exam results ready to send to parents!";
                }
            } else {
                $error = "There is no exam results ready to send to parents!";
            }
        } else {
            $error = "There is no exam results ready to send to parents!";
        }

        if (isset($error)) {
            echo "<tr><td colspan='3' class='text-center'>" . $error . "</td></tr>";
        }
    }

    public function sync()
    {
        $appData = new App;
        $allStudents = $appData->sch_students();
        if (($allStudents)) {
            foreach ($allStudents as $key => $value) {
                $tbData = "<tr>";
                foreach ($value as $studKey => $studValue) {
                    if (in_array($studKey, STUDEXPORTDATA)) {
                        $tbData .= "<input type='hidden' name='" . $studKey . "[]' value='" . $studValue . "'/>";
                        $tbData .= "<td class='text-capitalize'>" . $studValue . "</td>";
                    }
                }
                $tbData .= "</tr>";
                echo $tbData;
            }
        } else {
            echo "<tr><td class='text-center' colspan='" . count(STUDEXPORTDATA) . "'>No student registered ready for sync!</td></tr>";
        }
    }
}
