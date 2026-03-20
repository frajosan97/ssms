<?php

/**
 * School controller
 */

class School
{
    use Controller;

    public function index()
    {
        $data = [];
        $appData = new App;
        $allSchools = $appData->sys_schools();
        if ($allSchools) {
            foreach ($allSchools as $school) {
                if (!($school->sch_token == "sch")) {
                    $invCount = 0;
                    $schoolData = $appData->appInfo($school->sch_token);
                    $schoolInvoices = $appData->sch_invoices($school->sch_token);
                    if ($schoolInvoices) {
                        $invCount = count($schoolInvoices);
                    }
                    $data['schools'][$school->sch_token] = array_merge(objectToArray($schoolData), array("invCount" => $invCount));
                }
            }
        }
        $this->view('School', $data, __FUNCTION__);
    }

    public function create()
    {
        if (!($_SERVER['REQUEST_METHOD'] == "POST")) {
            $data = [];
            $this->view('School', $data, __FUNCTION__);
        } else {
            $appData = new App;
            $SchoolModel = new SchoolModel;
            $SchContactModel = new SchContactModel;
            $InvoiceModel = new InvoiceModel;
            $InvoiceItemModel = new InvoiceItemModel;
            if ($SchoolModel->validate($_POST)) {
                $rawDomain = $_POST['schoolDomain'];
                if (checkdnsrr($rawDomain, 'ANY')) {
                    $schoolName = $_POST['schoolName'];
                    $schoolPhone = $_POST['schoolPhone'];
                    $schoolEmail = $_POST['schoolEmail'];
                    $schoolKey = schoolKey($rawDomain);
                    if (!($SchoolModel->fetch(["sch_token" => $schoolKey]))) {
                        if (!($SchoolModel->insert(["sch_token" => $schoolKey, "sch_domain" => $rawDomain, "sch_name" => $schoolName]))) {
                            if (!($SchContactModel->insert(["sch_token" => $schoolKey, "sch_phone" => $schoolPhone, "sch_email" => $schoolEmail]))) {
                                // create invoice
                                if (isset($_POST['invoiceItem'])) {
                                    $invoiceTotal = 0;
                                    $invoiceItem = $_POST['invoiceItem'];
                                    foreach ($_POST['invoiceSuppItem'] as $key => $value) {
                                        if (in_array($_POST['invoiceSuppItem'][$key], $invoiceItem)) {
                                            $invoiceTotal += $_POST['invoiceItemAmnt'][$key];
                                            $billData[] = ["inv_item_head" => $_POST['invoiceItemHead'][$key], "inv_item_amnt" => $_POST['invoiceItemAmnt'][$key]];
                                        }
                                    }
                                    if ($invoiceTotal > 0) {
                                        $invoiceKey = smartKey($schoolKey . " " . time());
                                        if (!($InvoiceModel->insert(["sch_token" => $schoolKey, "inv_key" => $invoiceKey, "inv_type" => "system installation", "inv_desc" => "system installation", "inv_ref" => $invoiceKey, "inv_amnt" => $invoiceTotal, "inv_exp" => $_POST['schoolNextPay'], "addby" => CURRENTUSER]))) {
                                            foreach ($billData as $billItem) {
                                                $InvoiceItemModel->insert(["sch_token" => $schoolKey, "inv_key" => $invoiceKey, "inv_item" => $billItem['inv_item_head'], "inv_item_amnt" => $billItem['inv_item_amnt'], "addby" => CURRENTUSER]);
                                            }
                                        }
                                    }
                                    // Send mail and sms alert on account creation
                                    $smsInfo = [
                                        "phone" => $schoolPhone, "email" => $schoolEmail, "subject" => strtoupper($schoolName . " account creation"),
                                        "message" => ucwords(greeting_msg()) . ", Account for " . strtoupper($schoolName) . " has been created successfully and installation billing invoice send to your email " . strtolower($schoolEmail) . ". Kindly make its payment to activate the school account."
                                    ];
                                    $appData->apiSMS($smsInfo);
                                    $appData->sendMail($smsInfo);
                                    echo "School account created successfully!";
                                } else {
                                    echo "Error encountered creating the school invoice!";
                                }
                            } else {
                                echo "Error encountered creating the school contacts!";
                            }
                        } else {
                            echo "Error encountered creating the school account!";
                        }
                    } else {
                        echo "This school is already registered in our databases!";
                    }
                } else {
                    echo $rawDomain . " is not a registered domain name!";
                }
            }
        }
    }

    public function manage($schToken)
    {
        $data = [];
        $appData = new App;
        $data['profile'] = $appData->appInfo($schToken);
        $data['invoices'] = $appData->sch_invoices($schToken);
        $this->view('School', $data, __FUNCTION__);
    }

    public function updateMode()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $appData = new App;
            $SchoolModel = new SchoolModel;
            if (md5($_POST['userPassword']) == $_SESSION[VIEWFOLDER]->user_password) {
                if (!($SchoolModel->update($_POST['actionKey'], ["sch_mode" => $_POST['actionValue']], "sch_token"))) {
                    $smsInfo = [
                        "phone" => $_POST['objectPhone'], "email" => $_POST['objectEmail'], "subject" => strtoupper($_POST['actionObject'] . " account creation"),
                        "message" => ucfirst(greeting_msg()) . ", " . strtoupper($_POST['actionObject']) . " account has been set to " . strtoupper(schMode($_POST['actionValue'])) . " mode, if you have questions on this decision kindly call 0796594366 for help."
                    ];
                    $appData->apiSMS($smsInfo);
                    $appData->sendMail($smsInfo);
                    echo strtoupper($_POST['actionObject']) . " updated successfully!";
                } else {
                    echo "Error encountered updating the school account";
                }
            } else {
                echo "The password provided is incorrect thus the operation cannot be completed!";
            }
        }
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $appData = new App;
            $SchoolModel = new SchoolModel;
            if (md5($_POST['userPassword']) == $_SESSION[VIEWFOLDER]->user_password) {
                if (!($SchoolModel->update($_POST['actionKey'], ["sch_status" => $_POST['actionValue']], "sch_token"))) {
                    $smsInfo = [
                        "phone" => $_POST['objectPhone'], "email" => $_POST['objectEmail'], "subject" => strtoupper($_POST['actionObject'] . " account creation"),
                        "message" => ucfirst(greeting_msg()) . ", " . strtoupper($_POST['actionObject']) . " account has been set to " . strtoupper(schStatus($_POST['actionValue'])) . " status, if you have questions on this decision kindly call 0796594366 for help."
                    ];
                    $appData->apiSMS($smsInfo);
                    $appData->sendMail($smsInfo);
                    echo strtoupper($_POST['actionObject']) . " updated successfully!";
                } else {
                    echo "Error encountered updating the school account";
                }
            } else {
                echo "The password provided is incorrect thus the operation cannot be completed!";
            }
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $SchoolModel = new SchoolModel;
            if (md5($_POST['userPassword']) == $_SESSION[VIEWFOLDER]->user_password) {
                echo "The action cannot be completed at the moment, kindly contact system developer for more information!";
            } else {
                echo "The password provided is incorrect thus the operation cannot be completed!";
            }
        }
    }
}
