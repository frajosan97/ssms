<?php

class App
{
    // default controller
    private $controller = 'Home';
    // default method
    private $method = 'index';
    // school token
    public $schoolToken = TOKEN;
    // split url function
    private function splitUrl()
    {
        $URL = $_GET['url'] ?? 'Home';
        $URL = explode("/", trim($URL, "/"));

        return $URL;
    }

    public function loadController()
    {
        $URL = $this->splitUrl();
        if ($URL[0] == 'auth')
            if (!(isset($URL[1])))
                $URL[1] = 'student';
        if (in_array($URL[0], PORTALKEYS)) {
            if (isset($_SESSION[$URL[0]])) {
                /**set default page to dashboard */
                if (!(isset($URL[1])))
                    $URL[1] = 'dashboard';
                /** select controller */
                $fileName = "../app/controllers/portals/" . ucfirst($URL[1]) . ".php";
                if (in_array($URL[1], SHAREDCONTROLLERS))
                    $fileName = "../app/controllers/" . ucfirst($URL[1]) . ".php";
                if (file_exists($fileName)) {
                    require $fileName;
                    $this->controller = ucfirst($URL[1]);
                    unset($URL[0]);
                    unset($URL[1]);
                } else {
                    $fileName = "../app/controllers/_404.php";
                    require $fileName;
                    $this->controller = "_404";
                }
                $controller = new $this->controller;
                /** select method */
                if (!empty($URL[2])) {
                    if (method_exists($controller, $URL[2])) {
                        $this->method = $URL[2];
                        unset($URL[2]);
                    }
                }
            } else {
                redirect('auth/' . $URL[0]);
            }
        } else {
            /** select controller */
            $fileName = "../app/controllers/" . ucfirst($URL[0]) . ".php";
            if (file_exists($fileName)) {
                require $fileName;
                $this->controller = ucfirst($URL[0]);
                unset($URL[0]);
            } else {
                $fileName = "../app/controllers/_404.php";
                require $fileName;
                $this->controller = "_404";
            }
            $controller = new $this->controller;
            /** select method */
            if (!empty($URL[1])) {
                if (method_exists($controller, $URL[1])) {
                    $this->method = $URL[1];
                    unset($URL[1]);
                }
            }
        }
        /**call user function */
        call_user_func_array([$controller, $this->method], $URL);
    }

    public function thisController()
    {
        $URL = $this->splitUrl();

        return $URL[0];
    }

    public function appInfo($schoolToken = "")
    {
        $schInfo = [];
        $schContact = [];
        $schImgData = [];
        if (empty($schoolToken))
            $schoolToken = $this->schoolToken;
        $SchoolModel = new SchoolModel;
        $SchContactModel = new SchContactModel;
        $SchImageModel = new SchImageModel;
        $UserModel = new UserModel;
        $schoolKey = ["sch_token" => $schoolToken];
        $schInfo = $SchoolModel->fetch($schoolKey);
        if ($schInfo) {
            $schContact = $SchContactModel->fetch($schoolKey);
            $schImages = $SchImageModel->where($schoolKey);
            $allUsers = $UserModel->where($schoolKey);
            $resRank['sch_rank_by_2'] = "";
            if ($schInfo->sch_rank_by == 're_tt') {
                $resRank['sch_rank_by_2'] = 're_pnt';
            } else {
                $resRank['sch_rank_by_2'] = 're_tt';
            }
            foreach (IMAGES as $key => $value) {
                $schImgData[$key] = $value[2];
                if ($schImages) {
                    foreach ($schImages as $image) {
                        if ($key === $image->img_type) {
                            $schImgData[$key] = $image->img_link;
                        }
                    }
                }
            }
            // principal
            $principal['principal'] = array("name" => "", "phone" => "", "email" => "");
            if ($allUsers) {
                foreach ($allUsers as $staff) {
                    if ($staff->user_role == 2) {
                        $principal['principal'] = array("name" => $staff->user_fname . " " . $staff->user_lname, "phone" => $staff->user_phone, "email" => $staff->user_email);
                    }
                }
            }
            // compile final array
            if ($schContact) {
                $schInfo = (object) array_merge((array) $schInfo, $resRank, (array) $schContact, (array) $schImgData, (array) $principal);
            }
        }

        return $schInfo;
    }

    public function sys_subcat()
    {
        $subcat = new SubCatModel;
        $subCatInfo = $subcat->fetchAll();
        sort($subCatInfo);

        return $subCatInfo;
    }

    public function sys_subjects()
    {
        $subjects = new SubjectsModel;
        $subjectsInfo = $subjects->fetchAll();
        sort($subjectsInfo);

        return $subjectsInfo;
    }

    public function sys_invoices()
    {
        $invoicesInfo = [];
        $invoices = new InvoiceModel;
        $invoiceItems = new InvoiceItemModel;
        $paymentModel = new PaymentModel;
        $invoicesData = $invoices->fetchAll();
        if ($invoicesData) {
            foreach ($invoicesData as $inv) {
                $invKey = ["inv_key" => $inv->inv_key];
                $invItemData = [];
                $invItems = $invoiceItems->where($invKey);
                if ($invItems) {
                    $invItemData = objectToArray($invItems);
                }
                $inPaymentData = [];
                $inPayments = $paymentModel->where($invKey);
                if ($inPayments) {
                    $inPaymentData = objectToArray($inPayments);
                }
                $invoicesInfo[] = array_merge(objectToArray($inv), array("invItems" => $invItemData), array("invPayments" => $inPaymentData));
            }
        }

        return $invoicesInfo;
    }

    public function sys_schools()
    {
        $schoolData = [];
        $school = new SchoolModel;
        $rawData = $school->fetchAll();
        if ($rawData) {
            foreach ($rawData as $key => $value) {
                $schoolData[$value->sch_token] = $value;
            }
        }

        return $schoolData;
    }

    public function automation()
    {
        $allTerms = $this->sch_term();
        $allExams = $this->sch_exam();
        $termModel = new TermModel;
        $examModel = new ExamModel;
        $today = date("Y-m-d");
        // TERMS MANAGEMENT
        if ($allTerms) {
            foreach ($allTerms as $term) {
                if ((strtotime($term->end_date) < time()) && ($term->term_status == "active")) {
                    $termModel->update($term->id, array("term_status" => "closed"));
                }
            }
        }
        // EXAMS MANAGEMENT
        if ($allExams) {
            foreach ($allExams as $exam) {
                if ((strtotime($exam->end_date) < time()) && ($exam->exam_status == "active")) {
                    $examModel->update($exam->id, array("exam_status" => "closed"));
                }
            }
        }
    }

