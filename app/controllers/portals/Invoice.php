<?php

/**
 * Invoice controller
 */

class Invoice
{
    use Controller;

    public function index($schoolKey = "")
    {
        $data = [];
        $appData = new App;
        $sysInvoices = $appData->sys_invoices();
        if ($sysInvoices) {
            if (VIEWFOLDER == "admin") {
                if (empty($schoolKey)) {
                    $data['invoices'] = $sysInvoices;
                } else {
                    $data['invoices'] = $appData->sch_invoices($schoolKey);
                }
            } else {
                $data['invoices'] = $appData->sch_invoices($appData->schoolToken);
            }
        }
        $this->view('Invoice', $data, __FUNCTION__);
    }

    public function create()
    {
        $data = [];
        $appData = new App;
        $data['schools'] = $appData->sys_schools();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $InvoiceModel = new InvoiceModel;
            $InvoiceItemModel = new InvoiceItemModel;
            if ($InvoiceModel->validate($_POST)) {
                $schToken = $_POST['invoiceSchToken'];
                $invKey = smartKey($schToken . " " . $_POST['timeStamp']);
                if (!($InvoiceModel->fetch(["inv_key" => $invKey]))) {
                    $itemData = [];
                    $invTotal = 0;
                    foreach ($_POST['invoiceItemHead'] as $key => $value) {
                        $invTotal += $_POST['invoiceItemAmnt'][$key];
                        $itemData[] = array("sch_token" => $schToken, "inv_key" => $invKey, "inv_item" => $value, "inv_item_amnt" => $_POST['invoiceItemAmnt'][$key], "addby" => CURRENTUSER);
                    }
                    if ($invTotal > 0) {
                        // add vat
                        $invAmountAddVAT = invAmountAddVAT($invTotal);
                        if (!($InvoiceModel->insert(["sch_token" => $schToken, "inv_key" => $invKey, "inv_type" => $_POST['invoiceTitle'], "inv_desc" => $_POST['invoiceTitle'], "inv_amnt" => $invTotal, "inv_exp" => date("Y-m-d"), "addby" => CURRENTUSER]))) {
                            foreach ($itemData as $key => $invItem) {
                                $InvoiceItemModel->insert($invItem);
                            }
                            $schInfo = $appData->appInfo($schToken);
                            $smsInfo = [
                                "phone" => $schInfo->sch_phone, "email" => $schInfo->sch_email, "subject" => strtoupper($_POST['invoiceTitle'] . " invoice creation"),
                                "message" => ucfirst(greeting_msg()) . ", A new invoice has been generated for your school account. Kindly login to your staff account to view and pay for the invoice: " . $invKey . ". To pay via M-Pesa use Till Number: " . TILL . ", Amount: Ksh " . number_format($invAmountAddVAT['invGrantTotal'], 2) . ". Thank you."
                            ];
                            $appData->apiSMS($smsInfo);
                            $appData->sendMail($smsInfo);
                            $_SESSION['status'] = "Invoice created successfully!";
                            $_SESSION['status_code'] = 'success';
                        } else {
                            $_SESSION['status'] = "Error encountered creating invoice";
                            $_SESSION['status_code'] = 'error';
                        }
                    } else {
                        $_SESSION['status'] = "Error encountered creating invoice";
                        $_SESSION['status_code'] = 'error';
                    }
                } else {
                    $_SESSION['status'] = "This invoice aready exists!";
                    $_SESSION['status_code'] = 'error';
                }
            } else {
                $_SESSION['status'] = implode("<br>", $InvoiceModel->errors);
                $_SESSION['status_code'] = 'error';
            }
        }
        $this->view('Invoice', $data, __FUNCTION__);
    }

    public function print($invoiceKey)
    {
        $data = [];
        $data['invoice'] = $invoiceKey;
        $this->view('Invoice', $data, __FUNCTION__);
    }

    public function payment()
    {
        $data = [];
        $appData = new App;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $PaymentModel = new PaymentModel;
            if ($PaymentModel->validate($_POST)) {
                if (!($PaymentModel->fetch(["pay_trans_code" => $_POST['pay_trans_code']]))) {
                    $payData['pay_key'] = smartKey($_POST['sch_token'] . " " . $_POST['timeStamp']);
                    foreach ($_POST as $key => $value) {
                        $payData[$key] = $value;
                    }
                    $payData['addby'] = CURRENTUSER;
                    if (!($PaymentModel->insert($payData))) {
                        $invoice = $appData->invoiceInfo($_POST['inv_key']);
                        $invCalc = invCalc($invoice);
                        $schInfo = $appData->appInfo($_POST['sch_token']);
                        if ($invCalc['invBalance'] > 0) {
                            $fixSlag = "Your invoice outstanding balance is Ksh. " . number_format($invCalc['invBalance'], 2) . ", Kindly pay to avoid system lockup. ";
                        } else {
                            $fixSlag = "";
                        }
                        $smsInfo = [
                            "phone" => $schInfo->sch_phone, "email" => $schInfo->sch_email, "subject" => strtoupper("payment confirmation"),
                            "message" => $_POST['pay_trans_code'] . " confirmed. We have received payment of Ksh. " . number_format($_POST['pay_amnt'], 2) . " for invoice: " . $_POST['inv_key'] . " on " . date("d/m/y", time()) . " at " . date("h:m A", time()) . ". " . $fixSlag . "Thank you."
                        ];
                        $appData->apiSMS($smsInfo);
                        $appData->sendMail($smsInfo);
                        echo "Payment received successfully";
                    } else {
                        echo "Error processing the payent";
                    }
                } else {
                    echo "Paymen with transaction number <b>" . $_POST['pay_trans_code'] . "</b> already exists";
                }
            } else {
                echo implode("<br>", $PaymentModel->errors);
            }
        } else {
            $this->view('Invoice', $data, __FUNCTION__);
        }
    }

    public function fetchPayment($payMode = "")
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $appData = new App;
            $paymentInfo = [];
            $allPayments = $appData->sys_payments();
            if ($allPayments) {
                if (empty($payMode) or $payMode == "all") {
                    $paymentInfo = $allPayments;
                } else {
                    foreach ($allPayments as $payment) {
                        if ($payment->pay_mode == $payMode) {
                            $paymentInfo[] = $payment;
                        }
                    }
                }
            }
            // log payments
            if (count($paymentInfo) > 0) {
                $sno = 1;
                foreach ($paymentInfo as $key => $value) {
                    $payRec = "<tr>";
                    $payRec .= "<td>" . $sno++ . "</td>";
                    $payRec .= "<td>" . $value->inv_key . "</td>";
                    $payRec .= "<td>" . $value->pay_mode . "</td>";
                    $payRec .= "<td>" . number_format($value->pay_amnt, 2) . "</td>";
                    $payRec .= "<td>" . $value->pay_trans_code . "</td>";
                    $payRec .= "<td>" . $value->addby . "</td>";
                    $payRec .= "<td>" . date("D d/m/Y h:i A", strtotime($value->date)) . "</td>";
                    $payRec .= "</tr>";
                    echo $payRec;
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No data payments made yet!</td></tr>";
            }
        }
    }

    // IMPORTANT
    public function getInvoices($schToken = "")
    {
        $appData = new App;
        $sysInvoices = $appData->sch_invoices($schToken);
        $invOpt = "<label for='inv_key' class='mb-1'>Invoice to pay for</small></label>";
        if ($sysInvoices) {
            $invOpt .= "<select name='inv_key' id='inv_key' class='form-control' onchange='getInvoiceInfo(this)' required>";
            $invOpt .= "<option value=''>--Select Invoice--</option>";
            foreach ($sysInvoices as $invoice) {
                if ($invoice['sch_token'] == $schToken) {
                    $invCalc = invCalc($invoice);
                    if ($invCalc['invBalance'] > 0) :
                        $invOpt .= "<option value='" . $invoice['inv_key'] . "'>" . ucwords($invoice['inv_type'] . " [ Balance: Ksh. " . number_format($invCalc['invBalance'], 2) . " ]") . "</option>";
                    endif;
                }
            }
            $invOpt .= "</select>";
        } else {
            $invOpt .= "<p class='m-0 p-0'>No Invoice found for this school</p>";
        }
        echo $invOpt;
    }

    public function getInvInfo($invKey = "")
    {
        $appData = new App;
        $invoice = $appData->invoiceInfo($invKey);
        if ($invoice) {
            $invCalc = invCalc($invoice);
            $invData = ["<p class='bg-light border p-1 m-0'>Total billed: Ksh. <b>" . number_format($invCalc['invGrantTotal'], 2) . "</b> Total paid: Ksh. <b>" . number_format($invCalc['invPaid'], 2) . "</b> Total balance: Ksh. <b>" . number_format($invCalc['invBalance'], 2) . "</b></p>"];
        } else {
            $invData = array("No ivoice data related to your search!");
        }
        echo implode("<br>", $invData);
    }

    public function requestLoad($loadMethod = "")
    {
        switch ($loadMethod) {
            case 'mpesa':
?>

                <h6 class="bg-success p-1 mt-2">Loading M-Pesa payment</h6>
                <div class="form-group mb-2">
                    <label for="">M-Pesa Transaction code</label>
                    <input type="text" name="pay_trans_code" placeholder="M-Pesa Transaction Code" class="form-control" oninput="validatePayment(this)" required />
                </div>
                <div class="form-group paymentReport">
                    <label for="">Enter Amount paid</label>
                    <input type="number" name="pay_amnt" placeholder="Enter Amount paid" class="form-control" required />
                </div>

            <?php
                break;
            case 'cheque':
            ?>

                <h6 class="bg-success p-1 mt-2">Loading Cheque payment</h6>
                <div class="form-group mb-2">
                    <label for="">Cheque Number</label>
                    <input type="text" name="pay_trans_code" placeholder="Cheque Number" class="form-control" oninput="validatePayment(this)">
                </div>
                <div class="form-group paymentReport">
                    <label for="">Enter Amount paid</label>
                    <input type="number" name="pay_amnt" placeholder="Enter Amount paid" class="form-control" required />
                </div>

            <?php
                break;
            default:
            ?>
                <h6 class="bg-danger p-1 mt-2">Invalid payment method selected!</h6>
<?php
                break;
        }
    }

    public function payCheck($transCode = "")
    {
        $appData = new App;
        $sysPayments = $appData->sys_payments();
        $message = [];
        foreach ($sysPayments as $payment) {
            if ($payment->pay_trans_code == $transCode) {
                $message[] = "Found: <b>" . $transCode . "</b> Ksh. <b>" . number_format($payment->pay_amnt, 2) . "</b> Date: <b>" . date("d/m/Y h:i A", strtotime($payment->date)) . "</b>";
            }
        }
        echo implode("<br>", $message);
    }

    public function delete()
    {
        $InvoiceModel = new InvoiceModel;
        $InvoiceItemModel = new InvoiceItemModel;
        if (!($InvoiceItemModel->delete($_POST['inv_key'], "inv_key"))) {
            if (!($InvoiceModel->delete($_POST['inv_key'], "inv_key"))) {
                echo "Invoice deleted successfully!";
            } else {
                echo "Error deleting the invoice";
            }
        } else {
            echo "Error deleting the invoice";
        }
    }
}
