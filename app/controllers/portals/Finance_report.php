<?php

/**
 * Finance_report controller
 */

class Finance_report
{
    use Controller;

    public function index()
    {
        $data = [];
        $this->view('Finance_report', $data, __FUNCTION__);
    }

    public function cash_book()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $app = new App;
            $reportType = cleanHtml($_POST['reportType']);
            $reportFrom = $_POST['reportFrom'];
            $reportTo = $_POST['reportTo'];
            $allFinances = $app->sch_finance();
            $sumDebit = 0;
            $sumCredit = 0;
            if ($reportFrom == $reportTo) {
                $heading = $reportType . " for the day " . date("d M, Y", strtotime($reportFrom));
            } else {
                $heading = $reportType . " for the period " . date("d M, Y", strtotime($reportFrom)) . " - " . date("d M, Y", strtotime($reportTo));
            }
            if ($allFinances) {
                foreach ($allFinances as $key => $value) {
                    if ((date("Y-m-d", strtotime($value->date)) >= $reportFrom) && (date("Y-m-d", strtotime($value->date)) <= $reportTo) && (in_array($value->fi_group, ["income"]))) {
                        $reportData[] = $value;
                    }
                }
            }
?>

            <table class="table table-bordered border-dark table-sm m-0">
                <thead>
                    <tr>
                        <th colspan="6">
                            <h5 class="m-0 text-center"><?= strtoupper($heading) ?></h5>
                        </th>
                    </tr>
                    <tr>
                        <td class="bg-light text-start" colspan="3"><strong>RECEIPTS</strong> <br> DEBIT(Dr.)</td>
                        <td class="bg-light text-end" colspan="3"><strong>PAYMENTS</strong> <br> CREDIT(Cr.)</td>
                    </tr>
                    <tr>
                        <th class="bg-light pw-10">Date</th>
                        <th class="bg-light pw-30">Particulars</th>
                        <th class="bg-light pw-10 text-nowrap">Amount (Ksh)</th>
                        <th class="bg-light pw-10">Date</th>
                        <th class="bg-light pw-30">Particulars</th>
                        <th class="bg-light pw-10 text-nowrap">Amount (Ksh)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($reportData)) { ?>
                        <?php foreach ($reportData as $key => $value) { ?>
                            <?php $sumDebit += $value->fi_amnt; ?>
                            <?php
                            $rowCount = 1;
                            $incomeInfo = $app->finRecPayVotes($value->fi_key);
                            if (count($incomeInfo) > 0)
                                $rowCount = count($incomeInfo) + 1;
                            ?>
                            <?php $studInfo = $app->studentInfo($value->fi_studK)['profile']; ?>
                            <tr>
                                <td rowspan="<?= $rowCount ?>"><?= date("d-m-Y", strtotime($value->date)) ?></td>
                                <td rowspan="<?= $rowCount ?>"><?= "Fees payment for " . $studInfo->stud_lname . " " . $studInfo->stud_fname . " " . $studInfo->stud_oname ?></td>
                                <td rowspan="<?= $rowCount ?>" class="text-end"><?= number_format($value->fi_amnt, 2) ?></td>
                                <?php if (!($rowCount > 1)) { ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                <?php } ?>
                            </tr>
                            <?php foreach ($incomeInfo as $infoKey => $infoValue) { ?>
                                <?php $sumCredit += $infoValue->amount; ?>
                                <tr>
                                    <td><?= date("d-m-Y", strtotime($infoValue->date)) ?></td>
                                    <td><?= ucfirst($infoValue->vote_head_name) ?></td>
                                    <td class="text-end"><?= number_format($infoValue->amount, 2) ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="text-center">No cash book report for the date range provided</td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <th colspan="3" class="text-end"><?= number_format($sumDebit, 2) ?></th>
                        <th colspan="3" class="text-end"><?= number_format($sumCredit, 2) ?></th>
                    </tr>
                </tfoot>
            </table>

            <?php
        } else {
            $data = [];
            $this->view('Finance_report', $data, __FUNCTION__);
        }
    }

    public function ledger()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $app = new App;
            $reportType = cleanHtml($_POST['reportType']);
            $reportFrom = $_POST['reportFrom'];
            $reportTo = $_POST['reportTo'];
            $allFinances = $app->sch_finance();
            if ($allFinances) {
                array_multisort(array_column($allFinances, "date"), $allFinances, SORT_ASC);
                $sumDebit = 0;
                $sumCredit = 0;
                $openingBalance = 0;
                if ($reportFrom == $reportTo) {
                    $heading = "general " . $reportType . " <br> Date: " . date("d M, Y", strtotime($reportFrom));
                } else {
                    $heading = "general " . $reportType . " <br> Period: " . date("d M, Y", strtotime($reportFrom)) . " - " . date("d M, Y", strtotime($reportTo));
                }
                if ($allFinances) {
                    foreach ($allFinances as $key => $value) {
                        if (date("Y-m-d", strtotime($value->date)) < $reportFrom) {
                            if ($value->fi_group == "income") {
                                $openingBalance += $value->fi_amnt;
                            } else {
                                $openingBalance -= $value->fi_amnt;
                            }
                        }
                        if ((date("Y-m-d", strtotime($value->date)) >= $reportFrom) && (date("Y-m-d", strtotime($value->date)) <= $reportTo) && (in_array($value->fi_group, ["income", "expense"]))) {
                            $reportData[] = $value;
                        }
                    }
                }
            ?>

                <table class="table table-borderless table-sm m-0">
                    <thead>
                        <tr>
                            <th colspan="6">
                                <h5 class="m-0 text-center"><?= strtoupper($heading) ?></h5>
                            </th>
                        </tr>
                        <tr>
                            <th class="bg-light pw-10">Date</th>
                            <th class="bg-light pw-30">Particulars</th>
                            <th class="bg-light pw-10 text-nowrap text-end">Debit (Dr.)</th>
                            <th class="bg-light pw-10 text-nowrap text-end">Credit (Cr.)</th>
                            <th class="bg-light pw-10 text-nowrap text-end">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($reportData)) { ?>
                            <tr>
                                <th colspan="4">Opening Balance</th>
                                <th class="text-end"><?= number_format($openingBalance, 2) ?></th>
                            </tr>
                            <?php foreach ($reportData as $key => $value) { ?>
                                <tr>
                                    <td><?= date("d-m-Y", strtotime($value->date)) ?></td>
                                    <td><?= ucwords($value->fi_desc) ?></td>
                                    <?php if ($value->fi_group == "income") { ?>
                                        <?php $openingBalance += $value->fi_amnt; ?>
                                        <?php $sumDebit += $value->fi_amnt; ?>
                                        <td class="text-end"><?= number_format($value->fi_amnt, 2) ?></td>
                                        <td class="text-end"></td>
                                    <?php } else { ?>
                                        <?php $openingBalance -= $value->fi_amnt; ?>
                                        <?php $sumCredit += $value->fi_amnt; ?>
                                        <td class="text-end"></td>
                                        <td class="text-end"><?= number_format($value->fi_amnt, 2) ?></td>
                                    <?php } ?>
                                    <td class="text-end"><?= number_format($openingBalance, 2) ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="5" class="text-center">No ledger report for the date range provided</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <th colspan="2">Total</th>
                            <th class="text-end"><?= number_format($sumDebit, 2) ?></th>
                            <th class="text-end"><?= number_format($sumCredit, 2) ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>

<?php
            }
        } else {
            $data = [];
            $this->view('Finance_report', $data, __FUNCTION__);
        }
    }

    public function trial_balance()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
        } else {
            $data = [];
            $this->view('Finance_report', $data, __FUNCTION__);
        }
    }

    public function balance_sheet()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
        } else {
            $data = [];
            $this->view('Finance_report', $data, __FUNCTION__);
        }
    }

    public function financial_statement()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
        } else {
            $data = [];
            $this->view('Finance_report', $data, __FUNCTION__);
        }
    }
}