    public function sch_inv_generator()
    {
        $allInvoices = $this->sch_invoices(APPINFO->sch_token);
        if ($allInvoices) {
            foreach ($allInvoices as $key => $value) {
                if (($value['inv_type'] == "system renewal") && (strtotime($value['inv_exp']) > time())) {
                    $allRenewals = $value;
                }
            }
        }
        // generate renewal invoice
        if (!(isset($allRenewals))) {
            $invoiceTotal = 0;
            foreach (SYSRENEWALINVOICE as $key => $value) {
                $invoiceTotal += $value[1];
                $billData[] = ["inv_item_head" => $value[0], "inv_item_amnt" => $value[1]];
            }
            if ($invoiceTotal > 0) {
                $InvoiceModel = new InvoiceModel;
                $InvoiceItemModel = new InvoiceItemModel;
                $schoolKey = $this->schoolToken;
                $invoiceKey = smartKey($schoolKey . " " . time());
                $invAmountAddVAT = invAmountAddVAT($invoiceTotal);
                $currentDate = new DateTime();
                $currentDate->add(new DateInterval('P1Y'));
                $invoiceDate = $currentDate->format('Y-m-d');
                if (!($InvoiceModel->insert(["sch_token" => $schoolKey, "inv_key" => $invoiceKey, "inv_type" => "system renewal", "inv_desc" => "system renewal", "inv_ref" => $invoiceKey, "inv_amnt" => $invoiceTotal, "inv_exp" => $invoiceDate, "addby" => "system generated"]))) {
                    foreach ($billData as $billItem) {
                        $InvoiceItemModel->insert(["sch_token" => $schoolKey, "inv_key" => $invoiceKey, "inv_item" => $billItem['inv_item_head'], "inv_item_amnt" => $billItem['inv_item_amnt'], "addby" => "system generated"]);
                    }
                }
                // Send mail and sms alert on account creation
                $smsInfo = [
                    "phone" => APPINFO->sch_phone, "email" => APPINFO->sch_email, "subject" => strtoupper(APPINFO->sch_name . " system renewal invoice"),
                    "message" => ucwords(greeting_msg()) . ", " . strtoupper(APPINFO->sch_name) . " system renewal invoice have been created. Kindly login to your staff account to view and pay by " . date("d/m/Y", strtotime($invoiceDate)) . " for the invoice: " . $invoiceKey . ". To pay via M-Pesa use Till Number: " . TILL . ", Amount: Ksh " . number_format($invAmountAddVAT['invGrantTotal'], 2) . ". Thank you."
                ];
                $this->apiSMS($smsInfo);
                $this->sendMail($smsInfo);
            }
        }
    }

    public function sch_clearance($schToken)
    {
        if (!(APPINFO->sch_status > 1)) {
            if (!(APPINFO->sch_mode > 1)) {
                $paid = 0;
                $billed = 0;
                $clearance = ["type" => "", "message" => ""];
                $allInvoices = $this->sch_invoices($schToken);
                foreach ($allInvoices as $invoice) {
                    if (time() > strtotime($invoice['inv_exp'])) {
                        $billed += $invoice['inv_amnt'];
                        foreach ($invoice['invPayments'] as $paidAmnt) {
                            $paid += $paidAmnt['pay_amnt'];
                        }
                    }
                }
                $balance = $billed - $paid;
                if ($balance > 0)
                    $clearance = ["type" => "billing problems", "message" => "We are sorry but this is to notify you that, <b><u>" . strtoupper(APPINFO->sch_name) . "</b></u> services are unavailable due to subscription issues, for payment call: +254796594366"];
            } else {
                $clearance = ["type" => "free", "message" => "This school account is currently under free mode subscription, To remove this headline, kindly pay for all your pending bills!"];
            }
        } else {
            $clearance = ["type" => "account suspended", "message" => "We are sorry but this is to notify you that, <b><u>" . strtoupper(APPINFO->sch_name) . "</b></u> services are unavailable because the account have been suspended by the system administrators."];
        }
        return $clearance;
    }

    public function sch_invoices($schToken)
    {
        $schInvoices = [];
        $allInvoices = $this->sys_invoices();
        foreach ($allInvoices as $invoice) {
            if ($invoice['sch_token'] == $schToken) {
                $schInvoices[] = $invoice;
            }
        }

        return $schInvoices;
    }

    public function invoiceInfo($invKey)
    {
        $invoiceInfo = "";
        $allInvoices = $this->sys_invoices();
        foreach ($allInvoices as $invoice) {
            if ($invoice['inv_key'] == $invKey) {
                $invoiceInfo = $invoice;
            }
        }

        return $invoiceInfo;
    }

    public function sys_payments($invoiceKey = "")
    {
        $paymentData = [];
        $school = new PaymentModel;
        $payRawData = $school->fetchAll();
        if ($payRawData) {
            if (empty($invoiceKey)) {
                $paymentData = $payRawData;
            } else {
                foreach ($payRawData as $payData) {
                    if ($payData->inv_key == $invoiceKey) {
                        $paymentData[] = $payData;
                    }
                }
            }
        }

        return $paymentData;
    }

    /** ================================================== */
    # Active user session
    public function activeUser()
    {
        foreach (PORTALS as $portal => $values) {
            if (isset($_SESSION[$portal])) {
                if ($portal == "student") {
                    $stud = new StudentModel;
                    $activeUser = $stud->fetch(["sch_token" => $_SESSION[$portal]->sch_token, "stud_key" => $_SESSION[$portal]->stud_key]);
                } else {
                    $user = new UserModel;
                    $activeUser = $user->fetch(["sch_token" => $_SESSION[$portal]->sch_token, "user_key" => $_SESSION[$portal]->user_key]);
                }
                $_SESSION[$portal] = $activeUser;
            }
        }
    }

    public function currentUserInfo($page)
    {
        if (isset($_SESSION[$page])) {
            if ($page == "student") {
                $userDetails = array("userKey" => $_SESSION[$page]->stud_key, "userName" => $_SESSION[$page]->stud_adm, "fullName" => $_SESSION[$page]->stud_lname . " " . $_SESSION[$page]->stud_fname . " " . $_SESSION[$page]->stud_oname);
            } else {
                $userDetails = array("userKey" => $_SESSION[$page]->user_key, "userName" => $_SESSION[$page]->user_name, "fullName" => $_SESSION[$page]->user_fname . " " . $_SESSION[$page]->user_lname);
            }
        } else {
            $userDetails = array("userKey" => "", "userName" => "", "fullName" => "");
        }
        return $userDetails;
    }

    /** Term info */
    public function sch_term()
    {
        $termModel = new TermModel;
        $schoolKey = array("sch_token" => $this->schoolToken);
        $allTerms = $termModel->where($schoolKey);

        return $allTerms;
    }

    /** active term information */
    public function activeTerm()
    {
        $activeTermInfo = [];
        $allTerms = $this->sch_term();
        if ($allTerms) {
            foreach ($allTerms as $term) {
                if ($term->term_status == "active") {
                    $activeTermInfo = $term;
                }
            }
        }

        return $activeTermInfo;
    }

    /** recent term info */
    public function recentTerm()
    {
        $recentTermInfo = [];
        $allTerms = $this->sch_term();
        if ($allTerms) {
            foreach ($allTerms as $termKey => $term) {
                if ($termKey == array_key_first($allTerms)) {
                    $recentTermInfo = $term;
                }
            }
        }

        return $recentTermInfo;
    }

    /** Specific term information */
    public function termInfo($termKey)
    {
        $termInfo = [];
        $allTerms = $this->sch_term();
        foreach ($allTerms as $term) {
            if ($term->term_key == $termKey) {
                $termInfo = $term;
            }
        }

        return $termInfo;
    }

    /** Exam info */
    public function sch_exam()
    {
        $examModel = new ExamModel;
        $allExams = $examModel->where(["sch_token" => $this->schoolToken]);

        return $allExams;
    }

    /** active term information */
    public function activeExam()
    {
        $activeExamInfo = [];
        $allExams = $this->sch_exam();
        if ($allExams) {
            foreach ($allExams as $exam) {
                if ($exam->exam_status == "active") {
                    $activeExamInfo = $exam;
                }
            }
        }
        return $activeExamInfo;
    }

    public function recentExam()
    {
        $allExams = $this->sch_exam();
        if ($allExams) {
            $allExams = objectToArray($allExams);
            foreach ($allExams as $exam => $examData) {
                if ($exam == array_key_first($allExams)) {
                    return $examData;
                }
            }
        }
    }

    /** Specific term information */
    public function examInfo($examKey)
    {
        $examInfo = [];
        $allExams = $this->sch_exam();
        if ($allExams) {
            foreach ($allExams as $exam) {
                if ($exam->exam_key == $examKey) {
                    return $exam;
                }
            }
        }
    }

