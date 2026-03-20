<?php

/**
 * Finance controller
 */

class Finance
{
    use Controller;
    private $view = "index";

    public function index()
    {
        $data = [];
        $this->view('Finance', $data, __FUNCTION__);
    }

    public function create()
    {
        $data = [];
        $this->view('Finance', $data, __FUNCTION__);
    }

    public function postFees()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $appData = new App;
            $schToken = $appData->schoolToken;
            $allStudents = $appData->sch_students();
            $financeModel = new FinanceModel;
            if ($financeModel->validate($_POST)) {
                if ($allStudents) {
                    $finStuds = [];
                    foreach ($allStudents as $student) {
                        if (($_POST['class'] == "all") && ($_POST['category'] == "all")) {
                            // echo "all classes and all categories";
                            $finStuds[$student->stud_key] = $student;
                        } else if (!($_POST['class'] == "all") && ($_POST['category'] == "all")) {
                            // echo "all categories only";
                            if ($student->stud_form == $_POST['class']) {
                                $finStuds[$student->stud_key] = $student;
                            }
                        } else if (($_POST['class'] == "all") && !($_POST['category'] == "all")) {
                            // echo "all classes only";
                            if ($student->stud_cat == $_POST['category']) {
                                $finStuds[$student->stud_key] = $student;
                            }
                        } else {
                            // echo "specific class for specific category";
                            if (($student->stud_form == $_POST['class']) && ($student->stud_cat == $_POST['category'])) {
                                $finStuds[$student->stud_key] = $student;
                            }
                        }
                    }

                    if (count($finStuds) > 0) {
                        $successCount = 0;
                        $failCount = 0;
                        // post array
                        foreach ($finStuds as $key => $studPost) {
                            // FORMAT: 1) School 2) Student Key 3) Term key 4) Type
                            $fi_key = strtoupper(smartKey($schToken . "_" . $key . "_" . $_POST['term'] . "_post"));
                            if ($financeModel->where(["sch_token" => $schToken, "fi_key" => $fi_key])) { // record exists
                                if (!($financeModel->update($fi_key, ["fi_cat" => $student->stud_cat, "fi_type" => "post", "fi_studK" => $key, "fi_studF" => $student->stud_form, "fi_studS" => $student->stud_stream, "fi_termK" => $_POST['term'], "fi_amnt" => $_POST['amount'], "fi_upby" => CURRENTUSER], "fi_key"))) { // success
                                    $successCount += 1;
                                } else {
                                    $failCount += 1;
                                }
                            } else { // record does not exist
                                if (!($financeModel->insert(["sch_token" => $schToken, "fi_key" => $fi_key, "fi_cat" => $student->stud_cat, "fi_type" => "post", "fi_studK" => $key, "fi_studF" => $student->stud_form, "fi_studS" => $student->stud_stream, "fi_termK" => $_POST['term'], "fi_desc" => "standard invoice", "fi_amnt" => $_POST['amount'], "fi_by" => CURRENTUSER]))) { // success
                                    $successCount += 1;
                                } else {
                                    $failCount += 1;
                                }
                            }
                        }
                        // post report
                        $financeModel->errors[] = $successCount . " - fees records posted successfully! " . $failCount . " - Failed!";
                    } else {
                        $financeModel->errors[] = "There is no student matching your post request!";
                    }
                } else {
                    $financeModel->errors[] = "There is no student matching your post request!";
                }
            }
            // print report
            echo implode("<br>", $financeModel->errors);
        }
    }
}
