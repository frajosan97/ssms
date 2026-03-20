<?php

// HEADERS SWITCH
$reportType = $URL[2];
switch ($reportType) {
    case "report_forms":
        define('TYPE', $URL[3]);
        define('EXAMKEY', $URL[4]);
        define('CLASSNAME', $URL[5]);
        if (empty($URL[6])) {
            define('FILTER', "");
        } else {
            define('FILTER', $URL[6]);
        }
        break;
    case "merit":
        define('EXAMKEY', $URL[3]);
        define('CLASSNAME', $URL[4]);
        break;
    case "invoice":
        define('INVOICEKEY', $URL[3]);
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

// DEFINE MODE OF OPENING THE DOCUMENT DEPENDING ON THE DEVICE VIEW
if (isMobile()) {
    define("VIEWTYPE", "D");
} else {
    define("VIEWTYPE", "I");
}

switch ($reportType) {
    case 'merit':
        /**
         * =================================================================================================
         * ==================MERIT START====================================================================
         */
        class pdf extends FPDF
        {
            public function docSettings()
            {
                return ["docOrient" => "L", "docName" => ucwords(smartKey("form  " . CLASSNAME . " merit list")), "docViewType" => VIEWTYPE, "class" => CLASSNAME];
            }
            public function header() {}
            public function body()
            {
                $appData = new App;
                $data = $appData->results_analysis(EXAMKEY, CLASSNAME, "pdfMeritData");
                $cellWidth = (277 - 150) / (count($data['currentExam']['schoolSubjects']));
                // MERIT LETTER HEAD (APPLY ONLY TO PAGE 1)
                $this->Image(pdfimageCheck("logos", APPINFO->sch_logo, "default.png"), 10, 10, -150);
                $this->setFont('Times', 'UB', 16);
                $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetFillColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetDrawColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->Cell(0, 6, strtoupper(APPINFO->sch_name), 0, 0, 'C');
                $this->setFont('', '', 12);
                $this->SetTextColor(0, 0, 0);
                $this->Cell(0, 6, 'Email: ' . APPINFO->sch_email, 0, 0, 'R');
                $this->Ln();
                $this->Cell(0, 6, strtoupper('P.O BOX ' . APPINFO->sch_address . ' - ' . APPINFO->sch_postcode . " " . APPINFO->sch_town . " - " . APPINFO->sch_city), 0, 0, 'C');
                $this->Cell(0, 6, 'Tell: ' . smartPhone(APPINFO->sch_phone), 0, 0, 'R');
                $this->Ln();
                $this->setFont('', 'B', 12);
                $this->Cell(0, 6, strtoupper($data['currentExam']['resHeading'] . ' - merit list.'), 0, 0, 'C');
                $this->setFont('', '', 10);
                $this->SetTextColor(0, 0, 0);
                $this->Cell(0, 6, 'Printent On: ' . date('D, d-m-Y h:i A'), 0, 0, 'R');
                $this->SetLineWidth(0.5);
                $this->Line(287, 28, 10, 28);
                $this->Ln(8);
                // MERIT TABLE HEADER
                $this->SetDrawColor(0, 0, 0);
                $this->SetLineWidth(0);
                $this->setFont('', 'B', 10);
                $this->Cell(10, 6, 'Adm', 1, 0, 'C');
                $this->Cell(49, 6, 'Student Name', 1, 0, 'L');
                $this->Cell(15, 6, 'Class', 1, 0, 'C');
                $this->Cell(12, 6, 'Kcpe', 1, 0, 'C');
                foreach ($data['currentExam']['schoolSubjects'] as $subject) {
                    $this->Cell($cellWidth, 6, ucwords($subject->sub_short_name), 1, 0, 'C');
                }
                $this->Cell(9, 6, 'Sub', 1, 0, 'C');
                $this->Cell(10, 6, 'Mark', 1, 0, 'C');
                $this->Cell(11, 6, 'Pnt', 1, 0, 'C');
                $this->Cell(9, 6, 'Avg', 1, 0, 'C');
                $this->Cell(9, 6, 'Grd', 1, 0, 'C');
                $this->Cell(15, 6, 'Postn', 1, 0, 'C');
                $this->Ln();
                $this->setFont('', '', 10);
                // END MERIT TABLE HEADER
                if (!(isset($data['currentExam']['notFound']))) {
                    // START MERIT STUDENTS DATA
                    foreach ($data['currentExam']['meritData'] as $record => $recordData) {
                        $this->Cell(10, 6, ucwords($recordData['re_adm']), 1, 0, 'L');
                        $this->Cell(49, 6, ucwords($recordData['re_lname'] . " " . $recordData['re_name']), 1, 0, 'L');
                        $this->Cell(15, 6, ucwords($recordData['re_class']), 1, 0, 'L');
                        $this->Cell(12, 6, ucwords($recordData['re_kcpe']), 1, 0, 'C');
                        foreach ($data['currentExam']['schoolSubjects'] as $subject) {
                            $viewSub = "re_s" . $subject->sub_code;
                            $subInfo = $appData->get_sub_data($subject->sub_code, $recordData[$viewSub]);
                            $this->Cell($cellWidth, 6, ucwords($subInfo['marks'] . " " . $subInfo['grade']), 1, 0, 'C');
                        }
                        $this->Cell(9, 6, ucwords($recordData['re_subC']), 1, 0, 'C');
                        $this->setFont('', 'B', 10);
                        $this->SetTextColor(0, 0, 255);
                        $this->Cell(10, 6, ucwords($recordData['re_marks']), 1, 0, 'C');
                        $this->SetTextColor(0, 255, 0);
                        $this->Cell(11, 6, ucwords($recordData['re_pnt']), 1, 0, 'C');
                        $this->SetTextColor(255, 0, 0);
                        $this->Cell(9, 6, ucwords($recordData['re_avgpnt']), 1, 0, 'C');
                        $this->SetTextColor(0, 0, 0);
                        $this->Cell(9, 6, ucwords($recordData['re_grade']), 1, 0, 'L');
                        $this->SetTextColor(0, 0, 0);
                        $this->Cell(15, 6, ucwords($recordData['re_frank']), 1, 0, 'C');
                        $this->SetTextColor(0, 0, 0);
                        $this->setFont('', '', 10);
                        $this->Ln();
                    }
                    // END MERIT STUDENTS DATA
                    $this->AddPage($this->docSettings()['docOrient'], 'A4', 0);
                    // START MERIT GRADES DISTRIBUTION DATA
                    foreach ($data['currentExam']['gradesDistr'] as $grdDist => $grdDistData) {
                        $this->setFont('', 'B', 10);
                        $this->Cell(0, 6, strtoupper($grdDist . " performance grade distribution"), 1, 0, 'L');
                        $this->Ln();
                        $this->Cell(35, 6, ucwords("form"), 1, 0, 'L');
                        foreach (DEFAULTGRADES as $grade => $value) {
                            $this->Cell(((277 - 130) / 13), 6, ucwords($grade), 1, 0, 'C');
                        }
                        $this->Cell(15, 6, ucwords("entries"), 1, 0, 'L');
                        $this->Cell(15, 6, ucwords("mean"), 1, 0, 'L');
                        $this->Cell(15, 6, ucwords("points"), 1, 0, 'L');
                        $this->Cell(15, 6, ucwords("grade"), 1, 0, 'L');
                        $this->Cell(35, 6, ucwords("teacher"), 1, 0, 'L');
                        $this->Ln();
                        $this->setFont('', '', 10);
                        foreach ($grdDistData as $grdDataKey => $finalData) {
                            $this->Cell(35, 6, ucwords($grdDataKey), 1, 0, 'L');
                            foreach (DEFAULTGRADES as $grade => $value) {
                                $this->Cell(((277 - 130) / 13), 6, ucwords($finalData[$grade]), 1, 0, 'C');
                            }
                            $this->Cell(15, 6, ucwords($finalData['entries']), 1, 0, 'L');
                            $this->Cell(15, 6, ucwords(number_format($finalData['mMarks'], 2)), 1, 0, 'L');
                            $this->Cell(15, 6, ucwords(number_format($finalData['mPoints'], 2)), 1, 0, 'L');
                            $this->Cell(15, 6, ucwords($finalData['grade']), 1, 0, 'L');
                            $this->Cell(35, 6, ucwords($finalData['cTeacher']), 1, 0, 'L');
                            $this->Ln();
                        }
                        $this->Ln(4);
                    }
                    // END MERIT GRADES DISTRIBUTION DATA
                } else {
                    $this->MultiCell(0, 6, $data['currentExam']['notFound'], 1, 'C');
                }
            }
            public function footer()
            {
                $this->SetY(-20);
                $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetFillColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetDrawColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetLineWidth(0.5);
                $this->Line(287, 190, 10, 190);
                $this->Cell(0, 10, ucwords(APPINFO->sch_name), 0, 0, 'L');
                $this->cell(0, 10, 'Printent On: ' . date('D, d-m-Y h:i A') . '.', 0, 0, 'R');
            }
        }
        /**
         * ===============================================================================================
         * ==================MERIT END====================================================================
         */
        break;
    case 'report_forms':
        /**
         * =================================================================================================
         * ==================REPORT FORM START==============================================================
         */
        class pdf extends FPDF
        {
            public function docSettings()
            {
                return ["docOrient" => "P",  "docName" => ucwords(smartKey("form  " . CLASSNAME . " report forms")), "docViewType" => VIEWTYPE, "class" => CLASSNAME];
            }
            function header()
            {
                $appData = new App;
                $examInfo = $appData->examInfo(EXAMKEY);
                $this->setFont('Times', 'UB', 16);
                $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetDrawColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->Image(pdfimageCheck("logos", APPINFO->sch_logo, "default.png"), 180, 10, 20);
                $this->Cell(0, 6, strtoupper(APPINFO->sch_name), 0, 0, 'L');
                $this->Ln();
                $this->setFont('', 'B', 12);
                $this->Cell(0, 6, strtoupper('P.O BOX ' . APPINFO->sch_address . ' - ' . APPINFO->sch_postcode . " " . APPINFO->sch_town . " - " . APPINFO->sch_city), 0, 0, 'L');
                $this->Ln();
                $this->SetTextColor(0, 0, 0);
                $this->setFont('', '', 12);
                $this->cell(0, 6, 'Email: ' . APPINFO->sch_email . " | Tel: " . smartPhone(APPINFO->sch_phone), 0, 0, 'L');
                $this->Ln();
                $this->SetFont('', 'UB', 12);
                $this->SetTextColor(255, 0, 0);
                $this->cell(0, 6, strtoupper('student progress report - ' . $examInfo->exam . ' exam - ' . date('M, Y', strtotime($examInfo->date)) . ' .'), 0, 0, 'L');
                $this->Ln();
                $this->Line(200, 35, 10, 35);
                $this->Ln(2);
            }
            function body()
            {
                $appData = new App;
                $allResults = $appData->sch_results();
                $examKey = EXAMKEY;
                $className = CLASSNAME;
                $examInfo = $appData->examInfo(EXAMKEY);
                $resCount = 0;
                if ($allResults) {
                    foreach ($allResults as $resRec) {
                        if (TYPE == "s") { // single reportform
                            if ($resRec->re_key == FILTER) {
                                $resCount += 1;
                                $thisResults[] = $resRec;
                            }
                        } elseif (TYPE == "f") { // form report forms
                            if ($resRec->re_exam == $examKey && $resRec->re_studF == $className) {
                                $resCount += 1;
                                $thisResults[] = $resRec;
                            }
                        } else { // Stream report forms
                            if ($resRec->re_exam == $examKey && $resRec->re_studF == $className && $resRec->re_studS == FILTER) {
                                $resCount += 1;
                                $thisResults[] = $resRec;
                            }
                        }
                    }
                    // data
                    if ($resCount > 0) {
                        foreach ($thisResults as $report => $reportData) {
                            // student data
                            $studInfo = $appData->studentInfo($reportData->re_studK);
                            // subjects
                            if ($reportData->re_subC >= 10) {
                                if (APPINFO->sch_sum_type == "all") {
                                    $studSubRec = array_merge($studInfo['subjects']['active'], $studInfo['subjects']['dropped']);
                                } else {
                                    $studSubRec = $studInfo['subjects']['active'];
                                }
                            } else {
                                $studSubRec = $studInfo['subjects']['active'];
                            }
                            $finalSubCount = count($studSubRec);
                            // previous exam
                            $nowDev = "--";
                            $nowDevPrev = "--";
                            $prevExam = $appData->studPrevExam($reportData->re_studK, $examKey);
                            if ($prevExam) {
                                $nowDev = $reportData->re_avgpnt - $prevExam->re_avgpnt;
                                $prevPrevExam = $appData->studPrevExam($reportData->re_studK, $prevExam->re_exam);
                                if ($prevPrevExam) {
                                    $nowDevPrev = $prevExam->re_avgpnt - $prevPrevExam->re_avgpnt;
                                }
                                $prevExamInfo = $appData->examInfo($prevExam->re_exam);
                            }
                            $kcpeMarks = $studInfo['profile']->stud_kcpe_marks;
                            if ($kcpeMarks > 0) {
                                $kcpeFinal = ($kcpeMarks / 5);
                            } else {
                                $kcpeFinal = 0;
                            }
                            $kcpeInfo = $appData->get_sub_data("kcpe", ($kcpeFinal));
                            // PROFILE INFORMATION
                            $this->Ln(3);
                            $this->Image(pdfimageCheck("profiles", $studInfo['profile']->stud_pass, "avatar.png"), 10, 40, 22);
                            $this->Cell(30, 6, '', 0, 0, 'L');
                            $this->setFont('Times', 'B', 12);
                            $this->SetTextColor(0, 0, 0);
                            $this->Cell(15, 6, 'NAME: ', 0, 0, 'L');
                            $this->setFont('Times', 'UB', 12);
                            $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                            $this->Cell(0, 6, strtoupper($studInfo['profile']->stud_lname . " " . $studInfo['profile']->stud_fname . " " . $studInfo['profile']->stud_oname . "  ."), 0, 0, 'L');
                            $this->Ln();
                            $this->Cell(30, 6, '', 0, 0, 'L');
                            $this->setFont('Times', 'B', 12);
                            $this->SetTextColor(0, 0, 0);
                            $this->Cell(25, 6, 'ADM. NO: ', 0, 0, 'L');
                            $this->setFont('Times', 'UB', 12);
                            $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                            $this->Cell(30, 6, strtoupper("       " . $studInfo['profile']->stud_adm . "       ."), 0, 0, 'L');
                            $this->setFont('Times', 'B', 12);
                            $this->SetTextColor(0, 0, 0);
                            $this->Cell(15, 6, 'FORM: ', 0, 0, 'L');
                            $this->setFont('Times', 'UB', 12);
                            $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                            $this->Cell(30, 6, strtoupper("  " . $reportData->re_studF . " " . $reportData->re_studS . "  ."), 0, 0, 'L');
                            $this->setFont('Times', 'B', 12);
                            $this->SetTextColor(0, 0, 0);
                            $this->Cell(30, 6, 'KCPE MARKS: ', 0, 0, 'L');
                            $this->setFont('Times', 'UB', 12);
                            $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                            $this->Cell(0, 6, strtoupper("  " . $kcpeMarks . " " . $kcpeInfo['grade'] . "  ."), 0, 0, 'L');
                            $this->Ln();
                            $this->Cell(30, 6, '', 0, 0, 'L');
                            $this->setFont('Times', 'B', 10);
                            $this->SetTextColor(0, 0, 0);
                            $this->Cell(35, 6, '', 1, 0, 'L');
                            $this->Cell(30, 6, 'MARKS', 1, 0, 'C');
                            $this->Cell(30, 6, 'POINTS', 1, 0, 'C');
                            $this->Cell(20, 6, 'V.A.P', 1, 0, 'C');
                            $this->Cell(15, 6, 'GRADE', 1, 0, 'C');
                            $this->Cell(30, 6, 'POSITION', 1, 0, 'C');
                            $this->Ln();
                            $this->Cell(30, 6, '', 0, 0, 'L');
                            $this->Cell(35, 6, 'CURRENT EXAMS: ', 1, 0, 'L');
                            $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                            $this->Cell(30, 6, $reportData->re_tt . " / " . $reportData->re_subC * 100, 1, 0, 'C');
                            $this->Cell(30, 6, $reportData->re_pnt . " / " . $reportData->re_subC * 12, 1, 0, 'C');
                            $this->Cell(20, 6, $nowDev, 1, 0, 'C');
                            $this->Cell(15, 6, $reportData->re_grade, 1, 0, 'C');
                            $this->Cell(30, 6, $reportData->re_fRank, 1, 0, 'C');
                            $this->Ln();
                            $this->Cell(30, 6, '', 0, 0, 'L');
                            $this->SetTextColor(0, 0, 0);
                            $this->Cell(35, 6, 'LAST EXAMS: ', 1, 0, 'L');
                            $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                            if ($prevExam) {
                                $this->Cell(30, 6, $prevExam->re_tt . " / " . $prevExam->re_subC * 100, 1, 0, 'C');
                                $this->Cell(30, 6, $prevExam->re_pnt . " / " . $prevExam->re_subC * 12, 1, 0, 'C');
                                $this->Cell(20, 6, $nowDevPrev, 1, 0, 'C');
                                $this->Cell(15, 6, $prevExam->re_grade, 1, 0, 'C');
                                $this->Cell(30, 6, $prevExam->re_fRank, 1, 0, 'C');
                            } else {
                                $this->Cell(30, 6, "--", 1, 0, 'C');
                                $this->Cell(30, 6, "--", 1, 0, 'C');
                                $this->Cell(20, 6, "--", 1, 0, 'C');
                                $this->Cell(15, 6, "--", 1, 0, 'C');
                                $this->Cell(30, 6, "--", 1, 0, 'C');
                            }
                            $this->Ln(8);
                            // subjects
                            $this->setFont('Times', 'B', 11);
                            $this->Cell(40, 6, 'Subjects', 1, 0, 'L');
                            if ($prevExam) {
                                $this->Cell(15, 6, strtoupper(acronym($prevExamInfo->exam)), 1, 0, 'L');
                                $this->Cell(15, 6, strtoupper(acronym($examInfo->exam)), 1, 0, 'L');
                            } else {
                                $this->Cell(30, 6, strtoupper(acronym($examInfo->exam)), 1, 0, 'L');
                            }
                            $this->Cell(15, 6, 'Points', 1, 0, 'L');
                            $this->Cell(15, 6, 'Grade', 1, 0, 'L');
                            $this->Cell(15, 6, 'Dev', 1, 0, 'L');
                            $this->Cell(20, 6, 'Sub Rank', 1, 0, 'L');
                            $this->Cell(35, 6, "Comment", 1, 0, 'L');
                            $this->Cell(20, 6, 'Teacher', 1, 0, 'L');
                            $this->Ln();
                            $this->setFont('Times', '', 11);
                            $this->SetTextColor(0, 0, 0);
                            foreach ($studSubRec as $subject) {
                                $viewSub = "re_s" . $subject->sub_code;
                                if ($reportData->$viewSub > 0) {
                                    $thisSubData = $appData->get_sub_data($subject->sub_code, $reportData->$viewSub);
                                    // sub dev
                                    $dev = "--";
                                    if ($prevExam) {
                                        if (($prevExam->$viewSub) > 0 && ($thisSubData['marks'] > 0)) {
                                            $dev = $thisSubData['marks'] - $prevExam->$viewSub;
                                        }
                                    }
                                    $fSSR = "--";
                                    $allStudThisSub = [];
                                    foreach ($allResults as $res2) {
                                        if (($res2->re_studF == $reportData->re_studF) && ($res2->re_exam == $reportData->re_exam) && ($res2->$viewSub > 0)) {
                                            $allStudThisSub[$res2->re_key] = $res2->$viewSub;
                                        }
                                    }
                                    $subRank = array_rank($allStudThisSub);
                                    foreach ($subRank as $key => $value) {
                                        if ($key == $reportData->re_key) {
                                            $fSSR = $value . "/" . count($subRank);
                                        }
                                    }
                                    // subject teacher
                                    $subTeacher = $appData->subTeacher($reportData->re_studF, $reportData->re_studS, $subject->sub_code);
                                    if (!(empty($subTeacher['teacherName']))) {
                                        $subTeacherAbbr = acronym($subTeacher['teacherName']);
                                    } else {
                                        $subTeacherAbbr = "--";
                                    }
                                    // print the results
                                    $this->Cell(40, 6, ucwords($subject->sub_code . " " . $subject->sub_name), 1, 0, 'L');
                                    if ($prevExam) {
                                        $this->Cell(15, 6, ucwords($prevExam->$viewSub), 1, 0, 'C');
                                        $this->Cell(15, 6, ucwords($thisSubData['marks']), 1, 0, 'C');
                                    } else {
                                        $this->Cell(30, 6, ucwords($thisSubData['marks']), 1, 0, 'C');
                                    }
                                    $this->Cell(15, 6, ucwords($thisSubData['points']), 1, 0, 'C');
                                    $this->Cell(15, 6, ucwords($thisSubData['grade']), 1, 0, 'C');
                                    $this->Cell(15, 6, ucwords($dev), 1, 0, 'L');
                                    $this->Cell(20, 6, ucwords($fSSR), 1, 0, 'C');
                                    $this->Cell(35, 6, ucwords($thisSubData['rem']), 1, 0, 'L');
                                    $this->Cell(20, 6, strtoupper($subTeacherAbbr), 1, 0, 'L');
                                    $this->Ln();
                                } else {
                                    $this->Cell(40, 6, ucwords($subject->sub_code . " " . $subject->sub_name), 1, 0, 'L');
                                    $this->Cell(15, 6, "--", 1, 0, 'C');
                                    $this->Cell(15, 6, "--", 1, 0, 'C');
                                    $this->Cell(15, 6, "--", 1, 0, 'C');
                                    $this->Cell(15, 6, "--", 1, 0, 'C');
                                    $this->Cell(15, 6, "--", 1, 0, 'L');
                                    $this->Cell(20, 6, "--", 1, 0, 'C');
                                    $this->Cell(35, 6, "--", 1, 0, 'L');
                                    $this->Cell(20, 6, "--", 1, 0, 'L');
                                    $this->Ln();
                                }
                            }
                            // graphical analysis
                            $this->setFont('Times', 'B', 11);
                            $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                            if ($reportData->re_studF == 1) {
                                $this->Cell(0, 6, "STUDENT PERFORMANCE TREND. SUMMARIZED REPORT FOR FORM 1", 1, 0, 'C');
                            } else {
                                $this->Cell(0, 6, "STUDENT PERFORMANCE TREND. SUMMARIZED REPORT FROM FORM 1 TO FORM " . $reportData->re_studF, 1, 0, 'C');
                            }
                            $this->setFont('Times', '', 11);
                            $this->SetTextColor(0, 0, 0);
                            $this->Ln();
                            $allStudResCount = count($studInfo['results']);
                            $allTimeData = [];
                            sort($studInfo['results']);
                            foreach ($studInfo['results'] as $graphData) {
                                $termInfo = $appData->termInfo($graphData->re_term);
                                $examInfo = $appData->examInfo($graphData->re_exam);
                                // prepare data
                                $allTimeData[] = array(
                                    "class" => strtoupper("f" . $graphData->re_studF . "t" . $termInfo->term) . " " . strtoupper(substr($examInfo->exam, 0, 2)),
                                    "time" => $graphData->date,
                                    "total" => $graphData->re_tt,
                                    "mean" => $graphData->re_mean,
                                    "points" => $graphData->re_avgpnt,
                                    "grade" => $graphData->re_grade,
                                    "position" => $graphData->re_fRank
                                );
                            }
                            // trim data to 12 records
                            $allTimeData = array_slice($allTimeData, 0, 12);
                            // fill color
                            $this->SetFillColor(RGBA[0], RGBA[1], RGBA[2]);
                            //barwidth
                            if (count($allTimeData) > 10) {
                                $barWidth = 160 / count($allTimeData);
                            } else {
                                $barWidth = 15;
                            }
                            //data max
                            $dataMax = 100;
                            $dataStep = 10;
                            $datacount = count($allTimeData); // data count
                            //position
                            $chartX = 10;
                            $chartY = 77 + ($finalSubCount * 6) + 6;
                            //width
                            $chartWidth = 190;
                            $chartHeight = 54;
                            //padding
                            $chartTopPadding = 10;
                            $chartLeftPadding = 15;
                            $chartBottomPadding = 10;
                            $chartRightPadding = 5;
                            //chart box
                            $chartBoxX = $chartX + $chartLeftPadding;
                            $chartBoxY = $chartY + $chartTopPadding;
                            $chartBoxWidth = $chartWidth - ($chartLeftPadding + $chartRightPadding);
                            $chartBoxHeight = $chartHeight - ($chartTopPadding + $chartBottomPadding);
                            //set fornt line width and color
                            $this->SetFont('', '', '9');
                            $this->SetLineWidth(0.1);
                            $this->SetDrawColor(0);
                            //chartboundary
                            $this->Rect($chartX, $chartY, $chartWidth, $chartHeight);
                            // SET AXIX (Y & X)
                            $this->Line($chartBoxX, $chartBoxY, $chartBoxX, $chartBoxY + $chartBoxHeight);
                            $this->Line($chartBoxX - 2, $chartBoxY + $chartBoxHeight, $chartBoxX + $chartBoxWidth, $chartBoxY + $chartBoxHeight);
                            //draw the vertical y axis lables
                            $yAxisUnits = $chartBoxHeight / $dataMax;
                            // KCPE LINE MARK
                            $kcpeLineHeight = $yAxisUnits * (100 - $kcpeInfo['marks']);
                            for ($i = 0; $i <= $dataMax; $i += $dataStep) {
                                $yAxisPos = $chartBoxY + ($yAxisUnits * $i); // y position
                                $this->Line($chartBoxX - 2, $yAxisPos, $chartBoxX, $yAxisPos); // draw y axis data steps
                                $this->SetXY($chartBoxX - $chartLeftPadding, $yAxisPos - 2); // set cell position for y axis labels
                                $this->Cell($chartLeftPadding - 4, 5, $dataMax - $i, 0, 0, 'R'); // write labels
                            }
                            //horizodal axis
                            $this->SetXY($chartBoxX, $chartBoxY + $chartBoxHeight);
                            //cell's width
                            $xLabelWidth = $chartBoxWidth / $datacount;
                            //loop horizontal axis and fill data
                            $barXPos = 0;
                            foreach (array_slice($allTimeData, 0, 12) as $itemName => $item) {
                                $this->Cell($xLabelWidth, 5, $item['class'], 0, 0, 'C'); //print the label
                                $barHeight = $yAxisUnits * $item['mean']; // bar heights
                                $barX = ($xLabelWidth / 2) + ($xLabelWidth * $barXPos);
                                $barX = $barX - ($barWidth / 2);
                                $barX = $barX + $chartBoxX; //bar x position
                                $barY = $chartBoxHeight - $barHeight;
                                $barY = $barY + $chartBoxY; //bar y position
                                $this->setDrawColor(RGBA[0], RGBA[1], RGBA[2]); //draw the bar
                                $this->Rect($barX, $barY, $barWidth, $barHeight, 'DF');
                                $barXPos++;
                                $this->setDrawColor(0, 0, 0);
                            }
                            // axis labels
                            $this->SetFont('', 'B', '9');
                            $this->SetXY($chartX, $chartY);
                            $this->Cell(0, 5, "Mean Score");
                            $this->SetXY($chartX, $chartBoxY + $kcpeLineHeight - (5));
                            $this->SetFont('', 'I', '8');
                            $this->Cell(0, 5, "KCPE Mean ( " . number_format($kcpeInfo['marks'], 2) . " " . $kcpeInfo['grade'] . " )", 0, 0, 'R');
                            $this->SetFont('', 'B', '9');
                            $this->SetXY(($chartX / 2), $chartY + $chartHeight - ($chartBottomPadding / 2));
                            $this->Cell(0, 5, "Class and Term", 0, 0, 'C');
                            $this->SetLineWidth(0.05);
                            $this->SetDrawColor(275, 0, 0);
                            $this->Line($chartBoxX, $chartBoxY + $kcpeLineHeight, $chartBoxX + $chartBoxWidth, $chartBoxY + $kcpeLineHeight);
                            $this->Ln();
                            // END GRAPHICAL ANALYSIS =====================
                            // PERFORMANCE TREND =========================
                            $this->SetDrawColor(0, 0, 0);
                            foreach (DATAHEADERS as $key => $value) {
                                if ($key == array_key_first(DATAHEADERS)) {
                                    $this->Cell(15, 6, ucwords($key), 1, 0, 'L');
                                    foreach (array_slice($allTimeData, 0, 12) as $itemName2 => $item2) {
                                        $this->Cell((175 / $datacount), 6, $item2[$value], 1, 0, 'C');
                                    }
                                } else {
                                    $this->SetFont('', 'B', '10');
                                    $this->Cell(15, 6, ucwords($key), 1, 0, 'L');
                                    $this->SetFont('', '', '10');
                                    foreach (array_slice($allTimeData, 0, 12) as $itemName2 => $item2) {
                                        $this->Cell((175 / $datacount), 6, $item2[$value], 1, 0, 'C');
                                    }
                                }
                                $this->Ln();
                            }
                            // END PERFORMANCE TREND =========================
                            // COMMENTS AND SIGNATORIES ======================
                            // class teacher
                            $classTeacher = "";
                            $clTeacherData = $appData->getClassTeacher($reportData->re_studF, $reportData->re_studS);
                            if ($clTeacherData) {
                                $classTeacher = $clTeacherData->user_fname . " " . $clTeacherData->user_lname;
                            }
                            $this->MultiCell(190, 6, 'CLASS TEACHER REMARKS:    ' . perfComment("teacher", $reportData->re_mean), 1, 'L');
                            $this->Cell(47.5, 6, 'Date: ' . date("D, d/m/Y"), 1, 0, 'L');
                            $this->Cell(47.5, 6, 'Name: ' . strtoupper($classTeacher), 1, 0, 'L');
                            $this->Cell(47.5, 6, 'Signature: ..............................', 1, 0, 'L');
                            $this->Cell(47.5, 6, 'Stamp: .....................................', 1, 0, 'L');
                            $this->Ln();
                            $this->MultiCell(190, 6, 'PRINCIPAL REMARKS:           ' . perfComment("principal", $reportData->re_mean), 1, 'L');
                            $this->Cell(47.5, 6, 'Date: ' . date("D, d/m/Y"), 1, 0, 'L');
                            $this->Cell(47.5, 6, 'Name: ' . strtoupper(APPINFO->principal['name']), 1, 0, 'L');
                            $this->Cell(47.5, 6, 'Signature: ..............................', 1, 0, 'L');
                            $this->Cell(47.5, 6, 'Stamp: .....................................', 1, 0, 'L');
                            $this->Ln();
                            // $this->MultiCell(190, 6, 'Next term begins on:    ', 1, 'L');
                            // END COMMENTS AND SIGNATORIES ======================
                            // Add page
                            if (!($report == array_key_last($thisResults))) {
                                $this->AddPage($this->docSettings()['docOrient'], 'A4', 0);
                            }
                        }
                    } else {
                        $this->MultiCell(0, 6, "No report forms ready for printing!", 1, 'C');
                    }
                } else {
                    $this->MultiCell(0, 6, "No report forms ready for printing!", 1, 'C');
                }
            }
            function footer()
            {
                $this->SetY(-20);
                $this->setFont('Times', 'B', 12);
                $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetDrawColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->Cell(0, 0, '', 1, 1, 'L');
                $this->Cell(0, 10, ucwords(APPINFO->sch_name), 0, 0, 'L');
                $this->cell(0, 10, 'Printent On: ' . date('D, d-m-Y h:i A') . '.', 0, 0, 'R');
            }
        }
        /**
         * =================================================================================================
         * ==================REPORT FORM END================================================================
         */
        break;
    case "invoice":
        /**
         * =================================================================================================
         * ==================INVOICE START==============================================================
         */
        class pdf extends FPDF
        {
            public function docSettings()
            {
                return ["docOrient" => "P", "docName" => ucwords(smartKey("Invoice " . INVOICEKEY)), "docViewType" => VIEWTYPE];
            }
            public function header()
            {
                $this->setFont('Times', '', 12);
                $this->Image(pdfimageCheck("logos", C_LOGO, "default.png"), 10, 10, 35);
                $this->setFont('', '', 14);
                $this->SetTextColor(0, 0, 255);
                $this->Cell(0, 6, strtoupper(BILLING_ADDRESS['cname']), 0, 0, 'R');
                $this->Ln();
                $this->setFont('', '', 12);
                $this->SetTextColor(0, 0, 0);
                $this->Cell(0, 6, BILLING_ADDRESS['caddress'], 0, 0, 'R');
                $this->Ln();
                $this->Cell(0, 6, 'Phone: ' . BILLING_ADDRESS['tel'], 0, 0, 'R');
                $this->Ln();
                $this->Cell(0, 6, 'Email: ' . BILLING_ADDRESS['email'], 0, 0, 'R');
                $this->Ln();
                $this->Cell(0, 6, 'Website: ' . BILLING_ADDRESS['website'], 0, 0, 'R');
                $this->Ln();
                $this->setFont('', 'U', 12);
                $this->Cell(0, 6, 'Printed On: ' . date('D, d/m/Y'), 0, 0, 'R');
                $this->Ln();
                $this->Cell(0, 0, '', 1, 1, 'R');
                $this->Ln();
            }
            public function body()
            {
                $sno = 1;
                $invoiceKey = INVOICEKEY;
                $appData = new App;
                $invoice = $appData->invoiceInfo($invoiceKey);
                $this->setFont('', '', 12);
                if ($invoice) {
                    $appData = new App;
                    $invCalc = invCalc($invoice);
                    $invSchInfo = $appData->appInfo($invoice['sch_token']);
                    // release data
                    $cellWidth = (175 / 3);
                    $this->setFont('', '', 13);
                    $this->SetTextColor(275, 0, 0);
                    $this->Cell($cellWidth, 8, 'INVOICE TO', 0, 0, 'L');
                    $this->Cell($cellWidth, 8, '', 0, 0, 'C');
                    $this->SetTextColor(275, 0, 0);
                    $this->Cell($cellWidth, 8, 'PAYMENT METHOD', 0, 0, 'L');
                    $this->Ln();
                    $this->setFont('', '', 12);
                    $this->SetTextColor(0, 0, 0);
                    $this->Cell($cellWidth, 6, ucwords($invSchInfo->sch_name), 0, 0, 'L');
                    $this->Cell($cellWidth, 6, '', 0, 0, 'L');
                    $this->Cell($cellWidth, 6, PAYMENT_METHOD['method'], 0, 0, 'L');
                    $this->Ln();
                    $this->Cell($cellWidth, 6, "ATTN: " . ucwords($invSchInfo->principal['name']), 0, 0, 'L');
                    $this->Cell($cellWidth, 6, '', 0, 0, 'L');
                    $this->Cell($cellWidth, 6, PAYMENT_METHOD['account'], 0, 0, 'L');
                    $this->Ln();
                    $this->Cell($cellWidth, 6, "P.o Box: " . ucwords(strtolower($invSchInfo->sch_address . " - " . $invSchInfo->sch_postcode)), 0, 0, 'L');
                    $this->Cell($cellWidth, 6, '', 0, 0, 'L');
                    $this->Cell($cellWidth, 6, PAYMENT_METHOD['accname'], 0, 0, 'L');
                    $this->Ln();
                    $this->Cell($cellWidth, 6, ucwords(strtolower($invSchInfo->sch_town)), 0, 0, 'L');
                    $this->Cell($cellWidth, 6, '', 0, 0, 'L');
                    $this->Cell($cellWidth, 6, 'Due Date: ' . date('D, d/m/Y', strtotime($invoice['inv_exp'])), 0, 0, 'L');
                    $this->Ln();
                    $this->Cell($cellWidth, 6, "Tell: " . smartPhone($invSchInfo->sch_phone), 0, 0, 'L');
                    $this->Cell($cellWidth, 6, '', 0, 0, 'L');
                    $this->Cell($cellWidth, 6, '', 0, 0, 'L');
                    $this->Ln(10);
                    // print items
                    // Items heading
                    $this->setFont('Arial', 'B', 12);
                    $this->SetTextColor(255, 255, 255);
                    $this->SetFillColor(255, 0, 0);
                    $this->MultiCell(190, 6, strtoupper($invoice['inv_type']), 1, 'L', true);
                    $this->Ln(1);
                    $this->Cell(15, 7, '#', 1, 0, 'L', true);
                    $this->Cell(125, 7, 'Description', 1, 0, 'L', true);
                    $this->Cell(50, 7, 'Amount ( Ksh )', 1, 0, 'R', true);
                    $this->Ln();
                    $this->SetTextColor(0, 0, 0);
                    $this->setFont('', '', 12);
                    // Invoice items
                    foreach ($invoice['invItems'] as $singleInvItem) {
                        $this->Cell(15, 7, $sno++, 1, 0, 'L');
                        $this->Cell(125, 7, ucwords($singleInvItem['inv_item']), 1, 0, 'L');
                        $this->Cell(50, 7, number_format($singleInvItem['inv_item_amnt'], 2), 1, 0, 'R');
                        $this->Ln();
                    }
                    $this->setFont('', 'B', 12);
                    // Totals
                    $this->Cell(140, 7, 'Sub Totals:', 1, 0, 'R');
                    $this->Cell(50, 7, number_format($invCalc['invBilled'], 2), 1, 0, 'R');
                    $this->Ln();
                    $this->Cell(140, 7, 'VAT( 16% ):', 1, 0, 'R');
                    $this->Cell(50, 7, number_format($invCalc['invVAT'], 2), 1, 0, 'R');
                    $this->Ln();
                    $this->Cell(140, 7, 'Grand Totals:', 1, 0, 'R');
                    $this->Cell(50, 7, number_format($invCalc['invGrantTotal'], 2), 1, 0, 'R');
                    $this->Ln();
                    $this->Cell(140, 7, 'Total Paid:', 1, 0, 'R');
                    $this->Cell(50, 7, number_format($invCalc['invPaid'], 2), 1, 0, 'R');
                    $this->Ln();
                    $this->Cell(140, 7, 'Total Balance:', 1, 0, 'R');
                    $this->Cell(50, 7, number_format($invCalc['invBalance'], 2), 1, 0, 'R');
                    $this->Ln(20);
                    // end totals
                    // start remarks
                    $this->setFont('', '', 12);
                    $this->Cell(190, 6, 'Thankyou for doing business with us.', 0, 0, 'L');
                    $this->Ln();
                    $this->Cell(190, 6, 'Invoice Generated on ' . date('D, d/m/Y h:i:m A'), 0, 0, 'L');
                    // end remarks
                } else {
                    $this->Cell(0, 6, "No invoice data found relating to your search key!", 1, 0, 'C');
                }
            }
            public function footer()
            {
                $this->SetY(-25);
                $this->setFont('Times', '', 9);
                $this->MultiCell(190, 6, "Disclaimer: This is a system generated invoice hence a copryright of the information saved in our Databases.", 1, "C");
                $this->Ln(2);
                $this->setFont('Times', 'I', 11);
                $this->Cell(0, 0, '', 1, 1, 'L');
                $this->SetTextColor(255, 0, 0);
                $this->Cell(0, 10, 'Copyright ' . BILLING_ADDRESS['cname'], 0, 0, 'L');
                $this->cell(0, 10, $this->PageNo() . ' Out of {nb}', 0, 0, 'R');
            }
        }
        /**
         * ===============================================================================================
         * ==================INVOICE END==============================================================
         */
        break;
    case "staff":
        /**
         * =================================================================================================
         * ==================STAFF START==============================================================
         */
        class pdf extends FPDF
        {
            public function docSettings()
            {
                return ["docOrient" => "P", "docName" => ucwords(smartKey("staff data")), "docViewType" => VIEWTYPE];
            }
            public function header()
            {
                $this->setFont('Times', 'UB', 16);
                $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetDrawColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->Image(pdfimageCheck("logos", APPINFO->sch_logo, "default.png"), 10, 10, 20);
                $this->Cell(0, 6, strtoupper(APPINFO->sch_name), 0, 0, 'C');
                $this->Ln();
                $this->setFont('', '', 12);
                $this->Cell(0, 6, strtoupper('P.O BOX ' . APPINFO->sch_address . ' - ' . APPINFO->sch_postcode . " " . APPINFO->sch_town . " - " . APPINFO->sch_city), 0, 0, 'C');
                $this->Ln();
                $this->SetTextColor(0, 0, 0);
                $this->cell(0, 6, 'Email: ' . APPINFO->sch_email . " | Tel: " . smartPhone(APPINFO->sch_phone), 0, 0, 'C');
                $this->Ln();
                $this->SetFont('', 'UB', 12);
                $this->cell(0, 6, strtoupper("school staff members"), 0, 0, 'C');
                $this->SetFont('', 'I', 10);
                $this->Cell(0, 6, 'Date: ' . date('D, d/m/Y.'), 0, 0, 'R');
                $this->Ln(8);
                $this->Line(200, 35, 10, 35);
                $this->SetFont('', 'B', 10);
                $this->SetDrawColor(0, 0, 0);
                $this->Cell(10, 6, 'S/N', 1, 0, 'C');
                $this->Cell(15, 6, 'PHOTO', 1, 0, 'L');
                $this->Cell(50, 6, 'FULL NAME', 1, 0, 'L');
                $this->Cell(25, 6, 'USERNAME', 1, 0, 'L');
                $this->Cell(20, 6, 'STAFF NO.', 1, 0, 'L');
                $this->Cell(25, 6, 'CONTACT', 1, 0, 'L');
                $this->Cell(25, 6, 'ROLE', 1, 0, 'L');
                $this->Cell(20, 6, 'REMARKS', 1, 0, 'L');
                $this->Ln();
                $this->SetFont('', '', 10);
            }
            public function body()
            {
                $appData = new App;
                $sno = 1;
                $allStaff = $appData->sch_staff();
                if ($allStaff) {
                    // print data
                    $photo = 11;
                    $sno2 = 0;
                    foreach ($allStaff as $staff) {
                        $this->Cell(10, 11, $sno++ . ")", 1, 0, 'C');
                        $this->Cell(15, 11, "", 1, 0, 'L');
                        $this->Image(pdfimageCheck("profiles", $staff->user_pass, "avatar.png"), 23, 43 + ($photo * $sno2++), 8);
                        $this->Cell(50, 11, ucwords($staff->user_salutation . ". " . $staff->user_lname . " " . $staff->user_fname), 1, 0, 'L');
                        $this->Cell(25, 11, $staff->user_name, 1, 0, 'L');
                        $this->Cell(20, 11, $staff->user_snumber, 1, 0, 'L');
                        $this->Cell(25, 11, smartPhone($staff->user_phone), 1, 0, 'L');
                        $this->Cell(25, 11, ucwords(userRole($staff->user_role)), 1, 0, 'L');
                        $this->Cell(20, 11, "", 1, 0, 'L');
                        $this->Ln();
                    }
                } else {
                    $this->multiCell(0, 5, 'No staff records found matching your search type', 1, "C");
                }
                $this->Ln(10);
                $this->multiCell(0, 5, 'Disclaimer: All the information printed here is in accordance with the information saved into our databases as provided by the school.');
            }
            function footer()
            {
                $this->SetY(-20);
                $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetDrawColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->Line(200, 277, 10, 277);
                $this->Cell(0, 10, ucwords(APPINFO->sch_name), 0, 0, 'L');
                $this->cell(0, 10, $this->PageNo() . ' Out of {nb}', 0, 0, 'R');
            }
        }
        /**
         * ===============================================================================================
         * ==================STAFF END==============================================================
         */
        break;
    case "student":
        /**
         * =================================================================================================
         * ==================STUDENTS START==============================================================
         */
        class pdf extends FPDF
        {
            public function docSettings()
            {
                return ["docOrient" => "P", "docName" => ucwords(smartKey("form  " . PRINTTYPE . " students list")), "docViewType" => VIEWTYPE, "class" => PRINTTYPE, "title" => TITLE];
            }
            public function header()
            {
                $this->setFont('Times', 'UB', 16);
                $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetDrawColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->Image(pdfimageCheck("logos", APPINFO->sch_logo, "default.png"), 10, 10, 20);
                $this->Cell(0, 6, strtoupper(APPINFO->sch_name), 0, 0, 'C');
                $this->Ln();
                $this->setFont('', '', 12);
                $this->Cell(0, 6, strtoupper('P.O BOX ' . APPINFO->sch_address . ' - ' . APPINFO->sch_postcode . " " . APPINFO->sch_town . " - " . APPINFO->sch_city), 0, 0, 'C');
                $this->Ln();
                $this->SetTextColor(0, 0, 0);
                $this->cell(0, 6, 'Email: ' . APPINFO->sch_email . " | Tel: " . smartPhone(APPINFO->sch_phone), 0, 0, 'C');
                $this->Ln();
                $this->SetFont('', 'UB', 12);
                $this->cell(0, 6, strtoupper($this->docSettings()['title']), 0, 0, 'C');
                $this->SetFont('', 'I', 10);
                $this->Cell(0, 6, 'Date: ' . date('D, d/m/Y.'), 0, 0, 'R');
                $this->Ln(8);
                $this->Line(200, 35, 10, 35);
                $this->SetFont('', 'B', 10);
                $this->SetDrawColor(0, 0, 0);
                $this->Cell(10, 6, 'S/NO', 1, 0, 'C');
                $this->Cell(15, 6, 'ADM', 1, 0, 'L');
                $this->Cell(50, 6, 'FULL NAME', 1, 0, 'L');
                $this->Cell(15, 6, 'CLASS', 1, 0, 'L');
                if (VIEWFOLDER == "finance") {
                    $this->Cell(20, 6, 'BILLED', 1, 0, 'L');
                    $this->Cell(20, 6, 'PAID', 1, 0, 'L');
                    $this->Cell(20, 6, 'BALANCE', 1, 0, 'L');
                    $this->Cell(25, 6, 'CONTACT', 1, 0, 'L');
                    $this->Cell(15, 6, 'REM', 1, 0, 'L');
                } else {
                    $this->Cell(15, 6, 'KCPE', 1, 0, 'L');
                    $this->Cell(25, 6, 'CONTACT', 1, 0, 'L');
                    $this->Cell(30, 6, 'REMARKS', 1, 0, 'L');
                    $this->Cell(30, 6, 'REMARKS', 1, 0, 'L');
                }
                $this->Ln();
                $this->SetFont('', '', 10);
            }
            public function body()
            {
                $appData = new App;
                $sno = 1;
                $class = $this->docSettings()['class'];
                $allStudents = $appData->sch_students();
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
                            $this->Cell(10, 6, $sno++ . ")", 1, 0, 'C');
                            $this->Cell(15, 6, ucwords($stud->stud_adm), 1, 0, 'L');
                            $this->Cell(50, 6, ucwords($stud->stud_lname . " " . $stud->stud_fname . " " . $stud->stud_oname), 1, 0, 'L');
                            $this->Cell(15, 6, ucwords($stud->stud_form . " " . $stud->stud_stream), 1, 0, 'L');
                            if (VIEWFOLDER == "finance") {
                                $this->Cell(20, 6, number_format($finSum['ttBilled'], 2), 1, 0, 'R');
                                $this->SetTextColor(0, 255, 0);
                                $this->Cell(20, 6, number_format($finSum['ttPaid'], 2), 1, 0, 'R');
                                $this->SetTextColor(255, 0, 0);
                                $this->Cell(20, 6, number_format($finSum['ttBalance'], 2), 1, 0, 'R');
                                $this->SetTextColor(0, 0, 0);
                                $this->Cell(25, 6, smartPhone($stud->stud_phone), 1, 0, 'L');
                                $this->Cell(15, 6, "", 1, 0, 'R');
                            } else {
                                $this->Cell(15, 6, ucwords($kcpeMarks), 1, 0, 'L');
                                $this->Cell(25, 6, smartPhone($stud->stud_phone), 1, 0, 'L');
                                $this->Cell(30, 6, "", 1, 0, 'R');
                                $this->Cell(30, 6, "", 1, 0, 'R');
                            }
                            $this->Ln();
                        }
                    } else {
                        $this->multiCell(0, 5, 'No students records found matching your search type', 1, "C");
                    }
                } else {
                    $this->multiCell(0, 5, 'No students records found matching your search type', 1, "C");
                }
                $this->Ln(10);
                $this->multiCell(0, 5, 'Disclaimer: All the information printed here is in accordance with the information saved into our databases as provided by the school.');
            }
            function footer()
            {
                $this->SetY(-20);
                $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetDrawColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->Line(200, 277, 10, 277);
                $this->Cell(0, 10, ucwords(APPINFO->sch_name), 0, 0, 'L');
                $this->cell(0, 10, $this->PageNo() . ' Out of {nb}', 0, 0, 'R');
            }
        }
        /**
         * ===============================================================================================
         * ==================STUDENTS END==============================================================
         */
        break;
    default:
        /**
         * =================================================================================================
         * ==================LETTER HEAD START==============================================================
         */
        class pdf extends FPDF
        {
            public function docSettings()
            {
                return ["docOrient" => "P", "docName" => ucwords(smartKey(APPINFO->sch_name . " letter head")), "docViewType" => VIEWTYPE];
            }
            public function header()
            {
                $this->setFont('Times', 'UB', 16);
                $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetDrawColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->Image(pdfimageCheck("logos", APPINFO->sch_logo, "default.png"), 10, 10, 20);
                $this->Cell(0, 6, strtoupper(APPINFO->sch_name), 0, 0, 'C');
                $this->Ln();
                $this->setFont('', 'B', 12);
                $this->Cell(0, 6, strtoupper('P.O BOX ' . APPINFO->sch_address . ' - ' . APPINFO->sch_postcode . " " . APPINFO->sch_town . " - " . APPINFO->sch_city), 0, 0, 'C');
                $this->Ln();
                $this->SetTextColor(0, 0, 0);
                $this->setFont('', '', 12);
                $this->cell(0, 6, 'Email: ' . APPINFO->sch_email . " | Tel: " . smartPhone(APPINFO->sch_phone), 0, 0, 'C');
                $this->Ln();
                $this->cell(0, 6, 'Our Ref:..........................................................', 0, 0, 'L');
                $this->cell(0, 6, 'Date:........................................................', 0, 0, 'R');
                $this->Ln();
                $this->cell(0, 6, 'Your Ref:........................................................', 0, 0, 'L');
                $this->Ln();
                $this->SetDrawColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->Cell(0, 0, '', 1, 1, 'L');
            }
            public function body() {}
            public function footer()
            {
                $this->SetY(-20);
                $this->setFont('Times', 'B', 12);
                $this->SetTextColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->SetDrawColor(RGBA[0], RGBA[1], RGBA[2]);
                $this->Cell(0, 0, '', 1, 1, 'L');
                $this->Cell(0, 10, ucwords(APPINFO->sch_name), 0, 0, 'L');
                $this->cell(0, 10, '', 0, 0, 'R');
            }
        }
        /**
         * ===============================================================================================
         * ==================LETTER HEAD END==============================================================
         */
        break;
}

/**
 * =================================================================================================
 * ==================REQUIRED PDF HEADERS ==========================================================
 */
$pdf = new pdf();
$pdf->AliasNbPages();
$pdf->AddPage($pdf->docSettings()['docOrient'], 'A4', 0);
$pdf->body();
$pdf->Output($pdf->docSettings()['docName'] . ".pdf", $pdf->docSettings()['docViewType']);