    public function sch_staff()
    {
        $users = new UserModel;
        $staffInfo = $users->where(["sch_token" => $this->schoolToken]);
        return $staffInfo;
    }

    public function staffInfo($staffKey)
    {
        $staffInfo = [];
        $allStaff = $this->sch_staff();
        $allClasses = $this->sch_classes();
        foreach ($allStaff as $staff) {
            if ($staff->user_key == $staffKey) {
                $staffInfo['profile'] = $staff;
                $staffInfo['classes'] = [];
                // classes managed
                if ($allClasses) {
                    foreach ($allClasses as $key => $value) {
                        if ($value->class_teacher == $staffKey) {
                            $staffInfo['classes'][$value->cl_key] = $value;
                        }
                    }
                }
                // subjects
                $staffInfo['subjects'] = $this->teacherSub($staffKey);
            }
        }
        return $staffInfo;
    }

    public function teacherSub($teacherKey)
    {
        $allSubjects = [];
        $allSubTeachers = $this->sch_steachers();
        if ($allSubTeachers) {
            foreach ($allSubTeachers as $subTeacher) {
                if ($subTeacher->tsub_teacher == $teacherKey) {
                    $allSubjects[] = $subTeacher;
                }
            }
        }

        return $allSubjects;
    }

    public function sch_students()
    {
        $StudentModel = new StudentModel;
        $studentsInfo = $StudentModel->where(["sch_token" => $this->schoolToken]);
        return $studentsInfo;
    }

    public function latest_adm()
    {
        $allSchStudents = $this->sch_students();
        if ($allSchStudents) {
            foreach ($allSchStudents as $key => $value) {
                $adm[] = $value->stud_adm;
            }
            if (isset($adm)) {
                return max($adm);
            }
        }
    }

    public function studentInfo($studentKey = "")
    {
        $studentInfo = [];
        $sysSubjects = $this->sys_subjects();
        $schSubjects = $this->sch_subjects();
        $allStudents = $this->sch_students();
        $allResults = $this->sch_results();
        $allFinance = $this->sch_finance();
        // get student profile information
        if ($allStudents) {
            foreach ($allStudents as $student) {
                if ($student->stud_key == $studentKey) {
                    $studentInfo['profile'] = $student;
                    $droppedSub = explode(",", $student->stud_drop_sub);
                }
            }
            if (count($studentInfo) > 0) {
                // Student subjects
                $active['active'] = [];
                $dropped['dropped'] = [];
                foreach ($schSubjects as $schSubData) {
                    foreach ($sysSubjects as $sysSubData) {
                        if ($schSubData->sch_sub_code == $sysSubData->sub_code) {
                            if (!(in_array($schSubData->sch_sub_code, $droppedSub))) {
                                $active['active'][] = (object) array_merge((array) $sysSubData, (array) $schSubData);
                            } else {
                                $dropped['dropped'][] = (object) array_merge((array) $sysSubData, (array) $schSubData);
                            }
                        }
                    }
                }
                $studentInfo['subjects'] = array_merge($active, $dropped);
                // Student results
                $studentInfo['results'] = [];
                if ($allResults) {
                    foreach ($allResults as $results) {
                        if ($results->re_studK == $studentKey) {
                            $studentInfo['results'][] = $results;
                        }
                    }
                }
                // student billing info
                $studentInfo['finance'] = [];
                $ttBilled = 0;
                $ttPaid = 0;
                if ($allFinance) {
                    array_multisort(array_column($allFinance, "date"), $allFinance);
                    foreach ($allFinance as $finance) {
                        if ($finance->fi_studK == $studentKey) {
                            if ($finance->fi_type == "post") {
                                $ttBilled += $finance->fi_amnt;
                            } else {
                                $ttPaid += $finance->fi_amnt;
                            }
                            $studentInfo['finance'][] = (object)array_merge(objectToArray($finance), array("rect_bill" => $ttBilled, "rect_paid" => $ttPaid, "rect_bal" => ($ttBilled - $ttPaid)));
                        }
                    }
                }
                // Finance summary
                $studentInfo['finSummary'] = array("ttBilled" => $ttBilled, "ttPaid" => $ttPaid, "ttBalance" => ($ttBilled - $ttPaid));

                return $studentInfo;
            }
        }
    }

    public function subStudents($class, $sub_code = "")
    {
        $studsCount = 0;
        $allStudents = $this->sch_students();
        if (is_numeric($class)) {
            if ($allStudents) {
                foreach ($allStudents as $student) {
                    $studDropped = explode(",", $student->stud_drop_sub);
                    if (!in_array($sub_code, $studDropped) && ($student->stud_form == $class)) {
                        $studsCount += 1;
                    }
                }
            }
        } else {
            $classArr = explode("-", $class);
            if ($allStudents) {
                foreach ($allStudents as $student) {
                    $studDropped = explode(",", $student->stud_drop_sub);
                    if (!in_array($sub_code, $studDropped) && ($student->stud_form == $classArr[0]) && ($student->stud_stream == $classArr[1])) {
                        $studsCount += 1;
                    }
                }
            }
        }

        return $studsCount;
    }

    public function sch_streams()
    {
        $streams = new StreamModel;
        $streamInfo = $streams->where(["sch_token" => $this->schoolToken]);
        return $streamInfo;
    }

    public function sch_classes()
    {
        $classesInfo = [];
        $class = new ClassesModel;
        $classesInfo = $class->where(["sch_token" => $this->schoolToken]);
        return $classesInfo;
    }

    public function singleClass($form, $stream = "")
    {
        $singleClass = [];
        $allClasses = $this->sch_classes();
        if ($allClasses) {
            foreach ($allClasses as $key => $value) {
                if ($value->class == $form && $value->stream == $stream) {
                    $singleClass[smartKey($form . " " . $stream)] = $value;
                }
            }
        }
        return $singleClass;
    }

    // CLASSES MANAGEMENT
    public function streamInfo($streamKey)
    {
        $streamsData = $this->sch_streams();
        if ($streamsData) {
            foreach ($streamsData as $key => $value) {
                if ($value->str_key == $streamKey) {
                    return $value;
                }
            }
        }
    }

    public function getClassTeacher($form, $stream = "")
    {
        $allClasses = $this->sch_classes();
        if ($allClasses) {
            foreach ($allClasses as $key => $value) {
                if ($value->class == $form && $value->stream == $stream) {
                    $staffInfo = $this->staffInfo($value->class_teacher);
                    if ($staffInfo) {
                        return $staffInfo['profile'];
                    }
                }
            }
        }
    }

    public function classStudsCount($class, $stream = "")
    {
        $students = [];
        $allStudents = $this->sch_students();
        if (empty($stream)) {
            if ($allStudents) {
                foreach ($allStudents as $key => $value) {
                    if ($value->stud_form == $class) {
                        $students[] = $value;
                    }
                }
            }
        } else {
            $streamInfo = $this->streamInfo($stream);
            if ($streamInfo) {
                if ($allStudents) {
                    foreach ($allStudents as $key => $value) {
                        if ($value->stud_form == $class && $value->stud_stream == $streamInfo->stream) {
                            $students[] = $value;
                        }
                    }
                }
            }
        }
        return $students;
    }

