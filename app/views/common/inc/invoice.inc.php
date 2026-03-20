<?php

switch ($fileView) {
    case "payment":
?>

        <div class="mb-3">
            <?php if (VIEWFOLDER == "admin") { ?>
                <button class="btn bg-white shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#loadPayment"><i class="fas fa-hand-holding-usd"></i> Load Payment</button>
            <?php } ?>
            <select onchange="loadPaymentData(this)" class="btn bg-white shadow-sm rounded-pill text-start">
                <option value="all">All Payments</option>
                <option value="mpesa">M-Pesa</option>
                <option value="cheque">Cheque</option>
            </select>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent">SYSTEM PAYMENTS</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover" id="dataTable1">
                        <thead class="bg-light">
                            <tr class="text-capitalize">
                                <th class="pw-2">#</th>
                                <th>Bill Ref</th>
                                <th>Pay Mode</th>
                                <th>Amount [Ksh]</th>
                                <th>Trans Ref</th>
                                <th>Loaded By</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody class="paymentData"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                loadPaymentData("all");
            });
        </script>

    <?php
        break;
    case 'print':
    ?>

        <?php if (VIEWFOLDER == "admin") : ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-1">
                    <ul class="list-group list-group-horizontal m-0 border-0 bg-light">
                        <li class="list-group-item bg-transparent border-0 p-1"><button class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i> Edit</button></li>
                        <li class="list-group-item bg-transparent border-0 p-1"><button class="btn btn-sm btn-outline-success"><i class="fas fa-envelope"></i> Email</button></li>
                        <li class="list-group-item bg-transparent border-0 p-1"><button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button></li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <iframe src="<?= ROOT . "" . VIEWFOLDER ?>/pdf/invoice/<?= $data['invoice'] ?>" class="w-100 border" style="min-height: 450px;"></iframe>
            </div>
        </div>

    <?php
        break;
    case "create":
    ?>

        <form action="" method="post">
            <div class="card border-0 shadow-sm">
                <div class="card-header">CREATE AN INVOICE</div>
                <div class="card-body">
                    <input type="hidden" name="timeStamp" value="<?= time() ?>">
                    <div class="form-group mb-3">
                        <label for="invoiceSchToken" class="form-label">Select school to create invoice for <span class='text-danger'>*</span></label>
                        <select name="invoiceSchToken" id="invoiceSchToken" class="form-control">
                            <option value="">--Select school to create invoice for--</option>
                            <?php foreach ($data['schools'] as $school) { ?>
                                <option value="<?= $school->sch_token ?>"><?= ucfirst($school->sch_name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="invoiceTitle" class="form-label">Invoice Title <span class='text-danger'>*</span></label>
                        <input type="text" name="invoiceTitle" class="form-control" placeholder="Invoice Title">
                    </div>
                    <h6 class="p-1 bg-light">Invoice Items</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered invoiceItems mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th>Description</th>
                                    <th colspan="2" class="pw-20">Amount ( Ksh )</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="invoiceItemHead[]" placeholder="Invoice Item" class="form-control" required></td>
                                    <td><input type="number" name="invoiceItemAmnt[]" placeholder="Item Amount" class="form-control" required></td>
                                    <td><button type="button" onclick="addInputRow();" class="btn btn-success"><i class="fas fa-plus-circle"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <button class="btn btn-custom float-end"><i class="fas fa-save"></i> Save Invoice</button>
                </div>
            </div>
        </form>

    <?php
        break;
    default:
    ?>

        <div class="card border-0 shadow-none mb-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-sm table-hover table-striped text-capitalize align-middle" id="dataTable1">
                        <thead class="bg-light text-nowrap">
                            <tr>
                                <th>#</th>
                                <?php if (VIEWFOLDER == "admin") : ?>
                                    <th>School</th>
                                <?php endif; ?>
                                <th>Type</th>
                                <th>Billed [Ksh]</th>
                                <th>Paid [Ksh]</th>
                                <th>Balance [Ksh]</th>
                                <th>Date Created</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['invoices'])) :
                                foreach ($data['invoices'] as $invoice) {
                                    $appData = new App;
                                    $invCalc = invCalc($invoice);
                                    $schInfo = $appData->appInfo($invoice['sch_token']);
                            ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <?php if (VIEWFOLDER == "admin") : ?>
                                            <td><a href="<?= ROOT . VIEWFOLDER . "/school/manage/" . $invoice['sch_token'] ?>"><?= ucwords($schInfo->sch_name) ?></a></td>
                                        <?php endif; ?>
                                        <td><?= ucwords($invoice['inv_type']) ?></td>
                                        <td class="text-end"><?= number_format($invCalc['invGrantTotal'], 2) ?></td>
                                        <td class="text-end"><?= number_format($invCalc['invPaid'], 2) ?></td>
                                        <td class="text-end"><?= number_format($invCalc['invBalance'], 2) ?></td>
                                        <td><?= date("d/m/Y", strtotime($invoice['date'])) ?></td>
                                        <td><?= date("d/m/Y", strtotime($invoice['inv_exp'])) ?></td>
                                        <td class="text-end"><?= invStatus($invCalc['invBalance']) ?></td>
                                        <td class="text-nowrap">
                                            <a href="<?= ROOT . "" . VIEWFOLDER ?>/Invoice/print/<?= $invoice['inv_key'] ?>" class="btn btn-sm btn-outline-custom"><i class="fas fa-print"></i> Print</a>
                                            <?php if (VIEWFOLDER == "admin") : ?>
                                                <a href="javascript.void:(0)" class="btn btn-sm btn-outline-danger" onclick="deleteInvoice('<?= $invoice['inv_key'] ?>')"><i class="fas fa-trash-alt"></i> Delete</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                            <?php }
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<?php
        break;
}
