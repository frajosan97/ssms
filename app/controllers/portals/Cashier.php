<?php

/**
 * Cashier controller
 */

class Cashier
{
    use Controller;

    public function index($studKey = "")
    {
        $data = [];
        $appData = new App;
        $allVoteHeads = $appData->sch_fin_votes();
        $data['students'] = $appData->sch_students();
        if (!(empty($studKey))) {
            $studInfo = $appData->studentInfo($studKey);
            if (count($studInfo) > 0) {
                // student profile
                $data['profile'] = $studInfo['profile'];
                $data['heading'] = strtoupper("[" . $data['profile']->stud_adm . "] " . $data['profile']->stud_lname . " " . $data['profile']->stud_fname . " " . $data['profile']->stud_oname);
                // important initializations
                $ttBilled = 0;
                $ttPaid = 0;
                $arrTtBilled = 0;
                $arrTtPaid = 0;
                $arreas = 0;
                $pre_arreas = 0;
                $arreasClered = 0;
                $payVotes = [];
                $allPayVotes = [];
                $data['fi_key'] = "";
                // looping the data
                foreach ($studInfo['finance'] as $finance) {
                    if ($finance->fi_type == "post") {
                        $ttBilled += $finance->fi_amnt;
                        if ($finance->fi_termK == RECENTTERM->term_key) {
                            $data['fi_key'] = $finance->fi_key;
                        }
                    } else {
                        $ttPaid += $finance->fi_amnt;
                        if ($finance->fi_termK == RECENTTERM->term_key) {
                            $payVotes[$finance->fi_key] = $appData->finRecPayVotes($finance->fi_key);
                        }
                        $allPayVotes[$finance->fi_key] = $appData->finRecPayVotes($finance->fi_key);
                    }
                    // get amount in arreas
                    if (CURRENTTERM) {
                        if (!($finance->fi_termK == CURRENTTERM->term_key)) {
                            if ($finance->fi_type == "post") {
                                $arrTtBilled += $finance->fi_amnt;
                            } else {
                                $arrTtPaid += $finance->fi_amnt;
                            }
                        }
                        $pre_arreas = $arrTtBilled - $arrTtPaid;
                    } else {
                        $pre_arreas = $ttBilled - $ttPaid;
                    }
                }
                foreach ($allPayVotes as $arrDetectKey => $arrDetectValue) {
                    foreach ($arrDetectValue as $arrDetectKey2 => $arrDetectValue2) {
                        if ($arrDetectKey2 == ARREASKEY) {
                            $arreasClered += $arrDetectValue2->amount;
                        }
                    }
                }
                // final arreas amount
                $arreas = $pre_arreas - $arreasClered;
                // final analysis
                $data['feeAnalysis'] = array("ttBilled" => $ttBilled, "ttPaid" => $ttPaid, "ttBalance" => $ttBilled - $ttPaid);
                // vote heads distribution
                if ($allVoteHeads) {
                    $data['votesData'] = [];
                    if (!(empty($data['fi_key']))) {
                        foreach ($allVoteHeads as $voteHead) {
                            $voteInfo = $appData->feeVoteInfo($voteHead->vote_head_key);
                            $voteBilled = 0;
                            $votePaid = 0;
                            if (CURRENTTERM) {
                                foreach ($voteInfo['voteAmnt'] as $voteAmt) {
                                    if ((in_array($voteAmt->class, [$data['profile']->stud_form, "all"])) && ($voteAmt->term == CURRENTTERM->term) && (in_array($voteAmt->category, [$data['profile']->stud_cat, "all"]))) {
                                        $voteBilled += $voteAmt->amount;
                                        foreach ($payVotes as $votePayKey => $votePayValue) {
                                            foreach ($votePayValue as $key => $votePay) {
                                                if ($votePay->vote_head_key == $voteHead->vote_head_key) {
                                                    $votePaid += $votePay->amount;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $voteBalance = $voteBilled - $votePaid;
                            if ($voteBalance > 0) {
                                $data['votesData'][$voteHead->vote_head_key] = array("vote_head_name" => $voteHead->vote_head_name, "vote_billed" => $voteBilled, "vote_paid" => $votePaid, "vote_balance" => $voteBalance);
                            }
                        }
                    }
                    if ($arreas > 0) {
                        $data['votesData'] = array_merge(array(ARREASKEY => array("vote_head_name" => "arreas", "vote_billed" => $arreas, "vote_paid" => 0, "vote_balance" => $arreas)), $data['votesData']);
                    }
                }
            } else {
                $data['cashierError'] = "No student found matching your search request!";
            }
        } else {
            $data['emptyKey'] = "Kindly select student to receive payment from!";
        }

        $this->view('Cashier', $data, __FUNCTION__);
    }

    public function allocate($fi_key = "")
    {
        $data = [];
        $app = new App;
        $finRecInfo = $app->finRecInfo($fi_key);
        if ($finRecInfo) {
            $data['profile'] = $app->studentInfo($finRecInfo->fi_studK)['profile'];
            $finVotes = $app->finRecPayVotes($fi_key);
        }
        $this->view('Cashier', $data, __FUNCTION__);
    }

    public function collection()
    {
        $data = [];
        $app = new App;
        $allPayments = $app->sch_finance();
        if ($allPayments) {
            foreach ($allPayments as $key => $value) {
                if ($value->fi_type == "pay") {
                    $data['collection'][] = $app->payReceipt($value->fi_key);
                }
            }
        }
        $this->view('Cashier', $data, __FUNCTION__);
    }

    public function  feesPayment()
    {
        $appData = new App;
        $schToken = $appData->schoolToken;
        $financeModel = new FinanceModel;
        $finVotesPayModel = new FinVotesPayModel;
        if ($_POST['fi_amnt'] > 0) {
            if (!($financeModel->fetch(array("fi_key" => $_POST['fi_key'])))) {
                // save payment record
                $payData['sch_token'] = $schToken;
                $payData['fi_type'] = "pay";
                foreach ($_POST as $key => $value) {
                    if (!(is_array($value))) {
                        if (!(in_array($key, array("stud_adm", "stud_name", "stud_phone", "termData")))) {
                            $payData[$key] = $value;
                        }
                    }
                }
                $payData['fi_by'] = CURRENTUSER;
                // Insert
                if (!($financeModel->insert($payData))) {
                    // save payment record votes
                    $success = 0;
                    $failed = 0;
                    if (isset($_POST['voteKey'])) {
                        foreach ($_POST['voteKey'] as $key => $value) {
                            $voteAmount = $_POST['amount'][$key];
                            if ($voteAmount > 0) {
                                $voteData = array("sch_token" => $schToken, "fin_post_key" => $_POST['fin_post_key'], "fin_pay_key" => $_POST['fi_key'], "vote_head_key" => $value, "amount" => $voteAmount);
                                if (!($finVotesPayModel->insert($voteData))) {
                                    $success += 1;
                                } else {
                                    $failed += 1;
                                }
                            }
                        }
                    }
                    // get payment info
                    $payRec = $financeModel->fetch(array("fi_key" => $_POST['fi_key']));
                    if ($payRec) {
                        // send sms
                        $smsInfo = ["phone" => $_POST['stud_phone'], "message" => ucfirst(greeting_msg()) . ", we have received fees payment for " . strtoupper($_POST['stud_name']) . " of ADM No. " . $_POST['stud_adm'] . " form " . strtoupper($_POST['fi_studF'] . " " . $_POST['fi_studS']) . " term " . ($_POST['termData']) . " of sum total Ksh. " . number_format($_POST['fi_amnt'], 2) . ". REC_" . prepend($payRec->id)];
                        if (APPINFO->sch_sms_mode == 1) {
                            $appData->modemSMS($smsInfo);
                        } else {
                            $appData->apiSMS($smsInfo);
                        }
                        if (setcookie("recent_payment", $_POST['fi_key'], time() + (365 * 24 * 60 * 60), "/")) {
                            echo "Payment received successfully";
                        }
                    } else {
                        echo "Error encountered saving the payment, kindly try again!";
                    }
                } else {
                    echo "Error encountered saving the payment, kindly try again!";
                }
            } else {
                echo "Payment already exists in our database!";
            }
        } else {
            echo "You cannot submit a payment of zero(0) amount!";
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $FinanceModel = new FinanceModel;
            $FinVotesPayModel = new FinVotesPayModel;
            if (!($FinVotesPayModel->delete($_POST['fi_key'], "fin_pay_key"))) {
                if (!($FinanceModel->delete($_POST['fi_key'], "fi_key"))) {
                    echo "Payment invoice deleted successfully!";
                } else {
                    echo "Error deleting the payment";
                }
            } else {
                echo "Error deleting the payment";
            }
        }
    }
}
