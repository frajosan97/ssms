<?php

use PhpOffice\PhpSpreadsheet\Calculation\Information\Value;

/**
 * Dashboard controller
 */

class Dashboard
{
    use Controller;

    public function index()
    {
        $data = [];
        $appData = new App;
        $data['logs'] = read_log();
        // data count
        $data['sch_staff'] = ($appData->sch_staff()) ? count(objectToArray($appData->sch_staff())) : 0;
        $data['sch_students'] = ($appData->sch_students()) ? count(objectToArray($appData->sch_students())) : 0;
        $data['sch_classes'] = ($appData->sch_classes()) ? count(objectToArray($appData->sch_classes())) : 0;
        $data['sch_exam'] = ($appData->sch_exam()) ? count(objectToArray($appData->sch_exam())) : 0;
        $data['sch_lib_res'] = ($appData->sch_lib_res()) ? count(objectToArray($appData->sch_lib_res())) : 0;
        $data['sch_downloads'] = ($appData->sch_downloads()) ? count(objectToArray($appData->sch_downloads())) : 0;
        // Data
        $allExams = objectToArray($appData->sch_exam());
        $allTerms = objectToArray($appData->sch_term());
        $activeExam = $appData->activeExam();
        $data['allTerms'] = $allTerms;
        $data['activeExam'] = $activeExam;
        // switch users
        switch (VIEWFOLDER) {
            case 'staff':
                /**
                 * ======================================================================================================
                 * ==============STAFF DASHBOARD=========================================================================
                 */
                // Analysis
                if ($data['sch_exam'] > 0) {
                    $data['recentExam'] = [];
                    sort($allExams);
                    foreach ($allExams as $exam => $examData) {
                        if ($exam == array_key_last($allExams)) {
                            $currExamKey = $examData['exam_key'];
                            $thisExamInfo = $appData->examInfo($currExamKey);
                            $data['recentExInfo'] = $thisExamInfo;
                            $data['currExamHeading'] = strtoupper($thisExamInfo->exam . " exam");
                            for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) {
                                $classExamData = $appData->results_analysis($currExamKey, $classNum, "shortResAnalysis");
                                if (!(isset($classExamData['currentExam']['notFound']))) {
                                    if (!(isset($classExamData['previousExam'])) or  isset($classExamData['previousExam']['notFound'])) {
                                        $avgMarkDev = 0;
                                        $avgPointsDev = 0;
                                    } else {
                                        $avgMarkDev = round(($classExamData['currentExam']['resFAvgMark'] - $classExamData['previousExam']['resFAvgMark']), 4);
                                        $avgPointsDev = round(($classExamData['currentExam']['resFAvgPnts'] - $classExamData['previousExam']['resFAvgPnts']), 4);
                                    }
                                    $data['recentExam'][$classNum] = array("resFCount" => $classExamData['currentExam']['resFCount'], "resFAvgMark" => $classExamData['currentExam']['resFAvgMark'], "resFAvgPnts" => $classExamData['currentExam']['resFAvgPnts'], "resFAvgGrade" => $classExamData['currentExam']['resFAvgGrade'], "resFAvgMarkDev" => $avgMarkDev, "resFAvgPntsDev" => $avgPointsDev, "resRedirectUrl" => ROOT . "staff/result/analyze/" . $currExamKey . "/" . $classNum);
                                } else {
                                    $data['recentExam'][$classNum] = array("notFound" => $classExamData['currentExam']['notFound'], "resRedirectUrl" => "javascript.void:(0)");
                                }
                            }
                        }
                    }
                } else {
                    $data['noRecentExam'] = "There is no recently analyzed exams, kindly create exams to display here!";
                }
                break;
            case 'student':
                /**
                 * ======================================================================================================
                 * ==============STUDENT DASHBOARD=========================================================================
                 */
                $data['studInfo'] = $appData->studentInfo($_SESSION[VIEWFOLDER]->stud_key);
                // sum of paid
                $paid = 0;
                foreach ($data['studInfo']['finance'] as $finance) {
                    // total bill
                    if ($finance->fi_type == "pay") {
                        $paid += $finance->fi_amnt;
                    }
                }
                $data['paidFees'] = $paid;
                break;
            case 'finance':
                /**
                 * ======================================================================================================
                 * ==============FINANCE DASHBOARD=========================================================================
                 */
                $totalBill = 0;
                $totalPaid = 0;
                $totalExpense = 0;
                $financeData = $appData->sch_finance();
                if ($financeData) {
                    foreach ($financeData as $finance) {
                        // total bill
                        if ($finance->fi_type == "post") {
                            $totalBill += $finance->fi_amnt;
                        }
                        // total paid
                        if ($finance->fi_type == "pay") {
                            // check if allocated
                            $finRecPayInfo = $appData->finRecPayVotes($finance->fi_key);
                            $allocatedFunds = 0;
                            if ($finRecPayInfo) {
                                foreach ($finRecPayInfo as $key => $value) {
                                    $allocatedFunds += $value->amount;
                                }
                            }
                            if ($allocatedFunds < $finance->fi_amnt) {
                                $data['unallocated'][] = $finance;
                            }
                            // Sum payments
                            $totalPaid += $finance->fi_amnt;
                        }
                        // total expense
                        if ($finance->fi_type == "expense") {
                            $totalExpense += $finance->fi_amnt;
                        }
                    }
                }
                // total balance
                $totalBalance = $totalPaid - $totalExpense;
                $collectionBalance = $totalBill - $totalPaid;
                // fina array
                $data['account'] = ["totalBill" => $totalBill, "totalPaid" => $totalPaid, "totalExpense" => $totalExpense, "totalBalance" => $totalBalance, "collectionBalance" => $collectionBalance];
                break;
            default:

                break;
        }
        $this->view('Dashboard', $data, __FUNCTION__);
    }
}
