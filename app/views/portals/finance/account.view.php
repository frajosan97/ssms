<?php
switch ($fileView) {
    case "create":
?>

        <form class="addAccountForm">
            <div class="card border-0 shadow-sm">
                <div class="card-header text-uppercase">CREATE AN ACCOUNT</div>
                <div class="card-body">
                    <h6><u><i class="fas fa-edit"></i> Account information</u></h6>
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="acc_bank_name">Bank Name</label>
                            <input type="text" name="acc_bank_name" placeholder="Bank Name e.g National Bank" class="form-control form-control-sm" required />
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="acc_bank_branch_name">Bank Branch</label>
                            <input type="text" name="acc_bank_branch_name" placeholder="Bank Branch e.g Kitui" class="form-control form-control-sm" required />
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="acc_name">Account Name</label>
                            <input type="text" name="acc_name" placeholder="Account Name e.g Boarding Account" class="form-control form-control-sm" required />
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="acc_number">Account Number</label>
                            <input type="number" name="acc_number" placeholder="Account Number" class="form-control form-control-sm" required />
                        </div>
                    </div>
                    <?php if (VOTEHEADS) : ?>
                        <h6><input type="checkbox" checked disabled /> <u>Tick all Vote heads attached to this account</u></h6>
                        <div class="border border-custom rounded bg-light p-1">
                            <?php foreach (VOTEHEADS as $key => $value) { ?>
                                <div class="form-group">
                                    <label for="<?= $value->vote_head_key ?>"><input type="checkbox" id="<?= $value->vote_head_key ?>" name="acc_votes[]" value="<?= $value->vote_head_key ?>"> <?= ucfirst($value->vote_head_name) ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer border-0 bg-transparent pb-3">
                    <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset Inputs</button>
                    <button type="submit" class="btn float-end btn-outline-custom"><i class="fas fa-save"></i> Create Account</button>
                </div>
            </div>
        </form>

    <?php
        break;
    case 'read':
    ?>

        <form class="updateAccForm">
            <div class="card border-0 shadow-sm">
                <div class="card-header text-uppercase"><strong><?= $data['account']->acc_name . " - " . $data['account']->acc_number ?></strong></div>
                <div class="card-body">
                    <h6><u><i class="fas fa-edit"></i> Edit account information</u></h6>
                    <div class="row">
                        <input type="hidden" name="acc_key" value="<?= $data['account']->acc_key ?>">
                        <div class="form-group col-md-6 mb-2">
                            <label for="acc_bank_name">Bank Name</label>
                            <input type="text" name="acc_bank_name" value="<?= $data['account']->acc_bank_name ?>" placeholder="Bank Name e.g National Bank" class="form-control form-control-sm" required />
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="acc_bank_branch_name">Bank Branch</label>
                            <input type="text" name="acc_bank_branch_name" value="<?= $data['account']->acc_bank_branch_name ?>" placeholder="Bank Branch e.g Kitui" class="form-control form-control-sm" required />
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="acc_name">Account Name</label>
                            <input type="text" name="acc_name" value="<?= $data['account']->acc_name ?>" placeholder="Account Name e.g Boarding Account" class="form-control form-control-sm" required />
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="acc_number">Account Number</label>
                            <input type="number" name="acc_number" value="<?= $data['account']->acc_number ?>" placeholder="Account Number" class="form-control form-control-sm" required />
                        </div>
                    </div>
                    <?php if (VOTEHEADS) : ?>
                        <h6><input type="checkbox" checked disabled /> <u>Tick all Vote heads attached to this account</u></h6>
                        <div class="border border-custom rounded bg-light p-1">
                            <?php foreach (VOTEHEADS as $key => $value) { ?>
                                <div class="form-group">
                                    <label for="<?= $value->vote_head_key ?>"><input type="checkbox" id="<?= $value->vote_head_key ?>" name="acc_votes[]" value="<?= $value->vote_head_key ?>" <?php if (in_array($value->vote_head_key, $data['accVotes'])) : ?>checked<?php endif; ?>> <?= ucfirst($value->vote_head_name) ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer border-0 bg-transparent pb-3">
                    <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset Inputs</button>
                    <button type="submit" class="btn float-end btn-outline-custom"><i class="fas fa-save"></i> Update Account</button>
                </div>
            </div>
        </form>

    <?php
        break;
    default:
    ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header text-uppercase">ALL SCHOOL ACCOUNTS</div>
            <div class="card-body">
                <blockquote class="m-0 mb-3 rounded bg-light">
                    <a href="<?= ROOT . VIEWFOLDER ?>/account/create" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus-circle"></i> Add Account</a>
                </blockquote>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover align-middle" id="dataTable1">
                        <thead class="bg-light">
                            <tr>
                                <th>Bank Name</th>
                                <th>Bank Branch</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Vote Heads</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['account'])) : ?>
                                <?php foreach ($data['account'] as $key => $value) {
                                    $appData = new App;
                                    $accVotes = $appData->sch_fin_acc_votes($value->acc_key);
                                ?>
                                    <tr>
                                        <td><?= ucfirst($value->acc_bank_name) ?></td>
                                        <td><?= ucfirst($value->acc_bank_branch_name) ?></td>
                                        <td><?= ucfirst($value->acc_name) ?></td>
                                        <td><?= ucfirst($value->acc_number) ?></td>
                                        <td class="text-small small">
                                            <?php if (isset($accVotes['votes'])) { ?>
                                                <?php foreach ($accVotes['votes'] as $voteValue) { ?>
                                                    <?= ucfirst($voteValue['vote_head_name']) ?><br>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <i class="text-danger">No vote head attached to this account</i>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?= ROOT . VIEWFOLDER ?>/account/read/<?= $value->acc_key ?>" class="btn btn-sm btn-outline-custom"><i class="fas fa-briefcase"></i> Manage Account</a>
                                            <button onclick="deleteAcc('<?= $value->id ?>')" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button>
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
