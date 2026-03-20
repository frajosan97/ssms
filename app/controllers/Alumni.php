<?php

/**
 * Alumni controller
 */

class Alumni
{
    use Controller;

    public function index($page = "")
    {
        $data = [];
        if (!empty($page)) {
            if (DPAGES) :
                foreach (DPAGES as $key => $value) {
                    if ($value->page_key == $page) {
                        $data['page'] = $value;
                    }
                }
            endif;
        }
        $this->view('Alumni', $data, __FUNCTION__);
    }

    public function create()
    {
        if (!($_SERVER['REQUEST_METHOD'] == "POST")) {
            $data = [];
            $this->view('Alumni', $data, __FUNCTION__);
        } else {
            $DynamicPagesModel = new DynamicPagesModel;
            if ($DynamicPagesModel->validate($_POST)) {
                $postData['page_key'] = rawSmartKey($_POST['page_sub_title']);
                $postData['sch_token'] = APPINFO->sch_token;
                foreach ($_POST as $key => $value) {
                    $postData[$key] = $value;
                }
                if (!($DynamicPagesModel->insert($postData))) {
                    $DynamicPagesModel->errors[] = "Page created successfully";
                } else {
                    $DynamicPagesModel->errors[] = "Error saving the page";
                }
            }
            echo implode("<br>", $DynamicPagesModel->errors);
        }
    }

    public function login()
    {
        if (!($_SERVER['REQUEST_METHOD'] == "POST")) {
            $data = [];
            $this->view('Alumni', $data, __FUNCTION__);
        } else {
            $AlumniModel = new AlumniModel;
            $alumniInfo = $AlumniModel->fetch(["sch_token" => APPINFO->sch_token, "al_email" => $_POST['email'], "al_password" => hashKey($_POST['password'])]);
            if ($alumniInfo) {
                $_SESSION['ALUMNI'] = $alumniInfo;
                echo "Logged in successfully!";
            } else {
                echo "Incorrect email or password!";
            }
        }
    }

    public function register($al_key = "")
    {
        if (!($_SERVER['REQUEST_METHOD'] == "POST")) {
            $data = [];
            $data['al_key'] = $al_key;
            $this->view('Alumni', $data, __FUNCTION__);
        } else {
            $AlumniModel = new AlumniModel;
            if (!($AlumniModel->update($_POST['al_key'], ["al_email" => $_POST['email']], "al_key"))) {
                echo "Account created successfully!";
            } else {
                echo "Error creating alumni account!";
            }
        }
    }

    public function account()
    {
        $data = [];
        $this->view('Alumni', $data, __FUNCTION__);
    }
}
