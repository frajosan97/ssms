<?php

switch ($fileView) {
    case 'create':
?>

        <form action="" method="post" class="createSchoolForm">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">ADD NEW SCHOOL</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" name="schoolName" placeholder="School Name" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="link" class="form-control" name="schoolDomain" placeholder="School Domain Name" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <input type="tel" class="form-control" name="schoolPhone" placeholder="Official Phone Number" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="email" class="form-control" name="schoolEmail" placeholder="Official Email Address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label for="dates" class="mb-2">Set system expiry dates</label>
                            <input type="date" class="form-control" name="schoolNextPay" id="dates" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                            <label class="mb-2"><i class="fas fa-check-circle maincolor"></i> Tick where necessary for Invoice creation</label>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="pw-5"><input type="checkbox" onclick="$('input[name*=\'invoiceItem\']').prop('checked', this.checked);"></th>
                                            <th>Description</th>
                                            <th class="pw-30">Amount ( Ksh )</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (NEWSCHOOLINVOICE as $key => $value) { ?>
                                            <tr>
                                                <input type="hidden" name="invoiceSuppItem[]" value="<?= $key ?>">
                                                <td><input type="checkbox" name="invoiceItem[]" value="<?= $key ?>"></td>
                                                <td><input type="text" name="invoiceItemHead[]" class="form-control" value="<?= $value[0] ?>"></td>
                                                <td><input type="number" name="invoiceItemAmnt[]" class="form-control" value="<?= $value[1] ?>"></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 bg-transparent pb-3">
                    <button type="reset" class="btn btn-outline-danger float-start"><i class="fas fa-undo"></i> Reset</button>
                    <button type="submit" class="btn btn-outline-custom float-end"><i class="fas fa-list-alt"></i> Register School</button>
                </div>
            </div>
        </form>

    <?php
        break;
    case 'manage':
    ?>

        <style>
            #cover-photo {
                width: 100%;
                height: 150px;
                background-image: url('<?= imageCheck("bg", $data['profile']->sch_bg, "default.png") ?>');
                background-size: cover;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }

            #profile-picture {
                background-color: #fff;
                margin-top: -60px;
            }
        </style>

        <div class="card border-0 shadow-sm">
            <div class="card-header border-0" id="cover-photo"></div>
            <div class="card-body text-center text-sm-start" style="z-index:1000;">
                <div class="row">
                    <div class="col-md-2">
                        <img id="profile-picture" src="<?= imageCheck("logos", $data['profile']->sch_logo, "logo.png") ?>" class="img bg-white rounded-circle p-1 mb-2" style="max-height: 100px; max-width: 100px" />
                    </div>
                    <div class="col-md-10">
                        <h2><?= ucwords($data['profile']->sch_name) ?></h2>
                    </div>
                </div>
                <hr class="dividerDiv1 my-3">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-capitalize fw-bold active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true"><i class="fas fa-user-edit"></i> profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-capitalize fw-bold" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices-tab-pane" type="button" role="tab" aria-controls="invoices-tab-pane" aria-selected="false"><i class="fas fa-wallet"></i> invoices</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-capitalize fw-bold" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications-tab-pane" type="button" role="tab" aria-controls="notifications-tab-pane" aria-selected="false"><i class="fas fa-bullhorn"></i> notifications</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-capitalize fw-bold" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings-tab-pane" type="button" role="tab" aria-controls="settings-tab-pane" aria-selected="false"><i class="fas fa-cog"></i> settings</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane border border-top-0 fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <!-- PROFILE MANAGEMENT -->
                        <div class="card border-0 shadow-none mb-0">
                            <div class="card-body">
                                <div class="table-reponsive">
                                    <table class="table table-bordered m-0 align-middle">
                                        <tr>
                                            <th class="pw-20 text-nowrap">School Name:</th>
                                            <td><?= ucwords($data['profile']->sch_name) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="pw-20 text-nowrap">Domain Name:</th>
                                            <td><?= ucwords($data['profile']->sch_domain) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="pw-20 text-nowrap">Postal Address:</th>
                                            <td><?= ucwords($data['profile']->sch_address . "-" . $data['profile']->sch_postcode . ", " . $data['profile']->sch_town . "-" . $data['profile']->sch_town) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="pw-20 text-nowrap">Phone Number:</th>
                                            <td> <a href="tel:<?= smartPhone($data['profile']->sch_phone) ?>"><?= smartPhone($data['profile']->sch_phone) ?></a> </td>
                                        </tr>
                                        <tr>
                                            <th class="pw-20 text-nowrap">Email Address:</th>
                                            <td> <a href="mailto:<?= $data['profile']->sch_email ?>"><?= $data['profile']->sch_email ?></a> </td>
                                        </tr>
                                        <tr>
                                            <th class="pw-20 text-nowrap">Principal Info:</th>
                                            <td>
                                                <?php foreach ($data['profile']->principal as $key => $value) { ?>
                                                    <h6><b><?= ucwords($key) ?>:</b> <?= $value ?></h6>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- / PROFILE MANAGEMENT -->
                    </div>
                    <div class="tab-pane border border-top-0 fade" id="invoices-tab-pane" role="tabpanel" aria-labelledby="invoices-tab" tabindex="0">
                        <!-- invoices -->
                        <div class="card border-0 shadow-none mb-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed table-sm table-hover table-striped text-capitalize align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>#</th>
                                                <th>School</th>
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
                                            <?php if (isset($data['invoices'])) {
                                                foreach ($data['invoices'] as $invoice) {
                                                    $appData = new App;
                                                    $invCalc = invCalc($invoice);
                                                    $schInfo = $appData->appInfo($invoice['sch_token']);
                                            ?>
                                                    <tr>
                                                        <td><?= $sno++ ?></td>
                                                        <td><a href="<?= ROOT . VIEWFOLDER . "/school/manage/" . $invoice['sch_token'] ?>"><?= ucwords($schInfo->sch_name) ?></a></td>
                                                        <td><?= ucwords($invoice['inv_type']) ?></td>
                                                        <td class="text-end"><?= number_format($invCalc['invGrantTotal'], 2) ?></td>
                                                        <td class="text-end"><?= number_format($invCalc['invPaid'], 2) ?></td>
                                                        <td class="text-end"><?= number_format($invCalc['invBalance'], 2) ?></td>
                                                        <td><?= date("D, d/m/Y", strtotime($invoice['date'])) ?></td>
                                                        <td><?= date("D, d/m/Y", strtotime($invoice['inv_exp'])) ?></td>
                                                        <td><?= invStatus($invCalc['invBalance']) ?></td>
                                                        <td class="text-nowrap"><a href="<?= ROOT . "" . VIEWFOLDER ?>/Invoice/print/<?= $invoice['inv_key'] ?>" class="btn btn-sm btn-outline-custom w-100"><i class="fas fa-print"></i> Print</a></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">No invoices found yet!</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- / invoices -->
                    </div>
                    <div class="tab-pane border border-top-0 fade" id="notifications-tab-pane" role="tabpanel" aria-labelledby="notifications-tab" tabindex="0">
                        <!-- notifications -->
                        <div class="card border-0 shadow-none mb-0">
                            <div class="card-body">
                            </div>
                        </div>
                        <!-- / notifications -->
                    </div>
                    <div class="tab-pane border border-top-0 fade" id="settings-tab-pane" role="tabpanel" aria-labelledby="settings-tab" tabindex="0">
                        <!-- settings -->
                        <div class="card border-0 shadow-none mb-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed table-sm table-hover table-striped text-capitalize align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Determines whether the school account is allowed to operate under <b>NO SUBSCRIPTION</b> mode or <b>NOT</b></td>
                                                <?php if ($data['profile']->sch_mode == 1) { ?>
                                                    <td class="text-nowrap">Subscription Mode</td>
                                                    <td class="text-nowrap"><button class="btn btn-sm btn-outline-primary w-100" onclick="manageSchAcc('updateMode','<?= $data['profile']->sch_token ?>','2','<?= $data['profile']->sch_name ?>','<?= $data['profile']->sch_phone ?>','<?= $data['profile']->sch_email ?>')"><i class="fas fa-plus-circle"></i> Add to free mode</button></td>
                                                <?php } else { ?>
                                                    <td class="text-nowrap">Free Mode</td>
                                                    <td class="text-nowrap"><button class="btn btn-sm btn-outline-info w-100" onclick="manageSchAcc('updateMode','<?= $data['profile']->sch_token ?>','1','<?= $data['profile']->sch_name ?>','<?= $data['profile']->sch_phone ?>','<?= $data['profile']->sch_email ?>')"><i class="fas fa-minus-circle"></i> Remove from free mode</button></td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td>This shows the status of the school account, it can be <b>SUSPENDED</b> due to violation of system rules and regulations or attempts of <b>HACKING</b> detected.</td>
                                                <?php if ($data['profile']->sch_status == 1) { ?>
                                                    <td class="text-nowrap">Active</td>
                                                    <td class="text-nowrap"><button class="btn btn-sm btn-outline-warning w-100" onclick="manageSchAcc('updateStatus','<?= $data['profile']->sch_token ?>','2','<?= $data['profile']->sch_name ?>','<?= $data['profile']->sch_phone ?>','<?= $data['profile']->sch_email ?>')"><i class="fas fa-pause-circle"></i> Suspend Account</button></td>
                                                <?php } else { ?>
                                                    <td class="text-nowrap">Account Suspended</td>
                                                    <td class="text-nowrap"><button class="btn btn-sm btn-outline-success w-100" onclick="manageSchAcc('updateStatus','<?= $data['profile']->sch_token ?>','1','<?= $data['profile']->sch_name ?>','<?= $data['profile']->sch_phone ?>','<?= $data['profile']->sch_email ?>')"><i class="fas fa-toggle-on"></i> Activate Account</button></td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td><b class="text-danger">DANGER ZONE!</b> <br> These delete the school account with its constituent contents, once this is done, it cannot be reverted or recovered.</td>
                                                <td class="text-nowrap">Registered</td>
                                                <td class="text-nowrap"><button class="btn btn-sm btn-outline-danger w-100" onclick="manageSchAcc('delete','<?= $data['profile']->sch_token ?>','','<?= $data['profile']->sch_name ?>','<?= $data['profile']->sch_phone ?>','<?= $data['profile']->sch_email ?>')"><i class="fas fa-trash-alt"></i> Delete Account</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- / settings -->
                    </div>
                </div>
            </div>
        </div>

    <?php
        break;
    default:
    ?>

        <a href="<?= ROOT . VIEWFOLDER ?>/school/create" class="btn py-2 text-capitalize shadow-sm rounded-pill text-start bg-white mb-3">
            <i class="fas fa-list-alt"></i> Add School
        </a>
        <div class="card shadow-sm border-0">
            <div class="card-header"> ALL SCHOOLS </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-sm table-hover table-striped text-capitalize align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>name</th>
                                <th>address</th>
                                <th>contacts</th>
                                <th class="pw-10">invoices</th>
                                <th class="pw-10">status</th>
                                <th class="pw-10">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['schools'])) { ?>
                                <?php foreach ($data['schools'] as $school) { ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <td><?= $school['sch_name'] ?></td>
                                        <td><?= $school['sch_address'] . "-" . $school['sch_postcode'] . " " . $school['sch_town'] . " " . $school['sch_city'] ?></td>
                                        <td><?= smartPhone($school['sch_phone']) ?></td>
                                        <td class="text-nowrap"><a href="<?= ROOT ?>admin/Invoice/<?= $school['sch_token'] ?>" class="btn btn-sm btn-outline-custom w-100"><?= $school['invCount'] . ' invoices' ?></a></td>
                                        <td class="text-nowrap"><?= schStatus($school['sch_status']) ?></td>
                                        <td class="text-nowrap"><a href="<?= ROOT ?>admin/school/manage/<?= $school['sch_token'] ?>" class="btn btn-sm btn-outline-custom w-100"><i class="fas fa-briefcase"></i> Manage</a></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="7" class="text-center">No school account registered yet!</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<?php
        break;
}
