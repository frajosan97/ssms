<?php

/**
 * System controller
 */

class System
{
    use Controller;

    public function index()
    {
        $data = [];
        $schToken = APPINFO->sch_token;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $school = new SchoolModel;
            foreach ($_POST as $key => $value) {
                $upData[$key] = $value;
            }
            /** save update */
            if (!($school->update($schToken, $upData, "sch_token"))) {
                create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Updated the " . strtoupper(APPINFO->sch_name) . " profile information"));
                $_SESSION['status'] = "school profile updated successfully!";
                $_SESSION['status_code'] = 'success';
            } else {
                $_SESSION['status'] = "error updating school profile!";
                $_SESSION['status_code'] = 'error';
            }
        }
        $this->view('System', $data, __FUNCTION__);
    }

    public function about()
    {
        $data = [];
        $schToken = APPINFO->sch_token;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $school = new SchoolModel;
            foreach ($_POST as $key => $value) {
                $upData[$key] = $value;
            }
            /** save update */
            if (!($school->update($schToken, $upData, "sch_token"))) {
                create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Updated the " . strtoupper(APPINFO->sch_name) . " about page information"));
                $_SESSION['status'] = "school profile updated successfully!";
                $_SESSION['status_code'] = 'success';
            } else {
                $_SESSION['status'] = "error updating school profile!";
                $_SESSION['status_code'] = 'error';
            }
        }
        $this->view('System', $data, __FUNCTION__);
    }

    public function contact()
    {
        $data = [];
        $schToken = APPINFO->sch_token;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $school = new SchoolModel;
            foreach ($_POST as $key => $value) {
                $upData[$key] = $value;
            }
            /** save update */
            if (!($school->update($schToken, $upData, "sch_token"))) {
                create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Updated the " . strtoupper(APPINFO->sch_name) . " contacts information"));
                $_SESSION['status'] = "school contacts updated successfully!";
                $_SESSION['status_code'] = 'success';
            } else {
                $_SESSION['status'] = "error updating school contacts!";
                $_SESSION['status_code'] = 'error';
            }
        }
        $this->view('System', $data, __FUNCTION__);
    }

    public function theme()
    {
        $data = [];
        $schToken = APPINFO->sch_token;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $school = new SchoolModel;
            foreach ($_POST as $key => $value) {
                $upData[$key] = $value;
            }
            /** save update */
            if (!($school->update($schToken, $upData, "sch_token"))) {
                create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Updated the " . strtoupper(APPINFO->sch_name) . " themes and colors"));
                $_SESSION['status'] = "school themes updated successfully!";
                $_SESSION['status_code'] = 'success';
            } else {
                $_SESSION['status'] = "error updating school themes!";
                $_SESSION['status_code'] = 'error';
            }
        }
        $this->view('System', $data, __FUNCTION__);
    }

    public function image()
    {
        $data = [];
        $schToken = APPINFO->sch_token;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $SchImageModel = new SchImageModel;
            if ($_FILES['image']['size'] > 0) {
                foreach (IMAGES as $key => $value) {
                    if ($_POST['imgType'] == $key) {
                        $uploadReturn = uploadSingleImg($_FILES['image'], $value[0]);
                        if (isset($uploadReturn['imgData'])) {
                            // check and remove previous image
                            $imageCheck = $SchImageModel->fetch(["sch_token" => $schToken, "img_type" => $key]);
                            if (!($imageCheck)) {
                                $imageFile = $SchImageModel->insert(array("sch_token" => $schToken, "img_type" => $key, "img_link" => $uploadReturn['imgData']['name'], "upby" => CURRENTUSER));
                                create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Added the " . strtoupper(APPINFO->sch_name) . " " . $value[0] . " successfully"));
                            } else {
                                $imageFile = $SchImageModel->update($imageCheck->id, array("img_link" => $uploadReturn['imgData']['name'], "upby" => CURRENTUSER));
                                create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Updated the " . strtoupper(APPINFO->sch_name) . " " . $value[0] . " successfully"));
                            }
                            /** check for the status */
                            if (!($imageFile)) {
                                $_SESSION['status'] = strtoupper($key) . " uploaded successfully!";
                                $_SESSION['status_code'] = 'success';
                            } else {
                                $_SESSION['status'] = "Error encountered somewhere uploading " . strtoupper($key) . " image!";
                                $_SESSION['status_code'] = 'error';
                            }
                        } else {
                            $_SESSION['status'] = implode("", $uploadReturn);
                            $_SESSION['status_code'] = 'error';
                        }
                    }
                }
            }
        }
        $this->view('System', $data, __FUNCTION__);
    }

    public function other()
    {
        $data = [];
        $schToken = APPINFO->sch_token;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $school = new SchoolModel;
            foreach ($_POST as $key => $value) {
                $upData[$key] = $value;
            }
            /** save update */
            if (!($school->update($schToken, $upData, "sch_token"))) {
                $_SESSION['status'] = "school general updated successfully!";
                $_SESSION['status_code'] = 'success';
            } else {
                $_SESSION['status'] = "error updating school general!";
                $_SESSION['status_code'] = 'error';
            }
        }
        $this->view('System', $data, __FUNCTION__);
    }

    public function subject()
    {
        $data = [];
        $appData = new App;
        $schToken = APPINFO->sch_token;
        if (!($_SERVER["REQUEST_METHOD"] == "POST")) {
            $sysSubjects = $appData->sys_subjects();
            if ($sysSubjects) {
                $data['sysSubjects'] = $sysSubjects;
            }
            $schSubjects = $appData->sch_subjects();
            if ($schSubjects) {
                $data['schSubjects'] = [];
                foreach ($schSubjects as $subject) {
                    $data['schSubjects'][] = $appData->subInfo($subject->sch_sub_code);
                }
            }
            $this->view('System', $data, __FUNCTION__);
        } else {
            $subjectsModel = new SchSubjectsModel;
            switch ($_POST['actionType']) {
                case 'addSubject':
                    // add subject
                    if ($subjectsModel->validate($_POST)) {
                        $subActionKey = explode("-", $_POST['actionKey']);
                        if (!($subjectsModel->fetch(array("sch_token" => $schToken, "sch_sub_code" => $subActionKey[0])))) {
                            if (!($subjectsModel->insert(array("sch_token" => $schToken, "sch_sub_code" => $subActionKey[0], "addby" => CURRENTUSER)))) {
                                create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Added " . ucwords($_POST['actionKey']) . " successfully!"));
                                echo strtoupper($subActionKey[1]) . " subject added successfully!";
                            } else {
                                echo "error adding subject!";
                            }
                        } else {
                            echo strtoupper($subActionKey[1]) . " subject already exists for this school!";
                        }
                    } else {
                        echo implode("", $subjectsModel->errors);
                    }
                    break;
                case 'updateSubject':
                    // update subject
                    $subActionKey = explode("-", $_POST['actionKey']);
                    if (!($subjectsModel->update($subActionKey[0], array("sch_sub_comp" => $subActionKey[1], "upby" => CURRENTUSER)))) {
                        create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Updated " . ucwords($subActionKey[2]) . " successfully!"));
                        echo "Updated " . ucwords($subActionKey[2]) . " successfully!";
                    } else {
                        echo "Error updating the subject!";
                    }
                    break;
                case 'deleteSubject':
                    // delete subject
                    $subActionKey = explode("-", $_POST['actionKey']);
                    if (!($subjectsModel->delete($subActionKey[0]))) {
                        create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, "Deleted " . ucwords($subActionKey[1]) . " successfully!"));
                        echo "Deleted " . ucwords($subActionKey[1]) . " successfully!";
                    } else {
                        echo "Error deleting the subject!";
                    }
                    break;
                default:
                    echo "No action set!";
                    break;
            }
        }
    }

    public function createTerm()
    {
        $appData = new App;
        $termModel = new TermModel;
        $schToken = $appData->schoolToken;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($termModel->validate($_POST)) {
                if (empty(CURRENTTERM)) {
                    $newTermKey = smartKey($schToken . " " . $_POST['postTime'] . " " . $_POST['term']);
                    if (!($termModel->fetch(["term_key" => $newTermKey]))) {
                        $postData['sch_token'] = $schToken;
                        $postData['term_key'] = $newTermKey;
                        foreach ($_POST as $key => $value) {
                            $postData[$key] = $value;
                        }
                        $postData['addby'] = CURRENTUSER;
                        if (!($termModel->insert($postData))) {
                            create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSERNAME, "Created new term - " . strtoupper("term " . $_POST['term'])));
                            $termModel->errors[] = strtoupper("term " . $_POST['term']) . " created successfully!";
                        } else {
                            $termModel->errors[] = "Error encountered creating the term, kindly try again!";
                        }
                    } else {
                        $termModel->errors[] = "Term already created, kindly try a different one!";
                    }
                } else {
                    $termModel->errors[] = "You cannot create a new term once there are running term(s), <br> Go to <b>Manage Term</b> to close all active term(s)";
                }
            }
            // loop errors
            echo implode("<br>", $termModel->errors);
        }
    }

    public function term()
    {
        $data = [];
        $appData = new App;
        $termModel = new TermModel;
        $allTerms = $appData->sch_term();
        if ($allTerms) {
            $data['terms'] = $allTerms;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($termModel->validate($_POST)) {
                if (!(str_contains(strtolower($_POST['term']), 'term'))) {
                    foreach ($_POST as $key => $value) {
                        $upData[$key] = $value;
                    }
                    unset($upData['term_key']);
                    // /** save update */
                    if (!($termModel->update($_POST['term_key'], $upData, "term_key"))) {
                        create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSERNAME, "Updated term - " . strtoupper("term " . $_POST['term'])));
                        $_SESSION['status'] = "term record updated successfully!";
                        $_SESSION['status_code'] = 'success';
                    } else {
                        $_SESSION['status'] = "error updating term record!";
                        $_SESSION['status_code'] = 'error';
                    }
                } else {
                    $_SESSION['status'] = "you MUST not include the term term in your term name / type";
                    $_SESSION['status_code'] = 'warning';
                }
            } else {
                $_SESSION['status'] = implode("<br>", $termModel->errors);
                $_SESSION['status_code'] = 'warning';
            }
        }
        $this->view('System', $data, __FUNCTION__);
    }

    public function deleteTerm()
    {
        $TermModel = new TermModel;
        $ResultModel = new ResultModel;
        $ExamModel = new ExamModel;
        $termKey = $_POST['termKey'];
        if (!($ResultModel->delete($termKey, "re_term"))) {
            if (!($ExamModel->delete($termKey, "exam_term"))) {
                if (!($TermModel->delete($termKey, "term_key"))) {
                    echo "Term deleted successfully!";
                } else {
                    echo "Error encountered deleting the term!";
                }
            } else {
                echo "Error encountered deleting the term!";
            }
        } else {
            echo "Error encountered deleting the term!";
        }
    }

    public function createExam()
    {
        $appData = new App;
        $examModel = new ExamModel;
        $schToken = $appData->schoolToken;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($examModel->validate($_POST)) {
                if (empty(CURRENTEXAM)) {
                    if (!(str_contains(strtolower($_POST['exam']), 'exam'))) {
                        if ($appData->sch_grading_sys()) {
                            $newExamKey = smartKey($schToken . " " . $_POST['postTime'] . " " . $_POST['exam']);
                            if (!($examModel->fetch(array("exam_key" => $newExamKey)))) {
                                $postData['sch_token'] = $schToken;
                                $postData['exam_key'] = $newExamKey;
                                foreach ($_POST as $key => $value) {
                                    $postData[$key] = $value;
                                }
                                $postData['addby'] = CURRENTUSER;
                                if (!($examModel->insert($postData))) {
                                    create_log(array(time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSERNAME, "Created new exam - " . strtoupper($_POST['exam'] . " exam")));
                                    $examModel->errors[] = strtoupper("exam " . $_POST['exam']) . " created successfully!";
                                } else {
                                    $examModel->errors[] = "Error encountered creating the exam, kindly try again!";
                                }
                            } else {
                                $examModel->errors[] = "This exam already exists in our database!";
                            }
                        } else {
                            $examModel->errors[] = "You cannot create an exam since school grading system is not set!";
                        }
                    } else {
                        $examModel->errors[] = "you MUST not include the term EXAM in your exam name / type";
                    }
                } else {
                    $examModel->errors[] = "You cannot create a new term once there are running term(s), <br> Go to <b>Manage Term</b> to close all active term(s)";
                }
            }
            // loop errors
            echo implode("<br>", $examModel->errors);
        }
    }

    public function exam()
    {
        $data = [];
        $appData = new App;
        $examModel = new ExamModel;
        $allExams = $appData->sch_exam();
        if ($allExams) {
            $data['exams'] = $allExams;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($examModel->validate($_POST)) {
                if (!(str_contains(strtolower($_POST['exam_name']), 'exam'))) {
                    foreach ($_POST as $key => $value) {
                        $upData[$key] = $value;
                    }
                    unset($upData['exam_key']);
                    // /** save update */
                    if (!($examModel->update($_POST['exam_key'], $upData, "exam_key"))) {
                        $_SESSION['status'] = "exam record updated successfully!";
                        $_SESSION['status_code'] = 'success';
                    } else {
                        $_SESSION['status'] = "error updating exam record!";
                        $_SESSION['status_code'] = 'error';
                    }
                } else {
                    $_SESSION['status'] = "you MUST not include the exam EXAM in your exam name / type";
                    $_SESSION['status_code'] = 'warning';
                }
            } else {
                $_SESSION['status'] = implode("<br>", $examModel->errors);
                $_SESSION['status_code'] = 'warning';
            }
        }
        $this->view('System', $data, __FUNCTION__);
    }

    public function deleteExam()
    {
        $ResultModel = new ResultModel;
        $ExamModel = new ExamModel;
        $examKey = $_POST['examKey'];
        if (!($ResultModel->delete($examKey, "re_exam"))) {
            if (!($ExamModel->delete($examKey, "exam_key"))) {
                echo "Exam deleted successfully!";
            } else {
                echo "Error encountered deleting the exam!";
            }
        } else {
            echo "Error encountered deleting the exam!";
        }
    }

    public function vote_head()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $FinVotesModel = new FinVotesModel;
            $schToken = APPINFO->sch_token;
            $voteHeadKey = smartKey($schToken . " " . $_POST['vote_head_name']);
            $voteCheck = $FinVotesModel->fetch(["vote_head_key" => $voteHeadKey]);
            if ($voteCheck) {
                if (!($FinVotesModel->update($voteHeadKey, ["vote_head_name" => $_POST['vote_head_name'], "upby" => CURRENTUSER], "vote_head_key"))) {
                    echo "Vote head found and updated successfully";
                } else {
                    echo "Error updating votehead";
                }
            } else {
                if (!($FinVotesModel->insert(["sch_token" => $schToken, "vote_head_key" => $voteHeadKey, "vote_head_name" => $_POST['vote_head_name'], "addby" => CURRENTUSER]))) {
                    echo "Vote head added successfully";
                } else {
                    echo "Error adding votehead";
                }
            }
        } else {
            $data = [];
            $appData = new App;
            $allVoteHeads = $appData->sch_fin_votes();
            if ($allVoteHeads)
                $data['voteHeads'] = $allVoteHeads;
            $this->view('System', $data, __FUNCTION__);
        }
    }

    public function manage_vote_head()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $FeeStructureModel = new FeeStructureModel;
            $voteAmnKey = smartKey(APPINFO->sch_token . " " . $_POST['vote_key'] . " " . $_POST['class'] . " " . $_POST['term'] . " " . $_POST['category']);
            $checkData = $FeeStructureModel->fetch(["unique_key" => $voteAmnKey]);
            foreach ($_POST as $key => $value) {
                $postData[$key] = $value;
            }
            if (!($checkData)) {
                $postData["sch_token"] = APPINFO->sch_token;
                $postData["unique_key"] = $voteAmnKey;
                $postData["addby"] = CURRENTUSER;
                if (!($FeeStructureModel->insert($postData))) {
                    echo "Vote head amount added successfully";
                } else {
                    echo "Error adding votehead amount";
                }
            } else {
                if (!($FeeStructureModel->update($voteAmnKey, $postData, "unique_key"))) {
                    echo "Vote head amount added successfully";
                } else {
                    echo "Error adding votehead amount";
                }
            }
        }
    }

    public function  fees_structure()
    {
        $data = [];
        $appData = new App;
        $allVoteHeads = $appData->sch_fin_votes();
        if ($allVoteHeads) {
            foreach ($allVoteHeads as $key => $value) {
                $data['feeStructure'][] = $appData->feeVoteInfo($value->vote_head_key);
            }
        }
        $this->view('System', $data, __FUNCTION__);
    }
}
