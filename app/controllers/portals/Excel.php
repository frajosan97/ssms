<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

$reportType = $URL[2];
switch ($reportType) {
    case "term_based":
        define('TERM', $URL[3]);
        define('CLASSNAME', $URL[4]);
        break;
    case "merit":
        define('EXAMKEY', $URL[3]);
        define('CLASSNAME', $URL[4]);
        break;
    case "student":
        if (empty($URL[3])) {
            define("PRINTTYPE", "all");
            define("TITLE", "all students list.");
        } else {
            define("PRINTTYPE", $URL[3]);
            define("TITLE", "form " . str_replace("-", " ", $URL[3]) . " students list.");
        }
        break;
    default:
        break;
}

$appData = new App;
$rowCount = 4;
$sno = 1;
$prefix = ucwords(strtolower(APPINFO->sch_name));

switch ($reportType) {
    case 'student':
        /**
         * ======START STUDENTS SPREADSHEET======
         */
        $allStudents = $appData->sch_students();
        $class = PRINTTYPE;

        if (VIEWFOLDER == "finance") {
            $endLetter = "I";
        } else {
            $endLetter = "H";
        }

        $sheet = $spreadsheet->getActiveSheet()->setTitle(strtoupper(TITLE));
        $mergeColumns = 'A1:' . $endLetter . '1';
        $sheet = $spreadsheet->getActiveSheet()->mergeCells($mergeColumns);
        $sheet->getStyle($mergeColumns)->getAlignment()->setHorizontal('center');
        $sheet->getStyle($mergeColumns)->getFont()->setBold(true);
        $sheet->getStyle($mergeColumns)->getFont()->setSize(14);
        $sheet->setCellValue('A1', strtoupper(APPINFO->sch_name));
        $mergeColumns2 = 'A2:' . $endLetter . '2';
        $sheet = $spreadsheet->getActiveSheet()->mergeCells($mergeColumns2);
        $sheet->getStyle($mergeColumns2)->getAlignment()->setHorizontal('center');
        $sheet->getStyle($mergeColumns2)->getFont()->setBold(true);
        $sheet->setCellValue('A2', strtoupper(TITLE));
        $sheet = $spreadsheet->getActiveSheet();
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->getStyle('A3:' . $endLetter . '3')->getFont()->setBold(true);
        // HEADER
        $sheet->setCellValue('A3', 'S/NO');
        $sheet->setCellValue('B3', 'ADM');
        $sheet->setCellValue('C3', 'FULL NAME');
        $sheet->setCellValue('D3', 'CLASS');
        if (VIEWFOLDER == "finance") {
            $sheet->setCellValue('E3', 'BILLED');
            $sheet->setCellValue('F3', 'PAID');
            $sheet->setCellValue('G3', 'BALANCE');
            $sheet->setCellValue('H3', 'CONTACT');
            $sheet->setCellValue('I3', 'REMARKS');
        } else {
            $sheet->setCellValue('E3', 'KCPE');
            $sheet->setCellValue('F3', 'CONTACT');
            $sheet->setCellValue('G3', 'REMARKS');
            $sheet->setCellValue('H3', 'REMARKS');
        }

        // BODY
        if ($allStudents) {
            $studData = [];
            if ($class == "all") {
                $studData = $allStudents;
            } else {
                if (is_numeric($class)) {
                    foreach ($allStudents as $students) {
                        if ($students->stud_form == $class) {
                            $studData[] = $students;
                        }
                    }
                } else {
                    $classBreak = explode("-", $class);
                    foreach ($allStudents as $students) {
                        if (($students->stud_form == $classBreak[0]) && ($students->stud_stream == $classBreak[1])) {
                            $studData[] = $students;
                        }
                    }
                }
            }
            // print data
            if (count($studData) > 0) {
                foreach ($studData as $stud) {
                    if ($stud->stud_kcpe_marks > 0) {
                        $kcpe = $appData->get_sub_data("kcpe", ($stud->stud_kcpe_marks / 5));
                        $kcpeMarks = $stud->stud_kcpe_marks . " " . $kcpe['grade'];
                    } else {
                        $kcpeMarks = "--";
                    }
                    $finSum = $appData->studentInfo($stud->stud_key)['finSummary'];
                    $sheet->setCellValue('A' . $rowCount, $sno++);
                    $sheet->setCellValue('B' . $rowCount, ucwords($stud->stud_adm));
                    $sheet->setCellValue('C' . $rowCount, ucwords($stud->stud_lname . " " . $stud->stud_fname . " " . $stud->stud_oname));
                    $sheet->setCellValue('D' . $rowCount, ucwords($stud->stud_form . ' ' . $stud->stud_stream));
                    if (VIEWFOLDER == "finance") {
                        $sheet->setCellValue('E' . $rowCount, number_format($finSum['ttBilled'], 2));
                        $sheet->setCellValue('F' . $rowCount, number_format($finSum['ttPaid'], 2));
                        $sheet->setCellValue('G' . $rowCount, number_format($finSum['ttBalance'], 2));
                        $sheet->setCellValue('H' . $rowCount, "0" . $stud->stud_phone);
                        $sheet->setCellValue('I' . $rowCount, "");
                    } else {
                        $sheet->setCellValue('E' . $rowCount, ucwords($kcpeMarks));
                        $sheet->setCellValue('F' . $rowCount, "0" . $stud->stud_phone);
                        $sheet->setCellValue('G' . $rowCount, "");
                        $sheet->setCellValue('H' . $rowCount, "");
                    }
                    $rowCount++;
                }
            } else {
                $mergeColumns = 'A' . $rowCount . ':' . $endLetter . '' . $rowCount;
                $sheet = $spreadsheet->getActiveSheet()->mergeCells($mergeColumns);
                $sheet->getStyle($mergeColumns)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('A' . $rowCount, 'No data available for download for the requested class');
            }
        } else {
            $mergeColumns = 'A' . $rowCount . ':' . $endLetter . '' . $rowCount;
            $sheet = $spreadsheet->getActiveSheet()->mergeCells($mergeColumns);
            $sheet->getStyle($mergeColumns)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('A' . $rowCount, 'No data available for download for the requested class');
        }

        $documentName = ucwords($prefix . "_" . TITLE) . '.xlsx';
        /**
         * ======END STUDENTS SPREADSHEET======
         */
        break;
    case 'staff':
        /**
         * ======START STAFF SPREADSHEET======
         */
        $sheet = $spreadsheet->getActiveSheet()->setTitle("Staff Data");
        $mergeColumns = 'A1:G1';
        $sheet = $spreadsheet->getActiveSheet()->mergeCells($mergeColumns);
        $sheet->getStyle($mergeColumns)->getAlignment()->setHorizontal('center');
        $sheet->getStyle($mergeColumns)->getFont()->setBold(true);
        $sheet->getStyle($mergeColumns)->getFont()->setSize(14);
        $sheet->setCellValue('A1', strtoupper(APPINFO->sch_name));
        $mergeColumns2 = 'A2:G2';
        $sheet = $spreadsheet->getActiveSheet()->mergeCells($mergeColumns2);
        $sheet->getStyle($mergeColumns2)->getAlignment()->setHorizontal('center');
        $sheet->getStyle($mergeColumns2)->getFont()->setBold(true);
        $sheet->setCellValue('A2', strtoupper('STAFF INFORMATION'));
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A3:G3')->getFont()->setBold(true);
        // HEADER
        $sheet->setCellValue('A3', 'S/N');
        $sheet->setCellValue('B3', 'FULL NAME');
        $sheet->setCellValue('C3', 'USERNAME');
        $sheet->setCellValue('D3', 'STAFF NO.');
        $sheet->setCellValue('E3', 'CONTACT');
        $sheet->setCellValue('F3', 'ROLE');
        $sheet->setCellValue('G3', 'REMARKS');
        $allStaff = $appData->sch_staff();
        if ($allStaff) {
            // print data
            foreach ($allStaff as $staff) {
                $sheet->setCellValue('A' . $rowCount, $sno++);
                $sheet->setCellValue('B' . $rowCount, ucwords($staff->user_salutation . ". " . $staff->user_lname . " " . $staff->user_fname));
                $sheet->setCellValue('C' . $rowCount, $staff->user_name);
                $sheet->setCellValue('D' . $rowCount, $staff->user_snumber);
                $sheet->setCellValue('E' . $rowCount, "0" . $staff->user_phone);
                $sheet->setCellValue('F' . $rowCount, ucwords(userRole($staff->user_role)));
                $sheet->setCellValue('G' . $rowCount, "");
                $rowCount++;
            }
        } else {
            $mergeColumns = 'A' . $rowCount . ':G' . $rowCount;
            $sheet = $spreadsheet->getActiveSheet()->mergeCells($mergeColumns);
            $sheet->getStyle($mergeColumns)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('A' . $rowCount, 'No staff records found matching your search type');
        }

        $documentName = $prefix . "_Staff.xlsx";
        /**
         * ======END STAFF SPREADSHEET======
         */
        break;
    case "merit":
        /**
         * ======START MERIT LIST SPREADSHEET======
         */
        $data = $appData->results_analysis(EXAMKEY, CLASSNAME, "pdfMeritData");
        /*===================== START MERIT LIST============================================================================== */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Merit List");
        /**Last letter */
        $highestColumn = num2alpha(alpha2num("D") + count($data['currentExam']['schoolSubjects']) + 6);
        /** auto size cells */
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        /** row one */
        $firstRow = 'A1:' . $highestColumn . '1';
        $sheet->mergeCells($firstRow);
        $sheet->getStyle($firstRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle($firstRow)->getFont()->setBold(true);
        $sheet->getStyle($firstRow)->getFont()->setSize(14);
        $sheet->setCellValue('A1', strtoupper(APPINFO->sch_name));
        /** row two */
        $secondRow = 'A2:' . $highestColumn . '2';
        $sheet->mergeCells($secondRow);
        $sheet->getStyle($secondRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle($secondRow)->getFont()->setBold(true);
        $sheet->getStyle($secondRow)->getFont()->setSize(12);
        $sheet->setCellValue('A2', strtoupper($data['currentExam']['resHeading'] . ' - merit list.'));
        /** row three */
        $thirdRow = 'A3:' . $highestColumn . '3';
        $sheet->getStyle($thirdRow)->getFont()->setBold(true);
        $sheet->getStyle($thirdRow)->getFont()->setSize(12);
        $sheet->setCellValue('A3', 'ADM');
        $sheet->setCellValue('B3', 'STUDENT NAME');
        $sheet->setCellValue('C3', 'CLASS');
        $sheet->setCellValue('D3', 'KCPE.');
        $thisLetter = "E";
        foreach ($data['currentExam']['schoolSubjects'] as $subject) {
            $sheet->setCellValue($thisLetter++ . '3', ucwords($subject->sub_short_name));
        }
        $sheet->setCellValue($thisLetter++ . '3', 'SUB');
        $sheet->setCellValue($thisLetter++ . '3', 'MARKS');
        $sheet->setCellValue($thisLetter++ . '3', 'POINTS');
        $sheet->setCellValue($thisLetter++ . '3', 'AVG');
        $sheet->setCellValue($thisLetter++ . '3', 'GRADE');
        $sheet->setCellValue($thisLetter++ . '3', 'POSITION');
        /** Other rows from number 4 */
        $sno1 = 4;
        foreach ($data['currentExam']['meritData'] as $record => $recordData) {
            $thisLetter = "E";
            $sheet->setCellValue('A' . $sno1, ucwords($recordData['re_adm']));
            $sheet->setCellValue('B' . $sno1, ucwords($recordData['re_lname'] . " " . $recordData['re_name']));
            $sheet->setCellValue('C' . $sno1, ucwords($recordData['re_class']));
            $sheet->setCellValue('D' . $sno1, ucwords($recordData['re_kcpe']));
            foreach ($data['currentExam']['schoolSubjects'] as $subject) {
                $viewSub = "re_s" . $subject->sub_code;
                $subInfo = $appData->get_sub_data($subject->sub_code, $recordData[$viewSub]);
                if ($subInfo['marks'] > 0) {
                    $marks = sprintf("%02d", $subInfo['marks']);
                } else {
                    $marks = $subInfo['marks'];
                }
                $sheet->setCellValue($thisLetter++ . $sno1, ucwords($marks . ' ' . $subInfo['grade']));
            }
            $sheet->setCellValue($thisLetter++ . $sno1, ucwords($recordData['re_subC']));
            $sheet->setCellValue($thisLetter++ . $sno1, ucwords($recordData['re_marks']));
            $sheet->setCellValue($thisLetter++ . $sno1, ucwords($recordData['re_pnt']));
            $sheet->setCellValue($thisLetter++ . $sno1, ucwords($recordData['re_avgpnt']));
            $sheet->setCellValue($thisLetter++ . $sno1, ucwords($recordData['re_grade']));
            $sheet->setCellValue($thisLetter++ . $sno1, ucwords($recordData['re_frank']));
            $sno1++;
        }
        /*===================== END MERIT LIST============================================================================== */
        /*===================== START SUBJECT ANALYSIS============================================================================== */
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle("Subjects Analysis");
        $SHighestColumn = num2alpha(alpha2num("A") + count(DEFAULTGRADES) + 5);
        $sno2 = 1;
        foreach ($data['currentExam']['gradesDistr'] as $grdDist => $grdDistData) {
            /**second row one */
            $SFRow = 'A' . $sno2 . ':' . $SHighestColumn . $sno2;
            $sheet->mergeCells($SFRow);
            $sheet->getStyle($SFRow)->getFont()->setBold(true);
            $sheet->getStyle($SFRow)->getFont()->setSize(12);
            $sheet->setCellValue('A' . $sno2, strtoupper($grdDist . " performance grade distribution"));
            /**second row two */
            $sheet->setCellValue('A' . $sno2, 'form');
            $letter2 = "B";
            foreach (DEFAULTGRADES as $grade => $value) {
                $sheet->setCellValue($letter2++ . $sno2, $grade);
            }
            $sno2++;
        }
        /*===================== END SUBJECT ANALYSIS============================================================================== */
        /*===================== START BEST STUDENTS PER SUBJECT============================================================================== */
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle("Best Student Per Subject");
        /*===================== END BEST STUDENTS PER SUBJECT============================================================================== */
        /** Document name */
        $documentName = $prefix . "_Form_" . CLASSNAME . "_merit_list.xlsx";
        /**
         * ======END MERIT LIST SPREADSHEET======
         */
        break;
    case "term_based":
        /**
         * ======START TERM BASED REPORTS SPREADSHEET======
         */
        $repC = new Report;
        $repData = $repC->term_based(TERM, CLASSNAME);
        /**
         * ======END TERM BASED REPORTS SPREADSHEET======
         */
        break;
    default:
        /**
         * ======START BLANK SPREADSHEET======
         */
        $sheet = $spreadsheet->getActiveSheet()->setTitle("Empty Sheet");
        $mergeColumns = 'A1:J1';
        $sheet = $spreadsheet->getActiveSheet()->mergeCells($mergeColumns);
        $sheet->setCellValue('A1', 'This is an empty excel downloaded from school management system');
        $documentName = $prefix . "_Empty-Excel.xlsx";
        /**
         * ======END BLANK SPREADSHEET======
         */
        break;
}

$writer = new Xlsx($spreadsheet);
header("Content-Type: application/vnd.openxmlformats-officedocuments.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$documentName\"");
$writer->save("php://output");
exit();
