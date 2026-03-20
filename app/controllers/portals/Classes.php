<?php

/**
 * Classes controller
 */

class Classes
{
    use Controller;

    public function index()
    {
        $data = [];
        $appData = new App;
        $data['classData'] = [];
        $data['staffData'] = $appData->sch_staff();
        for ($i = 1; $i <= APPINFO->sch_cl_num; $i++) {
            $classInfo = $appData->classInfo($i);
            foreach ($classInfo as $classKey => $classValue) {
                $data['classData'][$classKey] = $classValue;
            }
        }
        $this->view('Classes', $data, __FUNCTION__);
    }

    public function streams($class = "")
    {
        $data = [];
        $appData = new App;
        $data['class'] = $class;
        $data['staffData'] = $appData->sch_staff();
        $classInfo = $appData->classInfo($class);
        foreach ($classInfo as $classKey => $classValue) {
            $data['classInfo'] = $classValue;
        }
        $this->view('Classes', $data, __FUNCTION__);
    }

    public function create()
    {
        $data = [];
        $appData = new App;
        $schToken = $appData->schoolToken;
        // Available streams
        $schoolStreams = $appData->sch_streams();
        if ($schoolStreams) {
            $data['schoolStreams'] = $schoolStreams;
        }
        // DETECT POST REQUEST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['add_stream'])) { // add stream
                $StreamModel = new StreamModel;
                if ($StreamModel->validate($_POST)) {
                    $streamKey = smartKey($schToken . " " . $_POST['stream']);
                    if (!($StreamModel->fetch(array("str_key" => $streamKey)))) {
                        if (!($StreamModel->insert(array("sch_token" => $schToken, "str_key" => $streamKey, "stream" => $_POST['stream'], "addby" => CURRENTUSER)))) {
                            $StreamModel->errors[] = "Stream added successfully!";
                        } else {
                            $StreamModel->errors[] = "Error adding the stream, kindly try again!";
                        }
                    } else {
                        $StreamModel->errors[] = strtoupper($_POST['stream']) . " already exists!";
                    }
                }
                // loop errors
                echo implode("<br>", $StreamModel->errors);
            } else { // add class
                $ClassesModel = new ClassesModel;
                if (!(empty($_POST['class']))) {
                    $classKey = smartKey($schToken . " " . $_POST['class'] . " " . $_POST['stream']);
                    if (!($ClassesModel->fetch(array("cl_key" => $classKey)))) {
                        if (!($ClassesModel->insert(array("sch_token" => $schToken, "cl_key" => $classKey, "class" => $_POST['class'], "stream" => $_POST['stream'], "addby" => CURRENTUSER)))) {
                            $ClassesModel->errors[] = "class added successfully!";
                        } else {
                            $ClassesModel->errors[] = "Error adding the class, kindly try again!";
                        }
                    } else {
                        $ClassesModel->errors[] = "Form " . strtoupper($_POST['class'] . " " . $_POST['stream']) . " already exists!";
                    }
                } else {
                    $ClassesModel->errors[] = "CLASS - cannot be empty!";
                }
                // loop errors
                echo implode("<br>", $ClassesModel->errors);
            }
        } else {
            $this->view('Classes', $data, __FUNCTION__);
        }
    }

    public function subjects($class, $stream = "")
    {
        $data = [];
        $appData = new App;
        $data['staffData'] = $appData->sch_staff();
        $subjects = $appData->sch_subjects();
        if (empty($stream)) {
            $data['class'] = $class;
        } else {
            $data['class'] = $class . " " . $stream;
        }
        if ($subjects) {
            foreach ($subjects as $subject) {
                $ubStudCount = 0;
                $subjectInfo = $appData->subInfo($subject->sch_sub_code);
                $ubStudCount = $appData->subStudents($class, $subject->sch_sub_code);
                $subTeacher = $appData->subTeacher($class, $stream, $subjectInfo->sub_code);
                $data["subjects"][] = ["sub_code" => $subjectInfo->sub_code, "sub_name" => $subjectInfo->sub_name, "sub_count" => $ubStudCount, "sub_teacher" => $subTeacher['teacherKey']];
            }
        }
        $this->view('Classes', $data, __FUNCTION__);
    }

    public function manage_sub($class = "", $subject = "")
    {
        $data = [];
        if (!(empty($class)) && !(empty($subject))) {
            $appData = new App;
            $studentModel = new StudentModel;
            $data['subStudsCount'] = 0;
            $subjectInfo = $appData->subInfo($subject);
            $students = $appData->sch_students();
            $data['heading'] = cleanHtml("managing form <b>" . $class . " " . $subjectInfo->sub_name . "</b>");
            if ($students) {
                foreach ($students as $student) {
                    if (is_numeric($class)) {
                        if ($student->stud_form == $class) {
                            $studentsData[] = $student;
                        }
                    } else {
                        $classArr = explode("-", $class);
                        if (($student->stud_form == $classArr[0]) && ($student->stud_stream == $classArr[1])) {
                            $studentsData[] = $student;
                        }
                    }
                }
            }
            if (isset($studentsData)) {
                foreach ($studentsData as $key => $value) {
                    $dropped = explode(",", $value->stud_drop_sub);
                    if (in_array($subject, $dropped)) {
                        $subStatus = "dropped";
                    } else {
                        $subStatus = "active";
                        $data['subStudsCount'] += 1;
                    }
                    $data["students"][$value->stud_key] = array(
                        "stud_adm" => $value->stud_adm, "stud_class" => $value->stud_form . " " . $value->stud_stream, "stud_key" => $value->stud_key, "stud_name" => $value->stud_lname . " " . $value->stud_fname . " " . $value->stud_oname, "sub_status" => $subStatus
                    );
                }
            }
            // Update student
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (isset($_POST['checkedStudKeys'])) {
                    $success = 0;
                    $failed = 0;
                    foreach ($_POST['checkedStudKeys'] as $key => $value) {
                        $studDropped = explode(",", $appData->studentInfo($value)['profile']->stud_drop_sub);
                        if ($_POST['updateStatus'] == "activate") {
                            foreach ($studDropped as $subKey => $subValue) {
                                if ($subject == $subValue) {
                                    unset($studDropped[$subKey]);
                                }
                            }
                        } else {
                            if (!(in_array($subject, $studDropped))) {
                                array_push($studDropped, $subject);
                            }
                        }
                        // // final setups
                        $filteredSub = array_filter($studDropped);
                        $subtoUpdate = implode(",", $filteredSub);
                        if (!($studentModel->update($value, array("stud_drop_sub" => $subtoUpdate), "stud_key"))) {
                            $success += 1;
                        } else {
                            $failed += 1;
                        }
                    }
                    // report
                    $_SESSION['status'] = "Subjects updated successfully with " . $success . " successfull and " . $failed . " failed";
                    $_SESSION['status_code'] = 'success';
                } else {
                    $_SESSION['status'] = "You must select student to <b>" . strtoupper($_POST['updateStatus']) . "</b> subects for";
                    $_SESSION['status_code'] = 'warning';
                }
            }
        }
        $this->view('Classes', $data, __FUNCTION__);
    }

    public function addClassTeacher()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $ClassesModel = new ClassesModel;
            if (!$ClassesModel->update($_POST['classKey'], array("class_teacher" => $_POST['teacher'], "upby" => CURRENTUSER), "cl_key")) {
                echo "Class Teacher updated successfully!";
            } else {
                echo "Error updating class teacher, kindly try again!";
            }
        }
    }

    public function addSubjectTeacher()
    {
        $appData = new App;
        $TeacherSubjectModel = new TeacherSubjectModel;
        $schToken = $appData->schoolToken;
        if (isset($_POST['postFrom'])) {
            $stKey = $_POST['teacher'];
            $stsub = $_POST['subject'];
            $classNum = $_POST['class'];
            $classStream = $_POST['stream'];
        } else {
            $stKey = $_POST['teacher'];
            $stsub = $_POST['subject'];
            $stckey = $_POST['classKey'];
            if (is_numeric($stckey)) {
                $classNum = $stckey;
                $classStream = "";
            } else {
                $classData = explode("-", $stckey);
                $classNum = $classData[0];
                $classStream = $classData[1];
            }
        }
        // if available
        $subInfo = $TeacherSubjectModel->fetch(["tsub_form" => $classNum, "tsub_stream" => $classStream, "tsub_code" => $stsub]);
        if ($subInfo) {
            // update record
            if (!($TeacherSubjectModel->update($subInfo->id, ["tsub_teacher" => $stKey, "addby" => CURRENTUSER]))) {
                echo "Subject teacher updated successfully!";
            } else {
                echo "Error updating subject teacher!";
            }
        } else {
            // insert new record
            if (!($TeacherSubjectModel->insert(["sch_token" => $schToken, "tsub_teacher" => $stKey, "tsub_form" => $classNum, "tsub_stream" => $classStream, "tsub_code" => $stsub, "addby" => CURRENTUSER]))) {
                echo "Subject teacher added successfully!";
            } else {
                echo "Error adding subject teacher!";
            }
        }
    }

    public function delete()
    {
        $ClassesModel = new ClassesModel;
        if (!($ClassesModel->delete($_POST['cl_key'], "cl_key"))) {
            echo "Class deleted successfully!";
        } else {
            echo "Error deleting class, kindly try again!";
        }
    }
}