    public function classInfo($class, $stream = "")
    {
        $classInfo = [];
        $allClasses = $this->sch_classes();
        if ($allClasses) {
            // DETECT CLASS TYPE
            if (empty($stream)) { // get full class
                $streamInfo['streams'] = [];
                $classTeacher = "";
                $classKey = "";
                foreach (GENDER as $genderKey => $genderValue) {
                    $countPerGender[$genderValue] = 0;
                }
                foreach ($allClasses as $key => $value) {
                    if ($value->class == $class) {
                        if (empty($value->stream)) {
                            $classKey = $value->cl_key;
                            $classTeacher = $value->class_teacher;
                        }
                        // form information
                        $classStudents = $this->classStudsCount($value->class);
                        if ($classStudents) {
                            foreach (GENDER as $genderKey => $genderValue) {
                                $gender = array_column_count($classStudents, 'stud_gender');
                                $count = array_count_values($gender);
                                if (isset($count[$genderKey]))
                                    $countPerGender[$genderValue] = $count[$genderKey];
                            }
                        }
                        // streams information
                        if (!(empty($value->stream))) {
                            $thisStreamData = $this->classStreamInfo($value->class, $value->stream);
                            if ($thisStreamData)
                                $streamInfo['streams'][array_keys($thisStreamData)[0]] = array_values($thisStreamData)[0];
                        }
                        // Final form array
                        $classInfo[$class] = array_merge(["classKey" => $classKey], ["streamCount" => count($streamInfo['streams'])], $streamInfo, $countPerGender, ["total" => count($classStudents)], ["teacher" => $classTeacher]);
                    }
                }
            } else { // get stream info
                $classInfo[$class] = $this->classStreamInfo($class, $stream);
            }
        }

        return $classInfo;
    }

    public function classStreamInfo($class, $stream = "")
    {
        $classInfo = [];
        $allClasses = $this->sch_classes();
        foreach (GENDER as $genderKey => $genderValue) {
            $countPerGender[$genderValue] = 0;
        }
        foreach ($allClasses as $key => $value) {
            if (!(empty($value->stream))) {
                $streamInfo = $this->streamInfo($value->stream);
                if ($value->class == $class && $streamInfo->str_key == $stream) {
                    $classStudents = $this->classStudsCount($value->class, $stream);
                    if ($classStudents) {
                        foreach ($classStudents as $studentKey => $studentValue) {
                            foreach (GENDER as $genderKey => $genderValue) {
                                if ($studentValue->stud_gender == $genderKey) {
                                    $countPerGender[$genderValue] += 1;
                                }
                            }
                        }
                    }
                    // Stream info
                    $classInfo[$streamInfo->stream] = array_merge(["streamKey" => $value->cl_key], $countPerGender, ["total" => count($classStudents)], ["teacher" => $value->class_teacher]);
                }
            }
        }

        return $classInfo;
    }

    public function sch_steachers()
    {
        $subjectTeachers = [];
        $subjectTeacherModel = new TeacherSubjectModel;
        $subjectTeachers = $subjectTeacherModel->where(["sch_token" => $this->schoolToken]);
        return $subjectTeachers;
    }

    public function subTeacher($form, $stream, $subject)
    {
        $subjectTeacher = ["teacherKey" => "", "teacherName" => ""];
        $allSubTeachers = $this->sch_steachers();
        $allUsers = $this->sch_staff();
        if ($allSubTeachers) {
            foreach ($allSubTeachers as $singRec) {
                if (($singRec->tsub_form == $form) && ($singRec->tsub_stream == $stream) && ($singRec->tsub_code == $subject)) {
                    $staffName = "";
                    foreach ($allUsers as $singleStaff) {
                        if ($singleStaff->user_key == $singRec->tsub_teacher) {
                            $staffName = $singleStaff->user_fname . " " . $singleStaff->user_lname;
                        }
                    }
                    $subjectTeacher = array("teacherKey" => $singRec->tsub_teacher, "teacherName" => $staffName);
                }
            }
        }
        return $subjectTeacher;
    }

    /** School subjects information */
    public function sch_subjects()
    {
        $schoolSubInfo = [];
        $subjects = new SchSubjectsModel;
        $subData = $subjects->where(["sch_token" => $this->schoolToken]);
        if ($subData) {
            foreach ($subData as $key => $value) {
                $schoolSubInfo[$value->sch_sub_code] = $value;
            }
            ksort($schoolSubInfo);
        }
        return $schoolSubInfo;
    }

    // Grading system
    public function sch_grading_cat()
    {
        $GradingModel = new GradingModel;
        $grdCatData = $GradingModel->where(["sch_token" => $this->schoolToken]);
        if ($grdCatData) {
            return $grdCatData;
        }
    }

    public function sch_grading_sys()
    {
        $GradingSystemModel = new GradingSystemModel;
        $grdSysData = $GradingSystemModel->where(["sch_token" => $this->schoolToken]);
        if ($grdSysData) {
            sort($grdSysData);
            return $grdSysData;
        }
    }

    public function grdSysData($grd_key = "")
    {
        $grdSysData = [];
        $allGradingSys = $this->sch_grading_sys();
        if ($allGradingSys) {
            foreach ($allGradingSys as $key => $value) {
                if ($value->grds_cat_key == $grd_key) {
                    $grdSysData[$value->grds_grade] = $value;
                }
            }
        }
        return $grdSysData;
    }

    public function gradingSysInfo($grd_key = "")
    {
        $grdSysInfo = [];
        $allGradingCat = $this->sch_grading_cat();
        if ($allGradingCat) {
            foreach ($allGradingCat as $key => $value) {
                if ($value->grd_key == $grd_key) {
                    $grdSysInfo = array_merge(objectToArray($value), ["grades" => $this->grdSysData($value->grd_key)]);
                } else if ($value->grd_subcat == $grd_key) {
                    $grdSysInfo = array_merge(objectToArray($value), ["grades" => $this->grdSysData($value->grd_key)]);
                }
            }
            if (empty($grdSysInfo)) {
                foreach ($allGradingCat as $key => $value) {
                    if ($value->grd_subcat == "default") {
                        $grdSysInfo = array_merge(objectToArray($value), ["grades" => $this->grdSysData($value->grd_key)]);
                    }
                }
            }
        }

        return $grdSysInfo;
    }

    public function subInfo($subCode)
    {
        $schoolSubInfo = [];
        $systemSubcat = $this->sys_subcat();
        $systemSubjects = $this->sys_subjects();
        $allSubjects = $this->sch_subjects();
        foreach ($allSubjects as $subInfo) {
            if ($subInfo->sch_sub_code == $subCode) {
                foreach ($systemSubjects as $subject) {
                    if ($subject->sub_code == $subInfo->sch_sub_code) {
                        foreach ($systemSubcat as $subCat) {
                            if ($subCat->cat_key == $subject->sub_cat) {
                                $grading['grading'] = $this->gradingSysInfo($subCat->cat_key);
                                $schoolSubInfo = (object) array_merge((array) $subCat, (array) $subject, (array) $subInfo, $grading);
                            }
                        }
                    }
                }
            }
        }
        return $schoolSubInfo;
    }

    // Library
    public function sch_lib_res()
    {
        $libraryData = [];
        $libraryModel = new LibraryModel;
        $libraryData = $libraryModel->where(["sch_token" => $this->schoolToken]);
        if ($libraryData) {
            sort($libraryData);
        }
        return $libraryData;
    }

    // school downloads
    public function sch_downloads()
    {
        $downloadsData = [];
        $downloasModel = new DownloadsModel;
        $downloadsData = $downloasModel->where(["sch_token" => $this->schoolToken]);
        if ($downloadsData) {
            sort($downloadsData);
        }
        return $downloadsData;
    }

    // school blog
    public function sch_blog()
    {
        $blogData = [];
        $blogModel = new BlogModel;
        $blogData = $blogModel->where(["sch_token" => $this->schoolToken]);
        if ($blogData) {
            sort($blogData);
        }
        return $blogData;
    }

