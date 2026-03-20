<?php

/**
 * Result controller
 */

class Result
{
    use Controller;

    public function index($acYear = CURRENTYEAR)
    {
        $data = [];
        $appData = new App;
        $schToken = $appData->schoolToken;
        $data['acYear'] = $acYear;
        $allTerms = $appData->sch_term();
        if ($allTerms) {
            $acYearTerms = [];
            foreach ($allTerms as $key => $value) {
                if (date("Y", strtotime($value->date)) == $acYear) {
                    $acYearTerms[] = $value;
                }
            }
            if (count($acYearTerms) > 0) {
                $examData = [];
                $ResultModel = new ResultModel;
                $allExams = $appData->sch_exam();
                foreach ($acYearTerms as $termKey => $termValue) {
                    foreach ($allExams as $examKey => $examValue) {
                        if ($examValue->exam_term == $termValue->term_key) {
                            for ($i = 1; $i <= APPINFO->sch_cl_num; $i++) {
                                $resData = $ResultModel->where(["sch_token" => $schToken, "re_exam" => $examValue->exam_key, "re_studF" => $i]);
                                if ($resData) {
                                    $approved = 0;
                                    $pending = 0;
                                    foreach ($resData as $res) {
                                        if ($res->re_status > 0) {
                                            $approved += 1;
                                        } else {
                                            $pending += 1;
                                        }
                                    }
                                    $examData['termExams'][$examValue->exam_key][$i] = ["res_count" => count($resData), "res_approved" => $approved, "res_pending" => $pending];
                                } else {
                                    $examData['termExams'][$examValue->exam_key][$i] = ["res_count" => 0, "res_approved" => 0, "res_pending" => 0];
                                }
                            }
                        }
                    }
                    // term data array
                    $data['termData'][$termValue->term] = array_merge((array) $termValue, $examData);
                }
            } else {
                $data['examsError'] = "No exams registered yet for the academic year " . $acYear . "!";
            }
        } else {
            $data['examsError'] = "No exams registered yet for the academic year " . $acYear . "!";
        }

        // APPROVE RESULTS
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $ResultModel = new ResultModel;
            $rawRecords = $ResultModel->where(["re_exam" => $_POST['examKey'], "re_studF" => $_POST['approve']]);
            if ($rawRecords) {
                $success = 0;
                $failed = 0;
                foreach ($rawRecords as $key => $value) {
                    $resToApp[$value->re_key] = ["re_key" => $value->re_key, "re_studF" => $value->re_studF, "re_studS" => $value->re_studS, "re_tt" => $value->re_tt, "re_pnt" => $value->re_pnt, "re_sRank" => $value->re_sRank, "re_fRank" => $value->re_fRank, "re_status" => $value->re_status];
                }
                // group by stream
                $groupedStreams = groupBy($resToApp, "re_studS");
                // Stream rank
                foreach ($groupedStreams as $streamKey => $streamValue) {
                    $streamRankedData = studRank($streamValue, APPINFO->sch_rank_by, APPINFO->sch_rank_by_2);
                    foreach ($streamRankedData as $key => $value) {
                        $ResultModel->update($value['re_key'], ["re_sRank" => $value['rank']], "re_key");
                    }
                }
                // Form rank
                $rankedFormData = studRank($resToApp, APPINFO->sch_rank_by, APPINFO->sch_rank_by_2);
                foreach ($rankedFormData as $key => $value) {
                    if (!($ResultModel->update($value['re_key'], ["re_fRank" => $value['rank'], "re_status" => 1], "re_key"))) {
                        $success += 1;
                    } else {
                        $failed += 1;
                    }
                }
                create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Approved form " . $_POST['approve'] . " results with [" . $success . "] results records approved successfully, [" . $failed . "] failed approval!"));
                $_SESSION['status'] = "[" . $success . "] results records approved successfully, [" . $failed . "] failed approval!";
                $_SESSION['status_code'] = 'success';
            } else {
                $_SESSION['status'] = "No records ready to approve!";
                $_SESSION['status_code'] = 'success';
            }
        }

        $this->view('Result', $data, __FUNCTION__);
    }

    public function analyze($exam, $class = "")
    {
        $data = [];
        $appData = new App;
        $resData = $appData->results_analysis($exam, $class, "mainAnalysis");
        if (isset($resData['previousExam'])) {
            $data['dev'] = [
                "avgMarksDev" => round(($resData['currentExam']['resFAvgMark'] - $resData['previousExam']['resFAvgMark']), 4),
                "avgPointsDev" => round(($resData['currentExam']['resFAvgPnts'] - $resData['previousExam']['resFAvgPnts']), 4),
            ];
        } else {
            $data['dev'] = ["avgMarksDev" => "", "avgPointsDev" => ""];
        }
        $data = array_merge($data, $resData);
        $this->view('Result', $data, __FUNCTION__);
    }

    public function deleteInvaid()
    {
        $appData = new App;
        $allResults = $appData->sch_results();
        if ($allResults) {
            $resultModel = new ResultModel;
            $success = 0;
            $failed = 0;
            foreach ($allResults as $result) {
                if (($result->re_exam == $_POST['examKey']) && ($result->re_tt == 0)) {
                    if (!($resultModel->delete($result->id))) {
                        $success += 1;
                    } else {
                        $failed += 1;
                    }
                }
            }
            echo "successfully deleted = <b>" . $success . "</b><br>Failed delete = <b>" . $failed . "</b>";
        } else {
            echo "No results record to delete!";
        }
    }

    public function delete()
    {
        if (isset($_POST['delResRec'])) {
            $resultModel = new ResultModel;
            $success = 0;
            $failed = 0;
            foreach ($_POST['delResRec'] as $res_key) {
                if (!($resultModel->delete($res_key, "re_key"))) {
                    $success += 1;
                } else {
                    $failed += 1;
                }
            }
            echo "successfully deleted = <b>" . $success . "</b><br>Failed delete = <b>" . $failed . "</b>";
        } else {
            echo "You MUST select at least 1 results record to delete!";
        }
    }
}
