<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$appData = new App;

/**
 * ======START BLANK SPREADSHEET======
 */
$reportType = $URL[1];

switch ($URL[1]) {
    case 'results':
        if(isset($URL[2])) {
            $getClass = $URL[2];
        } else {
            $getClass = '';
        }
        $appData = new App;
        $recentExam = $appData->recentExam();
        $data = [];
        if ($recentExam) {
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
        }

        $sheet = $spreadsheet->getActiveSheet()->setTitle("Contacts List");
        $mergeColumns = 'A1:B1';
        $sheet = $spreadsheet->getActiveSheet()->mergeCells($mergeColumns);
        $sheet->getStyle($mergeColumns)->getAlignment()->setHorizontal('center');
        $sheet->getStyle($mergeColumns)->getFont()->setBold(true);
        $sheet->getStyle($mergeColumns)->getFont()->setSize(14);
        $sheet->setCellValue('A1', strtoupper(APPINFO->sch_name . " results messages"));
        $sheet->setCellValue('A2', "Phone Number");
        $sheet->setCellValue('B2', "Message");
        $sheet = $spreadsheet->getActiveSheet();
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sno = 3;
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
                $message .= "NB: To download the report form, go to " . ROOT . "student \nAdm: " . $value['re_adm'] . " \nPassword: 12345678";
                // Print data
                $sheet->setCellValue('A' . $sno, "0" . $phoneNumber);
                $sheet->setCellValue('B' . $sno, str_replace("\n", " ", $message));
                $sno++;
            }
        }
        $nameSlag = "Results Messages";

        break;
    default:

        $contactType = $URL[2];
        $allStudents = $appData->sch_students();
        if ($allStudents) {
            $avContacts = 0;
            if ($contactType == "a") {
                foreach ($allStudents as $contact) {
                    if (!($contact->stud_form == "alumni")) {
                        $allContacts[] = smsPhone($contact->stud_phone);
                    }
                }
            } else {
                if (is_numeric($contactType)) {
                    foreach ($allStudents as $contact) {
                        if (!($contact->stud_form == "alumni")) {
                            if ($contact->stud_form == $contactType) {
                                $allContacts[] = smsPhone($contact->stud_phone);
                            }
                        }
                    }
                } else {
                    $classData = explode("-", $contactType);
                    foreach ($allStudents as $contact) {
                        if (!($contact->stud_form == "alumni")) {
                            if (($contact->stud_form == $classData[0]) && ($contact->stud_stream == $classData[1])) {
                                $allContacts[] = smsPhone($contact->stud_phone);
                            }
                        }
                    }
                }
            }
        }

        $sheet = $spreadsheet->getActiveSheet()->setTitle("Contacts List");
        $mergeColumns = 'A1:B1';
        $sheet = $spreadsheet->getActiveSheet()->mergeCells($mergeColumns);
        $sheet->getStyle($mergeColumns)->getAlignment()->setHorizontal('center');
        $sheet->getStyle($mergeColumns)->getFont()->setBold(true);
        $sheet->getStyle($mergeColumns)->getFont()->setSize(14);
        $sheet->setCellValue('A1', strtoupper(APPINFO->sch_name));
        $sheet->setCellValue('A2', "Phone Number");
        $sheet->setCellValue('B2', "Message");
        $sheet = $spreadsheet->getActiveSheet();
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sno = 3;
        foreach ($allContacts as $key => $value) {
            $sheet->setCellValue('A' . $sno, $value);
            $sheet->setCellValue('B' . $sno, $value);
            $sno++;
        }
        $nameSlag = "Contacts List";
        /** ======END BLANK SPREADSHEET====== */

        break;
}

$writer = new Xlsx($spreadsheet);
$documentName = ucwords(rawSmartKey(APPINFO->sch_name . " " . $nameSlag)) . ".xlsx";
header("Content-Type: application/vnd.openxmlformats-officedocuments.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$documentName\"");
$writer->save("php://output");
exit();