    // RESULSTS
    public function get_sub_data($subject, $marks = "")
    {
        if ($subject == "kcpe") {
            $gradingSystem = $this->gradingSysInfo($subject);
        } else {
            $subInfo = $this->subInfo($subject);
            if ($subInfo)
                $gradingSystem = $subInfo->grading;
        }
        if (isset($gradingSystem)) {
            $subData = ["marks" => "--", "points" => "--", "grade" => "--", "rem" => "--"];
            switch ($marks) {
                default:
                    foreach ($gradingSystem['grades'] as $key => $value) {
                        if ($marks >= $value->grds_min) {
                            $remarks = ($subject == 102) ? $value->grds_lugha : $value->grds_rem;
                            $subData = ["marks" => $marks, "points" => $value->grds_point, "grade" => $value->grds_grade, "rem" => $remarks];
                            break;
                        }
                    }
                    break;
            }
        } else {
            $subData = ["marks" => "--", "points" => "--", "grade" => "--", "rem" => "--"];
        }
        return $subData;
    }

    public function res_final($points)
    {
        $sch_grd_sys = $this->sch_grading_cat();
        if ($sch_grd_sys) {
            foreach ($sch_grd_sys as $key => $value) {
                if ($value->grd_subcat == "default") {
                    $gradingSyst = $this->gradingSysInfo($value->grd_key);
                }
            }
            if (isset($gradingSyst)) {
                if (($points > 0 && $points < 1))
                    $points = 1;
                $points = round($points);
                switch ($points) {
                    default:
                        foreach ($gradingSyst['grades'] as $gradeKey => $gradeValue) {
                            if ($points >= $gradeValue->grds_point) {
                                $resData = ["grade" => $gradeValue->grds_grade, "points" => $gradeValue->grds_point,];
                                break;
                            }
                        }
                        break;
                }
            } else {
                $resData = ["grade" => "", "points" => "",];
            }
        }

        return $resData;
    }

    public function sendMail($mailInfo)
    {
        if (!($_SERVER['SERVER_NAME'] == "localhost")) {
            $mailTo = $mailInfo['email'];
            $mailSubject = $mailInfo['subject'];
            $mailBody = $mailInfo['message'];
            ob_start();
            include(LIB_PATH . "app/views/common/others/cMail.php");
            $message = ob_get_clean();
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: Frajosan IT Consultancies<info@frajosantech.co.ke>' . "\r\n";
            mail($mailTo, $mailSubject, $message, $headers);
        }

        return false;
    }

