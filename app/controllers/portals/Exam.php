<?php

/**
 * Exam controller
 */

class Exam
{
    use Controller;

    public function index()
    {
        $data = [];
        $this->view('Exam', $data, __FUNCTION__);
    }

    public function create()
    {
        $data = [];
        $appData = new App;
        $schToken = $appData->schoolToken;
        $schATerm = $appData->activeTerm();
        $schAExam = $appData->activeExam();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $ResultModel = new ResultModel;
            $termKey = $schATerm->term_key;
            $examKey = $schAExam->exam_key;
            $examOutof = $_POST['examOutOf'];
            $allStudents = $appData->sch_students();
            if ($ResultModel->validate($_POST)) {
                if ($allStudents) {
                    if ($_POST['examForm'] == "all") {
                        $studsRegData = $allStudents;
                        $subTitle = "all classes";
                    } else {
                        foreach ($allStudents as $key => $value) {
                            if ($value->stud_form == $_POST['examForm']) {
                                $studsRegData[] = $value;
                            }
                        }
                        $subTitle = "form " . $_POST['examForm'];
                    }
                    if (isset($studsRegData)) {
                        $success = 0;
                        $failed = 0;
                        foreach ($studsRegData as $key => $student) {
                            if (!($student->stud_form == "alumni")) {
                                $studK = $student->stud_key;
                                $studF = $student->stud_form;
                                $studS = $student->stud_stream;
                                $studC = count($appData->studentInfo($studK)['subjects']["active"]);
                                $re_key = resultsRecKey($schToken, $studK, $termKey, $examKey);
                                if (!($ResultModel->fetch(["re_key" => $re_key]))) {
                                    if (!($ResultModel->insert(["sch_token" => $schToken, "re_key" => $re_key, "re_term" => $termKey, "re_exam" => $examKey, "re_studK" => $studK, "re_studF" => $studF, "re_studS" => $studS, "re_subC" => $studC, "re_OutOf" => $examOutof, "addby" => CURRENTUSER]))) {
                                        $success += 1;
                                    } else {
                                        $failed += 1;
                                    }
                                } else {
                                    if (!($ResultModel->update($re_key, ["re_studF" => $studF, "re_studS" => $studS, "re_subC" => $studC, "re_OutOf" => $examOutof, "upby" => CURRENTUSER], "re_key"))) {
                                        $success += 1;
                                    } else {
                                        $failed += 1;
                                    }
                                }
                            }
                        }
                        create_log("Created marks entry list for " . strtoupper($subTitle) . " out of " . $examOutof . " with " . $success . " - successfully added, " . $failed . " - failed");
                        echo "Created marks entry list for " . strtoupper($subTitle) . " out of " . $examOutof . " with " . $success . " - successfully added, " . $failed . " - failed";
                    } else {
                        echo "There is no student for the selected marks entry category!";
                    }
                } else {
                    echo "There is no student for the selected marks entry category!";
                }
            }
        } else {
            if ($schATerm) {
                if ($schAExam) {
                    $allStudents = $appData->sch_students();
                    $data['heading'] = "create marks entry list for <b class='text-uppercase'>" . $schAExam->exam . " exam - term " . $schATerm->term . " " . date('Y', strtotime($schATerm->date)) . "</b>";
                } else {
                    $data['examRegError'] = "There is no active Exam to add students exam records for, kindly register a new exam to continue!";
                }
            } else {
                $data['examRegError'] = "There is no active term to register exams for, kindly register the current term in order to continiue!";
            }
            $this->view('Exam', $data, __FUNCTION__);
        }
    }

    public function entry()
    {
        $data = [];
        $appData = new App;
        $schATerm = $appData->activeTerm();
        $schAExam = $appData->activeExam();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $studResultsData = [];
            $allStudents = $appData->sch_students();
            if ($allStudents) {
                foreach ($allStudents as $studKey => $studValue) {
                    if (empty($_POST['re_studS'])) {
                        if ($studValue->stud_form == $_POST['re_studF']) {
                            $studResultsData[] = $studValue;
                        }
                    } else {
                        if (($studValue->stud_form == $_POST['re_studF']) && ($studValue->stud_stream == $_POST['re_studS'])) {
                            $studResultsData[] = $studValue;
                        }
                    }
                }
                if (count($studResultsData) > 0) {
                    $subStudCount = 0;
                    $finalListArray = [];
                    foreach ($studResultsData as $student) {
                        $studSub = $appData->studentInfo($student->stud_key)['subjects']['active'];
                        if (in_array($_POST['subject'], array_column($studSub, "sub_code"))) {
                            $finalListArray[] = $student;
                            $subStudCount += 1;
                        }
                    }
                    if ($subStudCount > 0) {
                        $_SESSION['MARKS_ENTRY_DATA'] = ["class" => $_POST['re_studF'], "stream" => $_POST['re_studS'], "subject" => $_POST['subject'], "students" => $finalListArray];
                        echo "Students marks entry list created successfully!";
                    } else {
                        echo "There is no students found for the requested class to enter marks for";
                    }
                } else {
                    echo "There is no students found for the requested class to enter marks for";
                }
            } else {
                echo "There is no students found for the requested class to enter marks for";
            }
        } else {
            if ($schATerm) {
                if ($schAExam) {
                } else {
                    $data['examRegError'] = "There is no active Exam to enter marks for, kindly register a new exam to continue!";
                }
            } else {
                $data['examRegError'] = "There is no active term to to enter marks for, kindly register the current term in order to continiue!";
            }
            $this->view('Exam', $data, __FUNCTION__);
        }
    }

    public function marks_entry()
    {
        $data = [];
        $appData = new App;
        $ResultModel = new ResultModel;
        $schToken = $appData->schoolToken;
        $schATerm = $appData->activeTerm();
        $schAExam = $appData->activeExam();
        if ($_SERVER["REQUEST_METHOD"] == "POST") { // Save marks
            $success = 0;
            $failed = 0;
            $re_subject = "re_s" . $_SESSION['MARKS_ENTRY_DATA']['subject'];
            foreach ($_POST['re_key'] as $key => $re_key) {
                $score = $_POST['score'][$key];
                if ($score > 0) { // work on those with at least 1 score entry
                    $initalRecord = $ResultModel->fetch(["re_key" => $re_key]); // Initial records
                    $re_subC = $initalRecord->re_subC;
                    $re_OutOf = $initalRecord->re_OutOf;
                    $per_score = round(($score / $re_OutOf) * 100);
                    // update subject score
                    if (!($ResultModel->update($re_key, [$re_subject => $per_score], "re_key"))) {
                        $updatedRecord = $ResultModel->fetch(["re_key" => $re_key]); // updated record
                        $studSubjects = $appData->studentInfo($updatedRecord->re_studK);
                        $finalSubjects = [];
                        // ANALYSIS OPERATIONS =========================================================================================================================================================================================================
                        if ((APPINFO->sch_sum_type == "all") || ($re_subC <= 7) || ($re_subC >= 10)) {
                            foreach ($studSubjects['subjects']['active'] as $reSubJects) {
                                $finalSubjects[] = ["subject" => $reSubJects->sub_code, "marks" => $updatedRecord->{"re_s" . $reSubJects->sub_code}];;
                            }
                        } else {
                            // subject 1 [121 - Mathematics]
                            $mathsData = [["subject" => 121, "marks" => $updatedRecord->{"re_s" . 121}]];
                            // subject 2 [The best performed langauge i.e 101 - English, 102 - Kiswahili and 504 - Kenya sign language]
                            $languageArray = [["subject" => "101", "marks" => $updatedRecord->{"re_s101"}], ["subject" => "102", "marks" => $updatedRecord->{"re_s102"}], ["subject" => "102", "marks" => $updatedRecord->{"re_s504"}]];
                            $languageData = multArrayOrder($languageArray, "marks", 1, SORT_DESC);
                            // All subjects excluding [121 - Mathematics and the Best language chosen at subject 2]
                            $otherFiveArray = [];
                            foreach ($studSubjects['subjects']['active'] as $reSubJects) {
                                if (!(in_array($reSubJects->sub_code, ["121", $languageData[0]['subject']]))) {
                                    $otherFiveArray[] = ["subject" => $reSubJects->sub_code, "marks" => $updatedRecord->{"re_s" . $reSubJects->sub_code}];
                                }
                            }
                            $otherFiveReport = multArrayOrder($otherFiveArray, "marks", 5, SORT_DESC);
                            $finalSubjects = array_merge($mathsData, $languageData, $otherFiveReport);
                        }
                        // =============================================================================================================================================================================================================================
                        // sub final arithmetics
                        $studSubCount = 0;
                        $finalTTMarks = 0;
                        $finalTTPoints = 0;
                        foreach ($finalSubjects as $subKey => $subValue) {
                            $studSubCount += 1;
                            $resSubInfo = $appData->get_sub_data($subValue['subject'], $subValue['marks']);
                            if (is_numeric($resSubInfo['points'])) {
                                $finalTTMarks += $resSubInfo['marks'];
                                $finalTTPoints += $resSubInfo['points'];
                            }
                        }
                        // final arithmetics
                        $newAvMarks = $finalTTMarks / $studSubCount;
                        $newAvPoints = $finalTTPoints / $studSubCount;
                        $newStdGrade = ($appData->res_final($newAvPoints)) ? $appData->res_final($newAvPoints)['grade'] : "";
                        // final update of results data table
                        if (!($ResultModel->update($re_key, ["re_tt" => $finalTTMarks, "re_mean" => $newAvMarks, "re_pnt" => $finalTTPoints, "re_avgpnt" => $newAvPoints, "re_grade" => $newStdGrade, "re_status" => "0"], "re_key"))) {
                            $success += 1;
                        } else {
                            $failed += 1;
                        }
                    }
                }
            }
            // response
            echo "[" . $success . "] results scores captured and saved successfully, [" . $failed . "] - failed";
        } else { // Get entry data
            if ($schATerm) {
                if ($schAExam) {
                    if (isset($_SESSION['MARKS_ENTRY_DATA'])) {
                        $subject = $appData->subInfo($_SESSION['MARKS_ENTRY_DATA']['subject']);
                        $data["heading"] = "form <b>" . $_SESSION['MARKS_ENTRY_DATA']['class'] . " " . $_SESSION['MARKS_ENTRY_DATA']['stream'] . " " . $subject->sub_name . "</b> marks entry list [ <b>" . count($_SESSION['MARKS_ENTRY_DATA']['students']) . "</b> records found ]";
                        foreach ($_SESSION['MARKS_ENTRY_DATA']['students'] as $key => $value) {
                            $re_key = resultsRecKey($schToken, $value->stud_key, $schATerm->term_key, $schAExam->exam_key);
                            $resRecord = $ResultModel->fetch(["re_key" => $re_key]);
                            if ($resRecord) {
                                $percentMark = $resRecord->{"re_s" . $subject->sub_code};
                                $subScoreInfo = $appData->get_sub_data($subject->sub_code, $percentMark);
                                $data["entryData"][$re_key] = [
                                    "re_key" => $re_key, "stud_key" => $value->stud_key, "stud_adm" => $value->stud_adm,
                                    "stud_name" => "<b>" . strtoupper($value->stud_lname) . "</b> " . $value->stud_fname . " " . $value->stud_oname,
                                    "sub_score" => round((($percentMark * $resRecord->re_OutOf) / 100)), "sub_max_score" => $resRecord->re_OutOf, "sub_percent" => $percentMark,
                                    "sub_grade" => $subScoreInfo['grade'], "sub_points" => $subScoreInfo['points'], "sub_remarks" => $subScoreInfo['rem'], "sub_teacher" => ""
                                ];
                            }
                        }
                        // order list by admission number
                        if (isset($data["entryData"])) {
                            $sortColumn = array_column($data["entryData"], "stud_adm");
                            array_multisort($sortColumn, SORT_ASC, $data["entryData"]);
                        } else {
                            $data['marksEntryError'] = "No exams records available for marks entry for the selected students category!";
                        }
                    } else {
                        $data['marksEntryError'] = "You have not selected any class for marks entry, Kindly go to <a href='" . ROOT . VIEWFOLDER . "/exam/entry'><u>Marks Entry request form</u></a> and initiate marks entry list request!";
                    }
                } else {
                    $data['marksEntryError'] = "There is no active Exam to enter marks for, kindly register a new exam to continue!";
                }
            } else {
                $data['marksEntryError'] = "There is no active term to to enter marks for, kindly register the current term in order to continiue!";
            }
            $this->view('Exam', $data, __FUNCTION__);
        }
    }
}
