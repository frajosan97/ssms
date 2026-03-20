<?php

/**
 * API controller returning raw data (no HTML)
 */
class Api
{
    use Controller;

    public function index($userType = "")
    {
        header('Content-Type: text/plain');
        echo ucwords($userType . " - contacts in process of update!");
    }

    public function getOptionList()
    {
        header('Content-Type: application/json');
        $userType = $_POST['userType'];
        $options = [];

        switch ($userType) {
            case 'parent':
                $options[] = ['group' => 'single students', 'options' => [['value' => 's', 'label' => 'Single parent']]];
                $options[] = ['group' => 'all students', 'options' => [['value' => 'a', 'label' => 'All parent']]];

                $formOptions = [];
                for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) {
                    $formOptions[] = ['value' => "$classNum", 'label' => "Form $classNum"];
                }
                $options[] = ['group' => 'form or class', 'options' => $formOptions];

                $streamOptions = [];
                for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) {
                    foreach (STREAMS as $stream) {
                        $streamOptions[] = [
                            'value' => rawSmartKey($classNum . " " . $stream->stream),
                            'label' => "Form $classNum " . $stream->stream
                        ];
                    }
                }
                $options[] = ['group' => 'stream', 'options' => $streamOptions];
                break;

            default:
                $options[] = ['group' => 'default', 'options' => [
                    ['value' => 's', 'label' => "Single $userType member"],
                    ['value' => 'a', 'label' => "All $userType members"]
                ]];
                break;
        }

        echo json_encode($options);
    }

    public function staff($contactType = "")
    {
        header('Content-Type: application/json');
        $appData = new App;
        $allStaff = $appData->sch_staff();
        $response = [];

        if ($allStaff) {
            foreach ($allStaff as $contact) {
                $phone = smsPhone($contact->user_phone);
                $response['contacts'][] = $phone;
                $response['select'][] = [
                    'value' => $phone,
                    'label' => ucwords($contact->user_gender) . " " . $contact->user_lname . " [ $phone ]"
                ];
            }

            $response['messageField'] = true;
        } else {
            $response['error'] = "No staff record found to print contacts for!";
        }

        echo json_encode($response);
    }

    public function parent($contactType = "")
    {
        header('Content-Type: application/json');
        $appData = new App;
        $allStudents = $appData->sch_students();
        $response = [];

        if ($allStudents) {
            $avContacts = 0;

            foreach ($allStudents as $contact) {
                if ($contact->stud_form === "alumni") continue;

                $match = false;
                if ($contactType === "s" || $contactType === "a") {
                    $match = true;
                } elseif (is_numeric($contactType) && $contact->stud_form == $contactType) {
                    $match = true;
                } else {
                    $classData = explode("-", $contactType);
                    if (count($classData) == 2 &&
                        $contact->stud_form == $classData[0] &&
                        $contact->stud_stream == $classData[1]) {
                        $match = true;
                    }
                }

                if ($match) {
                    $avContacts++;
                    $phone = smsPhone($contact->stud_phone);
                    $response['contacts'][] = $phone;
                    $response['select'][] = [
                        'value' => $phone,
                        'label' => ucwords($contact->stud_lname . " " . $contact->stud_fname . " " . $contact->stud_oname) . " [ $phone ]"
                    ];
                }
            }

            if ($avContacts === 0) {
                $response['error'] = "No Students contacts found!";
            }
        } else {
            $response['error'] = "No Students record found to print contacts for!";
        }

        echo json_encode($response);
    }

    public function results($getClass = "")
    {
        $appData = new App;
        $recentExam = $appData->recentExam();
    
        if (!$recentExam) {
            return response()->json(['error' => 'There are no exam results ready to send to parents!']);
        }
    
        $data = [];
        $resultMessages = [];
    
        if (empty($getClass)) {
            for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) {
                $results = $appData->results_analysis($recentExam['exam_key'], $classNum, "meritListData")['currentExam']['meritData'];
                $data = array_merge($data, $results);
            }
        } else {
            $data = $appData->results_analysis($recentExam['exam_key'], $getClass, "meritListData")['currentExam']['meritData'];
        }
    
        $sentCount = 0;
    
        foreach ($data as $value) {
            if ($value['re_marks'] > 0) {
                $subjectsInfo = [];
    
                foreach (SCHSUBJECTS as $subject) {
                    $subInfo = $appData->subInfo($subject->sch_sub_code);
    
                    if ($subInfo) {
                        $code = "re_s" . $subInfo->sub_code;
    
                        if (isset($value[$code]) && $value[$code] !== "--") {
                            $subData = $appData->get_sub_data($subInfo->sub_code, $value[$code]);
    
                            $subjectsInfo[] = [
                                'name'  => $subInfo->sub_name,
                                'marks' => $subData['marks'],
                                'grade' => $subData['grade'],
                            ];
                        }
                    }
                }
    
                $resultMessages[] = [
                    'name'         => $value['re_lname'] . " " . $value['re_name'],
                    'class'        => $value['re_class'],
                    'phone'        => $value['re_phone'],
                    'subjects'     => $subjectsInfo,
                    'total_marks'  => $value['re_marks'],
                    'total_points' => $value['re_pnt'],
                    'mean_grade'   => $value['re_grade'],
                    'form_rank'    => $value['re_frank'],
                ];
    
                $sentCount++;
            }
        }
    
        // if ($sentCount === 0) {
        //     return response()->json(['error' => 'There are no exam results ready to send to parents!']);
        // }
    
        // return response()->json($resultMessages);
        echo json_encode($resultMessages);
    }
}