    public function modemSMS($smsInfo)
    {
        $phoneNumber = $smsInfo['phone'];
        $message = $smsInfo['message'];

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'http://localhost/projects/sms/api',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "mobile": "' . $phoneNumber . '",
                    "message": "' . $message . '"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function apiSMS($smsInfo)
    {
        $phoneNumber = $smsInfo['phone'];
        $message = $smsInfo['message'];
        $apiKey = APPINFO->sch_sms_api;
        $partnerID = APPINFO->sch_partner_id;
        $shortCode = APPINFO->sch_short_code;

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://sms.hencangroup.co.ke/api/services/sendsms/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "apikey":"' . $apiKey . '",
                    "partnerID":"' . $partnerID . '",
                    "message":"' . $message . '",
                    "shortcode":"' . $shortCode . '",
                    "mobile":"' . smartPhone($phoneNumber) . '"
                  }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function sch_dynamic_pages()
    {
        $DynamicPagesModel = new DynamicPagesModel;
        $dynamicPages = $DynamicPagesModel->where(["sch_token" => $this->schoolToken]);
        return $dynamicPages;
    }

    /**
     * ====================================================================================================================
     * FINANCE
     * ====================================================================================================================
     */
    public function sch_income_source()
    {
        $FinIncomeSource = new FinIncomeSource;
        $incomeSource = $FinIncomeSource->where(["sch_token" => $this->schoolToken]);
        return $incomeSource;
    }

    public function sch_finance()
    {
        $financeModel = new FinanceModel;
        $financeInfo = $financeModel->where(["sch_token" => $this->schoolToken]);
        return $financeInfo;
    }

    public function finRecInfo($fi_key = "")
    {
        $allFinances = $this->sch_finance();
        if ($allFinances) {
            foreach ($allFinances as $key => $value) {
                if ($value->fi_key == $fi_key) {
                    return $value;
                }
            }
        }
    }

    public function sch_fin_votes()
    {
        $finVotesModel = new FinVotesModel;
        $finVotesInfo = $finVotesModel->where(["sch_token" => $this->schoolToken]);
        return $finVotesInfo;
    }

    public function sch_fin_accounts()
    {
        $finAccModel = new FinAccountModel;
        $finAccInfo = $finAccModel->where(["sch_token" => $this->schoolToken]);
        return $finAccInfo;
    }

    public function sch_fin_fStructure()
    {
        $feeStructureModel = new FeeStructureModel;
        $feeStructureInfo = $feeStructureModel->where(["sch_token" => $this->schoolToken]);
        return $feeStructureInfo;
    }

    public function sch_fin_acc_votes($accKey = "")
    {
        $allAccounts = $this->sch_fin_accounts();
        if ($allAccounts) {
            foreach ($allAccounts as $key => $value) {
                if ($value->acc_key == $accKey) {
                    $mainAccount = $value;
                }
            }

            if (isset($mainAccount)) {
                $accountData['acc'] = $mainAccount;
                if (!empty($mainAccount->acc_votes)) {
                    $accVotes = explode(",", $mainAccount->acc_votes);
                    foreach ($accVotes as $voteKey) {
                        $voteInfo = $this->feeVoteInfo($voteKey);
                        $accountData['votes'][] = $voteInfo;
                    }
                }
            }

            if (isset($accountData)) {
                return $accountData;
            }
        }
    }

    public function feeVoteInfo($voteKey = "")
    {
        $voteData = [];
        $allVoteHeads = $this->sch_fin_votes();
        $allVoteAmnt = $this->sch_fin_fStructure();
        if ($allVoteHeads) {
            foreach ($allVoteHeads as $voteValue) {
                if ($voteValue->vote_head_key == $voteKey) {
                    $voteInfo = $voteValue;
                }
            }
            // check if vote head is found
            if (isset($voteInfo)) {
                $voteInfo = objectToArray($voteInfo);
                $voteAmntData = [];
                if ($allVoteAmnt) {
                    foreach ($allVoteAmnt as $voteAmnt) {
                        if ($voteAmnt->vote_key == $voteKey) {
                            $voteAmntData[] = $voteAmnt;
                        }
                    }
                }
                // final compilation
                $voteData = array_merge($voteInfo, array("voteAmnt" => []));
                if (count($voteAmntData) > 0)
                    $voteData = array_merge($voteInfo, array("voteAmnt" => $voteAmntData));
            }
        }

        return $voteData;
    }

    public function sch_fin_pay_votes()
    {
        $feePayVotes = new FinVotesPayModel;
        $feeStructureInfo = $feePayVotes->where(["sch_token" => $this->schoolToken]);
        return $feeStructureInfo;
    }

    public function finRecPayVotes($fin_key = "")
    {
        $finVotes = [];
        $allPayVotes = $this->sch_fin_pay_votes();
        $allVoteHeads = $this->sch_fin_votes();
        if ($allPayVotes) {
            foreach ($allPayVotes as $payVote) {
                if (($payVote->fin_post_key == $fin_key) || ($payVote->fin_pay_key == $fin_key)) {
                    foreach ($allVoteHeads as $voteHead) {
                        if ($voteHead->vote_head_key == $payVote->vote_head_key) {
                            $finVotes[$voteHead->vote_head_key] = (object) array_merge(objectToArray($payVote), array("vote_head_name" => $voteHead->vote_head_name));
                        }
                    }
                }
            }
        }

        return $finVotes;
    }

    public function payReceipt($receiptKey = "")
    {
        $receiptData = "";
        $allFinRec = $this->sch_finance();
        if ($allFinRec) {
            foreach ($allFinRec as $finRec) {
                if ($finRec->fi_key == $receiptKey) {
                    $studInfo = $this->studentInfo($finRec->fi_studK);
                    foreach ($studInfo['finance'] as $studFinRec) {
                        if ($studFinRec->fi_key == $receiptKey) {
                            $termData = $this->termInfo($finRec->fi_termK);
                            $receiptVotes = $this->finRecPayVotes($receiptKey);
                            $receiptData = array(
                                "rect_no" => $finRec->id,
                                "stud_adm" => $studInfo['profile']->stud_adm,
                                "stud_name" => $studInfo['profile']->stud_lname . " " . $studInfo['profile']->stud_fname . " " . $studInfo['profile']->stud_oname,
                                "stud_class" => $studInfo['profile']->stud_form . " " . $studInfo['profile']->stud_stream,
                                "pay_date" => $termData->date,
                                "pay_term" => $termData->term . ", " . date("Y", strtotime($termData->date)),
                                "pay_key" => $finRec->fi_key,
                                "pay_amount" => $finRec->fi_amnt,
                                "pay_desc" => $finRec->fi_desc,
                                "pay_mode" => $finRec->fi_payM,
                                "pay_ref" => $finRec->fi_ref,
                                "receipt_votes" => $receiptVotes,
                                "rect_bill_summ" => ["rect_bill" => $studFinRec->rect_bill, "rect_paid" => $studFinRec->rect_paid, "rect_bal" => $studFinRec->rect_bal],
                                "stud_bill" => $studInfo['finSummary'],
                                "served_by" => $finRec->fi_by
                            );
                        }
                    }
                }
            }
        }

        return $receiptData;
    }

    public function sch_fin_exp_items()
    {
        $finExpItemModel = new FinExpItemModel;
        $finExpItemInfo = $finExpItemModel->where(["sch_token" => $this->schoolToken]);
        return $finExpItemInfo;
    }

    public function expInvInfo($invKey = "")
    {
        $expInvInfo = "";
        $allFinRec = $this->sch_finance();
        $finExpItems = $this->sch_fin_exp_items();
        if ($allFinRec) {
            foreach ($allFinRec as $finRec) {
                if ($finRec->fi_key == $invKey) {
                    $expFinRec = $finRec;
                }
            }
            if ($expFinRec) {
                foreach ($finExpItems as $finExpRec) {
                    if ($finExpRec->fi_key == $invKey) {
                        $expVotes['expVotes'][$finExpRec->id] = $finExpRec;
                    }
                }
                $expInvInfo = (object) array_merge(objectToArray($expFinRec), $expVotes);
            }
        }

        return $expInvInfo;
    }

    /**
     * ==================================================================================================================================================================
     * THIS IS RESULTS ANALYSIS FUNCTION
     * ==================================================================================================================================================================
     */
    public function prev_exam($currentExamKey)
    {
        $previousExam = "";
        $allExams = $this->sch_exam();
        if ($allExams) {
            sort($allExams);
            $newArray = [];
            foreach ($allExams as $examData) {
                $newArray[$examData->exam_key] = $examData;
            }
            $prevExKey = getPrevKey($currentExamKey, $newArray);
            if ($prevExKey) {
                foreach ($newArray as $key => $value) {
                    if ($key == $prevExKey) {
                        $previousExam = $value;
                    }
                }
            }
        }
        return $previousExam;
    }

    public function studPrevExam($studKey, $examKey)
    {
        $previousExam = $this->prev_exam($examKey);
        $allExams = $this->sch_results();
        $examData = "";
        if ($previousExam) {
            foreach ($allExams as $resultsData) {
                if (($resultsData->re_studK == $studKey) && ($resultsData->re_exam == $previousExam->exam_key)) {
                    $examData = $resultsData;
                }
            }
        }

        return $examData;
    }

    public function sch_results()
    {
        $allResults = [];
        $resultsModel = new ResultModel;
        $allResults = $resultsModel->where(["sch_token" => $this->schoolToken]);
        return $allResults;
    }

    public function get_res_rec($exam, $class)
    {
        $getAnalysisInfo = [];
        $allResults = $this->sch_results();
        // switch on classes==============================
        if (is_numeric($class)) {
            $getDataClNum = $class;
            $getAnalysisInfo['classStream'] = "";
        } else {
            $classArr = explode("-", $class);
            $getDataClNum = $classArr[0];
            $getAnalysisInfo['classStream'] = $classArr[1];
        }
        // Important headers==============================
        $examInfo = $this->examInfo($exam);
        $termInfo = $this->termInfo($examInfo->exam_term);
        $getAnalysisInfo['resClass'] = $getDataClNum;
        $getAnalysisInfo['resExam'] = $exam;
        $getAnalysisInfo['resTermKey'] = $termInfo->term_key;
        $getAnalysisInfo['resTerm'] = $termInfo->term;
        $getAnalysisInfo['resFullClass'] = $getDataClNum . " " . $getAnalysisInfo['classStream'];
        $getAnalysisInfo['resExamName'] = $examInfo->exam;
        $getAnalysisInfo['resExamPeriod'] = date("M, Y", strtotime($termInfo->date));
        $getAnalysisInfo['resHeading'] = "form " . $getAnalysisInfo['resFullClass'] . " term " . $getAnalysisInfo['resTerm'] . " - " . $getAnalysisInfo['resExamPeriod'] . " " . $getAnalysisInfo['resExamName'] . " exam";
        $classInfo = $this->classInfo($class);
        $getAnalysisInfo['classStreamData'] = [];
        foreach ($classInfo as $streamInfo) {
            $getAnalysisInfo['classStreamData'] = $streamInfo['streams'];
        }
        // Filter information
        $getAnalysisInfo['results'] = [];
        if ($allResults) {
            foreach ($allResults as $resultsRec) {
                if (($resultsRec->re_exam == $exam) && ($resultsRec->re_studF == $getDataClNum)) {
                    $getAnalysisInfo['results'][$resultsRec->re_studK] = $resultsRec;
                }
            }
        }

        return $getAnalysisInfo;
    }

    public function shortResAnalysis($exam, $class)
    {
        $shortAnalysis = [];
        $generalRecords = $this->get_res_rec($exam, $class);
        if ($generalRecords['results']) {
            $shortAnalysis['resFCount'] = 0;
            $shortAnalysis['resFTTMarks'] = 0;
            $shortAnalysis['resFTTPnts'] = 0;
            $shortAnalysis['resFTTMMark'] = 0;
            $shortAnalysis['resFTTMpnts'] = 0;
            $shortAnalysis['resFAvgMark'] = 0;
            $shortAnalysis['resFAvgPnts'] = 0;
            foreach ($generalRecords['results'] as $key => $resFData) {
                $shortAnalysis['resFCount'] += 1;
                $shortAnalysis['resFTTMarks'] += $resFData->re_tt;
                $shortAnalysis['resFTTPnts'] += $resFData->re_pnt;
                $shortAnalysis['resFTTMMark'] += $resFData->re_mean;
                $shortAnalysis['resFTTMpnts'] += $resFData->re_avgpnt;
            }
            $shortAnalysis['resFAvgMark'] = $shortAnalysis['resFTTMMark'] / $shortAnalysis['resFCount'];
            $shortAnalysis['resFAvgPnts'] = $shortAnalysis['resFTTMpnts'] / $shortAnalysis['resFCount'];
            $shortAnalysis['resFAvgGrade'] = $this->res_final($shortAnalysis['resFAvgPnts'])['grade'];
        } else {
            $shortAnalysis['notFound'] = "There are no records found for the requested class / form view";
        }

        $finalShortAnalysis = array_merge($shortAnalysis, $generalRecords);

        return $finalShortAnalysis;
    }

    public function mainAnalysis($exam, $class)
    {
        $finalMainAnalysis = [];
        // streams
        $classInfo = $this->classInfo($class);
        foreach ($classInfo as $streamInfo) {
            $classStreamData = $streamInfo['streams'];
        }
        $shortAnalysis = $this->shortResAnalysis($exam, $class);
        $generalRecords = $this->get_res_rec($exam, $class);
        $generalRecords = array_slice($generalRecords, -1);
        // Streams Data
        $streamsData['streamsData'] = [];
        foreach ($classStreamData as $stream => $streamData) {
            $resStrcount = 0;
            $resStrTTMarks = 0;
            $resStrTTPnts = 0;
            $resStrMMark = 0;
            $resStrMPnts = 0;
            foreach ($generalRecords['results'] as $resStrData) {
                if ($stream == $resStrData->re_studS) {
                    $resStrcount += 1;
                    $resStrTTMarks += $resStrData->re_tt;
                    $resStrTTPnts += $resStrData->re_pnt;
                    $resStrMMark += $resStrData->re_mean;
                    $resStrMPnts += $resStrData->re_avgpnt;
                }
            }
            if ($resStrcount > 0) {
                $streamsData['streamsData'][$stream] = array(
                    "resStrcount" => $resStrcount,
                    "resStrTTMarks" => $resStrTTMarks,
                    "resStrTTPnts" => $resStrTTPnts,
                    "resStrMMark" => $resStrMMark / $resStrcount,
                    "resStrMPnts" => $resStrMPnts / $resStrcount
                );
            }
        }
        // ==========================class subjects performance analysis
        $subjectsAnalysis['subjectsData'] = [];
        $schoolSubjects = $this->sch_subjects();
        foreach ($schoolSubjects as $singSub) {
            $thisSubInfo = $this->subInfo($singSub->sch_sub_code);
            $subGetColumn = "re_s" . $thisSubInfo->sub_code;
            $subStudC = 0;
            $submmarks = 0;
            $subavgpoints = 0;
            foreach ($generalRecords['results'] as $results) {
                if ($results->$subGetColumn > 0) {
                    $subScoreInfo = $this->get_sub_data($thisSubInfo->sub_code, $results->$subGetColumn);
                    $subStudC += 1;
                    $submmarks += $results->$subGetColumn;
                    $subavgpoints += $subScoreInfo['points'];
                }
            }
            if ($subStudC > 0) {
                $finalGrade = $this->res_final($subavgpoints / $subStudC);
                $subjectsAnalysis['subjectsData'][$thisSubInfo->sub_name] = array(
                    "subMarks" => $submmarks,
                    "subMeanMarks" => round($submmarks / $subStudC, 4),
                    "subMeanPoints" => round($subavgpoints / $subStudC, 4),
                    "subGrade" => $finalGrade['grade']
                );
            } else {
                $subjectsAnalysis['subjectsData'][$thisSubInfo->sub_name] = array(
                    "subMarks" => "-", "subMeanMarks" => "-", "subMeanPoints" => "-", "subGrade" => "-"
                );
            }
        }
        // ===============Grades distribution
        $gradesDistData['gradesDistr'] = [];
        $tempGradeDistr = [];
        foreach ($classInfo as $grdClass => $grdClassData) {
            $entries = 0;
            $ttmmark = 0;
            $ttmpoints = 0;
            $allGrades = [];
            foreach ($generalRecords['results'] as $results) {
                if ($results->re_studF == $grdClass) {
                    $entries += 1;
                    $ttmmark += $results->re_mean;
                    $ttmpoints += $results->re_avgpnt;
                    $ttmGrade = $this->res_final($ttmpoints / $entries);
                    $allGrades[] = $results->re_grade;
                    $classTeacher = "--";
                    $clTeacherData = $this->getClassTeacher($results->re_studF, $results->re_studS);
                    if ($clTeacherData) {
                        $classTeacher = $clTeacherData->user_fname . " " . $clTeacherData->user_lname;
                    }
                    foreach (DEFAULTGRADES as $grade => $value) {
                        $keysArray[$grade] = 0;
                        if (in_array($grade, $allGrades)) {
                            $keysArray[$grade] = array_count_values($allGrades)[$grade];
                        }
                    }
                    $keysArray['entries'] = $entries;
                    $keysArray['mMarks'] = $ttmmark / $entries;
                    $keysArray['mPoints'] = $ttmpoints / $entries;
                    $keysArray['grade'] = $ttmGrade['grade'];
                    $keysArray['cTeacher'] = $classTeacher;
                    // final overall class grade distr array
                    $tempGradeDistr[$grdClass] = $keysArray;
                }
            }
            // streams based
            foreach ($classStreamData as $stream => $streamData) {
                $entries = 0;
                $sttmmark = 0;
                $sttmpoints = 0;
                $allGrades = [];
                foreach ($generalRecords['results'] as $results) {
                    if (($results->re_studF == $grdClass) && ($results->re_studS == $stream)) {
                        $entries += 1;
                        $sttmmark += $results->re_mean;
                        $sttmpoints += $results->re_avgpnt;
                        $sttmGrade = $this->res_final($sttmpoints / $entries);
                        $allGrades[] = $results->re_grade;
                        $classTeacher = "--";
                        $clTeacherData = $this->getClassTeacher($results->re_studF, $results->re_studS);
                        if ($clTeacherData) {
                            $classTeacher = $clTeacherData->user_fname . " " . $clTeacherData->user_lname;
                        }
                        foreach (DEFAULTGRADES as $grade => $value) {
                            $keysArray[$grade] = 0;
                            if (in_array($grade, $allGrades)) {
                                $keysArray[$grade] = array_count_values($allGrades)[$grade];
                            }
                        }
                        $keysArray['entries'] = $entries;
                        $keysArray['mMarks'] = $sttmmark / $entries;
                        $keysArray['mPoints'] = $sttmpoints / $entries;
                        $keysArray['grade'] = $sttmGrade['grade'];
                        $keysArray['cTeacher'] = $classTeacher;
                        // final overall class streams grade distr array
                        $tempGradeDistr[$grdClass . " " . $stream] = $keysArray;
                    }
                }
            }
        }
        // fina general class overall grade distribution
        $gradesDistData['gradesDistr']['overall'] = $tempGradeDistr;
        // subject based
        foreach ($schoolSubjects as $singSub) {
            $thisSubInfo = $this->subInfo($singSub->sch_sub_code);
            $subGetColumn = "re_s" . $thisSubInfo->sub_code;
            foreach ($classInfo as $grdClass => $grdClassData) {
                $entries = 0;
                $ttSubMarks = 0;
                $ttSubPoints = 0;
                $allGrades = [];
                foreach ($generalRecords['results'] as $results) {
                    if ($results->re_studF == $grdClass) {
                        if ($results->$subGetColumn > 0) {
                            $entries += 1;
                            $ttSubMarks += $results->$subGetColumn;
                            $subInfoScores = $this->get_sub_data($thisSubInfo->sub_code, $results->$subGetColumn);
                            $ttSubPoints += $subInfoScores['points'];
                            $ttSubGrade = $this->res_final($ttSubPoints / $entries);
                            $allGrades[] = $subInfoScores['grade'];
                            $subTeacher = $this->subTeacher($results->re_studF, "", $thisSubInfo->sub_code);
                            if (empty($subTeacher['teacherName'])) {
                                $formSubTeacher = "--";
                            } else {
                                $formSubTeacher = $subTeacher['teacherName'];
                            }
                            foreach (DEFAULTGRADES as $grade => $value) {
                                $keysArray[$grade] = 0;
                                if (in_array($grade, $allGrades)) {
                                    $keysArray[$grade] = array_count_values($allGrades)[$grade];
                                }
                            }
                            $keysArray['entries'] = $entries;
                            $keysArray['mMarks'] = $ttSubMarks / $entries;
                            $keysArray['mPoints'] = $ttSubPoints / $entries;
                            $keysArray['grade'] = $ttSubGrade['grade'];
                            $keysArray['cTeacher'] = $formSubTeacher;
                            // final overall class grade distr array
                            $tempGradeDistr[$grdClass] = $keysArray;
                        }
                    }
                }
                // streams based
                foreach ($classStreamData as $stream => $streamData) {
                    $entries = 0;
                    $ttsSubMarks = 0;
                    $ttsSubPoints = 0;
                    $allGrades = [];
                    foreach ($generalRecords['results'] as $results) {
                        if (($results->re_studF == $grdClass) && ($results->re_studS == $stream)) {
                            if ($results->$subGetColumn > 0) {
                                $entries += 1;
                                $ttsSubMarks += $results->$subGetColumn;
                                $subInfoScores = $this->get_sub_data($thisSubInfo->sub_code, $results->$subGetColumn);
                                $ttsSubPoints += $subInfoScores['points'];
                                $ttsSubGrade = $this->res_final($ttsSubPoints / $entries);
                                $allGrades[] = $subInfoScores['grade'];
                                $subTeacher = $this->subTeacher($results->re_studF, $results->re_studS, $thisSubInfo->sub_code);
                                if (empty($subTeacher['teacherName'])) {
                                    $streamSubTeacher = "--";
                                } else {
                                    $streamSubTeacher = $subTeacher['teacherName'];
                                }
                                foreach (DEFAULTGRADES as $grade => $value) {
                                    $keysArray[$grade] = 0;
                                    if (in_array($grade, $allGrades)) {
                                        $keysArray[$grade] = array_count_values($allGrades)[$grade];
                                    }
                                }
                                $keysArray['entries'] = $entries;
                                $keysArray['mMarks'] = $ttsSubMarks / $entries;
                                $keysArray['mPoints'] = $ttsSubPoints / $entries;
                                $keysArray['grade'] = $ttsSubGrade['grade'];
                                $keysArray['cTeacher'] = $streamSubTeacher;
                                // final overall class streams grade distr array
                                $tempGradeDistr[$grdClass . " " . $stream] = $keysArray;
                            }
                        }
                    }
                }
            }
            // fina general class overall grade distribution
            $gradesDistData['gradesDistr'][$thisSubInfo->sub_name] = $tempGradeDistr;
        }

        // Final array merge
        $finalMainAnalysis = array_merge($shortAnalysis, $streamsData, $subjectsAnalysis, $gradesDistData);

        return $finalMainAnalysis;
    }

    public function meritListData($exam, $class)
    {
        $generalRecords = $this->get_res_rec($exam, $class);
        $shortAnalysis = $this->shortResAnalysis($exam, $class);
        $schoolSubjects = $this->sch_subjects();
        $allStudents = $this->sch_students();
        $schoolSubsData['schSubCount'] = 0;
        $schoolSubsData['schoolSubjects'] = [];
        $meritData['meritData'] = [];
        $meritData['allFormData'] = [];
        $resTemp = [];
        $meritRecCount = 0;
        // subjects
        foreach ($schoolSubjects as $subject) {
            $schoolSubsData['schSubCount'] += 1;
            $schoolSubsData['schoolSubjects'][] = $this->subInfo($subject->sch_sub_code);
        }
        // switch merit class
        if (is_numeric($class)) {
            $meritRecCount = 1;
            $meritRecords = $generalRecords['results'];
        } else {
            foreach ($generalRecords['results'] as $initialRec) {
                if ($initialRec->re_studS == $generalRecords['classStream']) {
                    $meritRecCount += 1;
                    $meritRecords[] = $initialRec;
                }
            }
        }
        // prepare merit data
        if ($meritRecCount > 0) {
            $meritData['allFormData'] = objectToArray($generalRecords['results']);
            $arrayColumn = array_column($meritRecords, "re_fRank");
            array_multisort($arrayColumn, SORT_ASC, $meritRecords);
            foreach ($meritRecords as $meritResRec) {
                foreach ($allStudents as $studRec) {
                    if ($studRec->stud_key == $meritResRec->re_studK) {
                        $rankData = outOf($meritData['allFormData'], $meritResRec->re_studF, $meritResRec->re_studS, "re_tt");
                        $kcpeMarks = $studRec->stud_kcpe_marks;
                        if ($kcpeMarks > 0) {
                            $kcpeMean = ($studRec->stud_kcpe_marks / 5);
                            $kcpeGrade = $this->get_sub_data("kcpe", $kcpeMean)['grade'];
                            $kcpeData = $studRec->stud_kcpe_marks . " " . $kcpeGrade;
                        } else {
                            $kcpeData = "--";
                        }
                        if (empty($meritResRec->re_fRank)) {
                            $fRank = "--";
                        } else {
                            $fRank = $meritResRec->re_fRank;
                        }
                        if (empty($meritResRec->re_sRank)) {
                            $sRank = "--";
                        } else {
                            $sRank = $meritResRec->re_sRank;
                        }
                        $resTemp['re_key'] = $meritResRec->re_key;
                        $resTemp['re_adm'] = $studRec->stud_adm;
                        $resTemp['re_phone'] = $studRec->stud_phone;
                        $resTemp['re_lname'] = strtoupper($studRec->stud_lname);
                        $resTemp['re_name'] = $studRec->stud_fname . " " . $studRec->stud_oname;
                        $resTemp['re_class'] = $meritResRec->re_studF . " " . $meritResRec->re_studS;
                        $resTemp['re_kcpe'] = $kcpeData;
                        // subjects loop
                        foreach ($schoolSubjects as $subject) {
                            $thisSubInfo = $this->subInfo($subject->sch_sub_code);
                            $subGetColumn = "re_s" . $thisSubInfo->sub_code;
                            $subScore = $meritResRec->$subGetColumn;
                            if ($subScore > 0) {
                                $resTemp[$subGetColumn] = $subScore;
                            } else {
                                $resTemp[$subGetColumn] = "--";
                            }
                        }
                        // end subjects loop
                        $resTemp['re_subC'] = $meritResRec->re_subC;
                        $resTemp['re_marks'] = $meritResRec->re_tt;
                        $resTemp['re_avgmarks'] = $meritResRec->re_mean;
                        $resTemp['re_pnt'] = $meritResRec->re_pnt;
                        $resTemp['re_avgpnt'] = $meritResRec->re_avgpnt;
                        $resTemp['re_grade'] = $meritResRec->re_grade;
                        $resTemp['re_srank'] = $sRank . "/" . $rankData['streamCount'];
                        $resTemp['re_frank'] = $fRank . "/" . $rankData['formCount'];
                        $resTemp['re_dev'] = "";
                        // Combine the data
                        $meritData['meritData'][$studRec->stud_key] = $resTemp;
                    }
                }
            }
        } else {
            $meritData['notFound'] = "There are no records found matching your search query, Kindly try again!";
        }

        // Final array merge
        $finalMeritData = array_merge($shortAnalysis, $schoolSubsData, $meritData);

        return $finalMeritData;
    }

    public function pdfMeritData($exam, $class)
    {
        $finalPdfMeritData = [];
        $meritData = $this->meritListData($exam, $class);
        $gradeDistrData = $this->mainAnalysis($exam, $class);

        $finalPdfMeritData = array_merge($meritData, $gradeDistrData);

        return $finalPdfMeritData;
    }

    public function results_analysis($exam, $class, $methodTrigger = "")
    {
        $data = [];
        if (!(empty($methodTrigger))) {
            $prevExamData = $this->prev_exam($exam);
            if ($prevExamData) {
                $data['previousExam'] = $this->$methodTrigger($prevExamData->exam_key, $class);
            }
        }
        $data['currentExam'] = $this->$methodTrigger($exam, $class);

        return $data;
    }
}

$app = new App;
