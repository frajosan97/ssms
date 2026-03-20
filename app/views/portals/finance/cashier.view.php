<?php
switch ($fileView) {
    case "allocate":
?>

        <div class="card border-0 shadow-sm">
            <div class="card-header"><?= strtoupper("allocating fees for " . $data['profile']->stud_lname . " " . $data['profile']->stud_fname . " " . $data['profile']->stud_oname . " [" . $data['profile']->stud_adm . "]") ?></div>
            <div class="card-body">Working on it, this will be available once the content is updated</div>
        </div>

    <?php
        break;
    case "collection":
    ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header">FEES PAYMENTS INFORMATION</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover" id="dataTable1">
                        <thead class="bg-light">
                            <tr class="text-capitalize">
                                <th>Date</th>
                                <th>ADM</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Term</th>
                                <th class="pw-15">Amount [Ksh]</th>
                                <th class="pw-10">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['collection'])) : ?>
                                <?php foreach ($data['collection'] as $key => $value) { ?>
                                    <tr>
                                        <td><?= date("d-m-Y", strtotime($value['pay_date'])) ?></td>
                                        <td><?= ucwords($value['stud_adm']) ?></td>
                                        <td><?= ucwords($value['stud_name']) ?></td>
                                        <td><?= ucwords($value['stud_class']) ?></td>
                                        <td><?= ucwords($value['pay_term']) ?></td>
                                        <td><?= number_format($value['pay_amount'], 2) ?></td>
                                        <td class="text-nowrap">
                                            <a href="<?= ROOT . VIEWFOLDER ?>/printtemp/<?= $value['pay_key'] ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-print"></i> Print</a>
                                            <button onclick="deletePayment('<?= $value['pay_key'] ?>')" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php
        break;
    default:
    ?>

        <?php if (isset($data['emptyKey'])) { ?>

            <div class="card border-0 shadow-sm">
                <div class="card-header text-uppercase"><?= $data['emptyKey'] ?></div>
                <div class="card-body">
                    <select class="btn btn-sm border-custom text-start selectpicker" onchange="loadStudentInfo(this)">
                        <option value="">--Select Student--</option>
                        <?php foreach ($data['students'] as $student) { ?>
                            <option value="<?= $student->stud_key ?>"><?= ucwords("[" . $student->stud_adm . "] " . $student->stud_lname . " " . $student->stud_fname . " " . $student->stud_oname) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

        <?php } else { ?>

            <?php if (!(isset($data['noStud']))) { ?>
                <?php if (isset($data['heading'])) { ?>
                    <form class="feesPayForm">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header text-uppercase">Receiving fees payment from <strong><?= $data['heading'] ?></strong></div>
                            <div class="card-body">
                                <?php if (RECENTTERM) { ?>
                                    <blockquote class="m-0 bg-light rounded mb-3">
                                        <ul class="list-group list-group-horizontal-md">
                                            <li class="list-group-item">Total Billed: <strong>Ksh. <?= number_format($data['feeAnalysis']['ttBilled'], 2) ?></strong></li>
                                            <li class="list-group-item">Total Paid: <strong>Ksh. <?= number_format($data['feeAnalysis']['ttPaid'], 2) ?></strong></li>
                                            <li class="list-group-item">Total Balance: <strong>Ksh. <?= number_format($data['feeAnalysis']['ttBalance'], 2) ?></strong></li>
                                        </ul>
                                    </blockquote>
                                    <!-- required inputs -->
                                    <input type="hidden" name="fin_post_key" value="<?= $data['fi_key'] ?>" />
                                    <input type="hidden" name="fi_key" value="<?= strtoupper($data['fi_key'] . "_pay_" . time()) ?>" />
                                    <input type="hidden" name="fi_studK" value="<?= $data['profile']->stud_key ?>" />
                                    <input type="hidden" name="stud_phone" value="<?= $data['profile']->stud_phone ?>" />
                                    <input type="hidden" name="stud_adm" value="<?= $data['profile']->stud_adm ?>" />
                                    <input type="hidden" name="stud_name" value="<?= $data['profile']->stud_lname . " " . $data['profile']->stud_fname . " " . $data['profile']->stud_oname ?>" />
                                    <input type="hidden" name="fi_cat" value="<?= $data['profile']->stud_cat ?>" />
                                    <div class="table-responsive">
                                        <table class="table table-sm table-light table-bordered align-middle text-uppercase">
                                            <tr>
                                                <th class="pw-10">Form:</th>
                                                <td><input type="number" name="fi_studF" value="<?= $data['profile']->stud_form ?>" placeholder="Form/Class" class="form-control form-control-sm rounded-0" readonly /></td>
                                                <th class="pw-10">Stream:</th>
                                                <td><input type="text" name="fi_studS" value="<?= $data['profile']->stud_stream ?>" placeholder="Stream" class="form-control form-control-sm rounded-0" readonly /></td>
                                                <th class="pw-10">Term:</th>
                                                <td>
                                                    <input type="hidden" name="fi_termK" value="<?= RECENTTERM->term_key ?>" />
                                                    <input type="text" name="termData" value="<?= RECENTTERM->term . ", " . date("Y", strtotime(RECENTTERM->start_date)) ?>" placeholder="Term" class="form-control form-control-sm rounded-0" readonly />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Pay Mode:</th>
                                                <td>
                                                    <select name="fi_payM" onchange="getInput(this)" class="form-control form-control-sm rounded-0 text-capitalize" required>
                                                        <option value="">--Select mode of payment--</option>
                                                        <?php foreach (PAYMODES as $key => $value) { ?>
                                                            <option value="<?= $key ?>"><?= $value[0] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td colspan="4" class="fi_ref"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="form-group">
                                                        <textarea name="fi_desc" placeholder="Description (Optional)" rows="1" class="form-control form-control-sm rounded-0"></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table table-sm table-bordered align-middle mb-0">
                                            <thead class="bg-light text-uppercase">
                                                <tr>
                                                    <th>Vote Head</th>
                                                    <th class="pw-15">Billed</th>
                                                    <th class="pw-15">Paid</th>
                                                    <th class="pw-15">Balance</th>
                                                    <th class="pw-20">Amount (Ksh)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (isset($data['votesData'])) { ?>
                                                    <?php foreach ($data['votesData'] as $voteKey => $voteValue) { ?>
                                                        <tr>
                                                            <input type="hidden" name="voteKey[]" value="<?= $voteKey ?>" />
                                                            <td><?= ucfirst($voteValue['vote_head_name']) ?></td>
                                                            <td><?= number_format($voteValue['vote_billed'], 2) ?></td>
                                                            <td><?= number_format($voteValue['vote_paid'], 2) ?></td>
                                                            <td><?= number_format($voteValue['vote_balance'], 2) ?></td>
                                                            <td><input name="amount[]" value="" id="<?= $voteKey ?>" placeholder="Amount" class="form-control form-control-sm rounded-0" oninput="postAmountFees(<?= $voteValue['vote_balance'] ?>,'<?= $voteKey ?>')" /></td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td class="text-center" colspan="5">No vote heads records found to receive payments for!</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot class="bg-light">
                                                <tr>
                                                    <th colspan="4">TOTALS</th>
                                                    <th class="text-end"><input type="number" name="fi_amnt" placeholder="Total Amount Paid" class="form-control form-control-sm rounded-0"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                            </div>
                            <div class="card-footer border-0 bg-transparent mb-2">
                                <button type="reset" class="btn btn-outline-danger float-start"><i class="fas fa-undo"></i> Reset Inputs</button>
                                <button type="submit" class="btn btn-outline-custom float-end"><i class="fas fa-save"></i> Save Payment</button>
                            </div>
                        <?php } else { ?>
                            <p class="p-0 m-0 text-danger">
                                There is no Active or Recent exam ready to receive payments for, Kindly create term to open funds receivable!
                            </p>
                        <?php } ?>
                        </div>
                    </form>

                    <script>
                        function getInput(input) {
                            var input = input.value;
                            if (input.length > 0) {
                                <?php foreach (PAYMODES as $key => $value) { ?>
                                    if (input === "<?= $key ?>") {
                                        $(".fi_ref").html("<input type='text' name='fi_ref' placeholder='<?= $value[1] ?>' class='form-control form-control-sm rounded-0' />");
                                    }
                                <?php } ?>
                            } else {
                                $(".fi_ref").html();
                            }
                        }
                    </script>

                <?php } else { ?>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-danger text-uppercase">Invalid access</div>
                    </div>

                <?php } ?>
            <?php } else { ?>

                <div class="card border-0 shadow-sm">
                    <div class="card-body text-danger text-uppercase"><?= $data['noStud'] ?></div>
                </div>

            <?php } ?>
        <?php } ?>

<?php
        break;
}
