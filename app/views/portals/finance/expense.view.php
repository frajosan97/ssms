<?php

switch ($fileView) {
    case 'create':

?>
        <form class="addExpenseForm">
            <div class="card border-0 shadow-sm">
                <div class="card-header">CREATE AN EXPENSE INVOICE</div>
                <div class="card-body">
                    <input type="hidden" name="fi_key" value="<?= strtoupper(smartKey(APPINFO->sch_token . " " . time() . " expense")) ?>">
                    <input type="hidden" name="fi_type" value="expense">
                    <input type="hidden" name="fi_termK" value="<?= CURRENTTERM->term_key ?>">
                    <input type="hidden" name="fi_key" value="<?= strtoupper(smartKey(APPINFO->sch_token . " " . time() . " expense")) ?>">
                    <div class="form-group mb-2">
                        <label for="fi_acc">Account to expense from</label>
                        <select name="fi_acc" id="fi_acc" class="form-control form-control-sm">
                            <option value="">--Select school account to exepnse from--</option>
                            <?php if (ACCOUNTS) : ?>
                                <?php foreach (ACCOUNTS as $key => $value) { ?>
                                    <option value="<?= $value->acc_key ?>"><?= ucwords($value->acc_name . " - " . $value->acc_number) ?></option>
                                <?php } ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="fi_head">Expense Heading</label>
                        <input type="text" name="fi_head" id="fi_head" placeholder="Expense Description" class="form-control form-control-sm" />
                    </div>
                    <div class="form-group mb-2">
                        <label for="fi_desc">Expense Description(Optional)</label>
                        <textarea name="fi_desc" id="fi_desc" rows="2" placeholder="Expense Description(Optional)" class="form-control form-control-sm"></textarea>
                    </div>
                    <!-- Expense items -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="">Item</th>
                                    <th class="pw-20">Amount</th>
                                    <th class="pw-10"></th>
                                </tr>
                            </thead>
                            <tbody class="expenseRows">
                                <tr>
                                    <td><input type="text" name="exp_item[]" placeholder="Item" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="exp_amnt[]" placeholder="Amount (Ksh)" class="form-control form-control-sm" oninput="postAmountExp()"></td>
                                    <td><span class="btn btn-sm w-100 text-nowrap btn-success" onclick="addRow()"><i class="fas fa-plus-circle"></i> Add Row</span></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>TOTALS</th>
                                    <th colspan="2"><input type="number" name="fi_amnt" placeholder="Total Amount (Ksh)" value="0" class="form-control form-control-sm"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer border-0 bg-transparent pb-3">
                    <button type="reset" class="btn btn-outline-danger"><i class="fas fa-refresh"></i> Reset Inputs</button>
                    <button type="submit" class="btn btn-custom border-0 float-end"><i class="fas fa-save"></i> Add Expense</button>
                </div>
            </div>
        </form>

    <?php

        break;
    case "update":
    ?>

        <?php if (isset($data['expenseInfo'])) { ?>
            <form class="updateExpenseForm">
                <div class="card border-0 shadow-sm">
                    <div class="card-header"><?= strtoupper($data['expenseInfo']->fi_head) ?></div>
                    <div class="card-body">
                        <input type="hidden" name="updateKey" value="<?= $data['expenseInfo']->fi_key ?>">
                        <div class="form-group mb-2">
                            <label for="fi_acc">Account to expense from</label>
                            <select name="fi_acc" id="fi_acc" class="form-control form-control-sm">
                                <option value="">--Select school account to exepnse from--</option>
                                <?php if (ACCOUNTS) : ?>
                                    <?php foreach (ACCOUNTS as $key => $value) { ?>
                                        <option value="<?= $value->acc_key ?>" <?php if ($value->acc_key == $data['expenseInfo']->fi_acc) : ?> selected <?php endif; ?>><?= ucwords($value->acc_name . " - " . $value->acc_number) ?></option>
                                    <?php } ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="fi_head">Expense Heading</label>
                            <input type="text" name="fi_head" value="<?= $data['expenseInfo']->fi_head ?>" id="fi_head" placeholder="Expense Description" class="form-control form-control-sm" />
                        </div>
                        <div class="form-group mb-2">
                            <label for="fi_desc">Expense Description(Optional)</label>
                            <textarea name="fi_desc" id="fi_desc" rows="2" placeholder="Expense Description(Optional)" class="form-control form-control-sm"><?= $data['expenseInfo']->fi_desc ?></textarea>
                        </div>
                        <!-- Expense items -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="">Item</th>
                                        <th class="pw-20">Amount</th>
                                        <th class="pw-10"></th>
                                    </tr>
                                </thead>
                                <tbody class="expenseRows">
                                    <?php foreach ($data['expenseInfo']->expVotes as $key => $value) { ?>
                                        <tr>
                                            <input type="hidden" name="exp_item_key[]" value="<?= $value->exp_item_key ?>">
                                            <td><input type="text" name="exp_item[]" value="<?= $value->exp_item ?>" placeholder="Item" class="form-control form-control-sm"></td>
                                            <td><input type="number" name="exp_amnt[]" value="<?= $value->exp_item_amnt ?>" placeholder="Amount (Ksh)" class="form-control form-control-sm" oninput="postAmountExp()"></td>
                                            <td><span class="btn btn-sm w-100 text-nowrap btn-success" onclick="addRow()"><i class="fas fa-plus-circle"></i> Add Row</span></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>TOTALS</th>
                                        <th colspan="2"><input type="number" name="fi_amnt" value="<?= $data['expenseInfo']->fi_amnt ?>" placeholder="Total Amount (Ksh)" value="0" class="form-control form-control-sm"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent pb-3">
                        <button type="reset" class="btn btn-outline-danger"><i class="fas fa-refresh"></i> Reset Inputs</button>
                        <button type="submit" class="btn btn-custom border-0 float-end"><i class="fas fa-save"></i> Update Expense</button>
                    </div>
                </div>
            </form>
        <?php } else { ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-danger text-uppercase">
                    Invalid directory or the invoice is not found
                </div>
            </div>
        <?php } ?>

    <?php
        break;
    default:
    ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header">EXPENSE INFORMATION</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover" id="dataTable1">
                        <thead class="bg-light">
                            <tr class="text-capitalize">
                                <th>Date</th>
                                <th>Title</th>
                                <th class="pw-15">Amount [Ksh]</th>
                                <th>Invoice By</th>
                                <th class="pw-10">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['expense'])) : ?>
                                <?php foreach ($data['expense'] as $key => $value) { ?>
                                    <tr>
                                        <td><?= date("d-m-Y", strtotime($value->date)) ?></td>
                                        <td><?= $value->fi_head ?></td>
                                        <td class="text-end"><?= number_format($value->fi_amnt, 2) ?></td>
                                        <td><?= ucwords($value->fi_by) ?></td>
                                        <td class="text-nowrap">
                                            <a href="<?= ROOT . VIEWFOLDER ?>/expense/update/<?= $value->fi_key ?>" class="btn btn-sm btn-outline-custom"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="<?= ROOT . VIEWFOLDER ?>/printtemp/expense/<?= $value->fi_key ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-print"></i> Print</a>
                                            <button onclick="deleteExpense('<?= $value->fi_key ?>')" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button>
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
}
