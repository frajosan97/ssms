<?php include_once incFile("header"); ?>

<body>

    <?php
    switch ($fileView) {
        case "expense":
            if (isset($data['expInvInfo'])) {
                $appData = new App;
                $expenseAccInfo = $appData->sch_fin_acc_votes($data['expInvInfo']->fi_acc);
    ?>

                <div class="card shadow-none border-0 bg-white rounded-0 mb-0">
                    <div class="card-body">
                        <!-- invoice heading info -->
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th class="pw-4"><img src="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>"></th>
                                <td class="text-start">
                                    <h4 class="m-0"><?= strtoupper(APPINFO->sch_name) ?></h4>
                                    <h6 class="m-0">P.O Box <?= ucwords(APPINFO->sch_address . ' - ' . APPINFO->sch_postcode . ', ' . APPINFO->sch_town) ?></h6>
                                    <h6 class="m-0">Tell: <?= smartPhone(APPINFO->sch_phone) ?></h6>
                                    <h5 class="m-0 text-danger">School Official Expense Receipt</h5>
                                </td>
                                <th class="pw-4 text-end">
                                    <span class="text-nowrap">Receipt No:</span> <button class="btn p-0 px-3 border-dotted rounded-0 bg-light text-nowrap"><b class="text-danger"><?= prepend($data['expInvInfo']->id) ?></b></button>
                                </th>
                            </tr>
                        </table>
                        <hr class="dividerDiv1" />
                        <?php if (!(isset($data['noRec']))) { ?>
                            <table class="table table-sm table-borderless align-middle">
                                <tr>
                                    <th class="pw-5 text-end p-0">Title:</th>
                                    <td><?= ucfirst($data['expInvInfo']->fi_head) ?></td>
                                </tr>
                                <tr>
                                    <th class="pw-5 text-end p-0">Description:</th>
                                    <td><?= ucfirst($data['expInvInfo']->fi_desc) ?></td>
                                </tr>
                                <tr>
                                    <td class="p-0" colspan="2"><u>Expensed From</u></td>
                                </tr>
                                <tr>
                                    <td class="px-0" colspan="2">
                                        <b>Account Name:</b> <button class="btn p-0 px-3 border-dotted rounded-0 bg-light"><?= ucfirst($expenseAccInfo['acc']->acc_name) ?></button>
                                        <b>Account Number:</b> <button class="btn p-0 px-3 border-dotted rounded-0 bg-light"><?= $expenseAccInfo['acc']->acc_number ?></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0" colspan="2">
                                        <b>The sum of:</b> <button class="btn p-0 px-3 border-dotted rounded-0 bg-light"><?= ucfirst(trim(toWords($data['expInvInfo']->fi_amnt))) ?></button>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-sm table-bordered my-2 border-dark align-middle">
                                <tr class="bg-light">
                                    <th class="p-1 pw-5">Date</th>
                                    <th class="p-1">Particulars</th>
                                    <th class="p-1 pw-20 text-nowrap text-end">Amount (Ksh)</th>
                                </tr>
                                <?php foreach ($data['expInvInfo']->expVotes as $votesPay) { ?>
                                    <tr>
                                        <td class="p-1 text-nowrap"><?= date("d-m-Y", strtotime($votesPay->date)) ?></td>
                                        <td class="p-1"><?= ucfirst($votesPay->exp_item) ?></td>
                                        <td class="p-1 text-nowrap text-end"><?= number_format($votesPay->exp_item_amnt, 2) ?></td>
                                    </tr>
                                <?php } ?>
                                <tr class="bg-light">
                                    <th class="p-1" colspan="2">TOTALS</th>
                                    <th class="p-1 text-nowrap text-end"><?= number_format($data['expInvInfo']->fi_amnt, 2) ?></th>
                                </tr>
                            </table>
                            <!-- Remarks -->
                            <table class="table table-sm table-borderless my-2 border-dark align-middle text-capitalize">
                                <tr>
                                    <td class="text-start">
                                        <h6>accounts clerk name:.............................................</h6>
                                        <h6>signature:.....................................................</h6>
                                        <h6>date:..........................................................</h6>
                                    </td>
                                    <td class="text-end">
                                        <h6>principal's name:.............................................</h6>
                                        <h6>signature:.....................................................</h6>
                                        <h6>date:..........................................................</h6>
                                    </td>
                                </tr>
                            </table>
                        <?php } else { ?>
                            <?= $data['noRec'] ?>
                        <?php } ?>
                    </div>
                </div>

            <?php
            } else {
                echo "No expense invoice is ready fpor printing!";
            }
            break;
        default:
            ?>

            <div class="card shadow-none border-0 bg-white rounded-0 mb-0">
                <div class="card-body">
                    <!-- receipt heading info -->
                    <table class="table table-sm table-borderless mb-0 align-middle">
                        <tr>
                            <th class="pw-4"><img src="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>"></th>
                            <td class="text-center">
                                <h4 class="m-0"><?= strtoupper(APPINFO->sch_name) ?></h4>
                                <h6 class="m-0">P.O Box <?= ucwords(APPINFO->sch_address . ' - ' . APPINFO->sch_postcode . ', ' . APPINFO->sch_town) ?></h6>
                                <h6 class="m-0">Tell: <?= smartPhone(APPINFO->sch_phone) ?></h6>
                                <h5 class="m-0 text-danger">School Official Receipt</h5>
                            </td>
                            <th class="pw-4"></th>
                        </tr>
                    </table>
                    <hr class="dividerDiv1" />
                    <?php if ($data['payReceipt']) { ?>
                        <!-- student info -->
                        <table class="table table-sm table-borderless align-middle">
                            <tr>
                                <td class="p-0"><b>Received From:</b> <?= ucwords($data['payReceipt']['stud_name']) ?></td>
                                <td class="p-0"><b>ADM No.:</b> <?= ucwords($data['payReceipt']['stud_adm']) ?></td>
                                <td class="p-0"><b>Form:</b> <?= ucwords($data['payReceipt']['stud_class']) ?></td>
                                <td class="p-0"><b>Term:</b> <?= ucwords($data['payReceipt']['pay_term']) ?></td>
                                <td class="p-0 text-end"><b>Rect No.:</b> <span class="text-danger"><?= prepend($data['payReceipt']['rect_no']) ?></span></td>
                            </tr>
                            <tr>
                                <td class="p-0" colspan="4"><b> The sum of:</b> <?= ucfirst(trim(toWords($data['payReceipt']['pay_amount']))) ?> shillings only.</td>
                                <td class="p-0 text-end"><b>Date:</b> <?= date("d-M-y", strtotime($data['payReceipt']['pay_date'])) ?></td>
                            </tr>
                        </table>
                        <!-- payment summary -->
                        <table class="table table-sm table-bordered my-2 border-dark align-middle">
                            <tr>
                                <td><b>Toatl Billed:</b> <?= number_format($data['payReceipt']['rect_bill_summ']['rect_bill'], 2) ?></td>
                                <td><b>Toatl Paid:</b> <?= number_format($data['payReceipt']['rect_bill_summ']['rect_paid'], 2) ?></td>
                                <td><b>Toatl Balance:</b> <?= number_format($data['payReceipt']['rect_bill_summ']['rect_bal'], 2) ?></td>
                            </tr>
                        </table>
                        <!-- vote heads info -->
                        <table class="table table-sm table-bordered my-2 border-dark align-middle">
                            <tr class="bg-light">
                                <th class="p-1 ">Vote Description</th>
                                <th class="p-1 pw-20 text-nowrap text-end">Amount (Ksh)</th>
                            </tr>
                            <?php foreach ($data['payReceipt']['receipt_votes'] as $votesPay) { ?>
                                <tr>
                                    <td class="p-1 "><?= ucfirst($votesPay->vote_head_name) ?></td>
                                    <td class="p-1 text-nowrap text-end"><?= number_format($votesPay->amount, 2) ?></td>
                                </tr>
                            <?php } ?>
                            <tr class="bg-light">
                                <th class="p-1 ">TOTALS</th>
                                <th class="p-1 text-nowrap text-end"><?= number_format($data['payReceipt']['pay_amount'], 2) ?></th>
                            </tr>
                        </table>
                        <!-- Remarks -->
                        <table class="table table-sm table-borderless my-2 border-dark align-middle">
                            <tr>
                                <td class="p-0 pw-20 text-nowrap">Payment Method: <b><u><?= ucwords($data['payReceipt']['pay_mode']) ?></u></b></td>
                                <td class="p-0 pw-20 text-nowrap">Reference: <b><u><?= ucwords($data['payReceipt']['pay_ref']) ?></u></b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center" colspan="2">
                                    <h6>Recipient signature:.....................................................</h6>
                                    <h6>Full Name:.......................................................................</h6>
                                    <small><i>Fees once paid, is non-refundable whatsoever!</i></small>
                                </td>
                            </tr>
                        </table>
                    <?php } else { ?>
                        No receipt is ready for printing
                    <?php } ?>
                </div>
            </div>

    <?php
            break;
    }
    ?>

    <script type="text/javascript">
        $(document).ready(function() {
            window.print();
            onafterprint = function() {
                history.back();
            }
        });
    </script>

    <?php include_once incFile("footer"); ?>