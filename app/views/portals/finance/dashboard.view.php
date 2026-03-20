<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm bg-img p-3">
                    <div class="card-body text-center text-md-start">
                        <div class="row clearfix">
                            <div class="col-md-2">
                                <?php if (VIEWFOLDER == "student") { ?>
                                    <img src="<?= imageCheck("profiles", $_SESSION[VIEWFOLDER]->stud_pass, "avatar.png") ?>" class="rounded-circle bg-light p-1" style="max-height: 100px; max-width: 100px;" alt="User Image">
                                <?php } else { ?>
                                    <img src="<?= imageCheck("profiles", $_SESSION[VIEWFOLDER]->user_pass, "avatar.png") ?>" class="rounded-circle bg-light p-1" style="max-height: 100px; max-width: 100px;" alt="User Image">
                                <?php } ?>
                            </div>
                            <div class="col-md-10 text-white">
                                <h5><?= greeting_msg() ?>,</h5>
                                <h6>Welcome back, <u><?= ucwords($_SESSION[VIEWFOLDER]->user_fname . " " . $_SESSION[VIEWFOLDER]->user_lname) ?></u>,</h6>
                                Manage your school from the comfort of your device
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- |||||||||||||||||||||||||||| START SMALL BOXES |||||||||||||||||||||||||||||||||||||||||||| -->
            <!-- small box data show -->
            <div class="col-md-4 text-capitalize">
                <a href="<?= ROOT . VIEWFOLDER ?>/cashier/collection">
                    <div class="card border-0 shadow-sm bg-logo effect-on-hover">
                        <div class="card-body">
                            <table class="table table-borderless table-sm text-muted">
                                <tbody>
                                    <tr>
                                        <th class="p-0 h5 fw-bold"><?= number_format($data['account']['totalPaid'], 2) ?></th>
                                        <th rowspan="2" class="text-end p-0 align-middle"><i class="fas fa-wallet fa-2x"></i></th>
                                    </tr>
                                    <tr>
                                        <th class="p-0">total collections
                                            <hr class="dividerDiv3 my-0">
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </a>
            </div>
            <!-- small box data show -->
            <div class="col-md-4 text-capitalize">
                <a href="<?= ROOT . VIEWFOLDER ?>/expense">
                    <div class="card border-0 shadow-sm bg-logo effect-on-hover">
                        <div class="card-body">
                            <table class="table table-borderless table-sm text-muted">
                                <tbody>
                                    <tr>
                                        <th class="p-0 h5 fw-bold"><?= number_format($data['account']['totalExpense'], 2) ?></th>
                                        <th rowspan="2" class="text-end p-0 align-middle"><i class="fas fa-pound-sign fa-2x"></i></th>
                                    </tr>
                                    <tr>
                                        <th class="p-0">total expenses
                                            <hr class="dividerDiv3 my-0">
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </a>
            </div>
            <!-- small box data show -->
            <div class="col-md-4 text-capitalize">
                <a href="">
                    <div class="card border-0 shadow-sm bg-logo effect-on-hover">
                        <div class="card-body">
                            <table class="table table-borderless table-sm text-muted">
                                <tbody>
                                    <tr>
                                        <th class="p-0 h5 fw-bold"><?= number_format($data['account']['totalBalance'], 2) ?></th>
                                        <th rowspan="2" class="text-end p-0 align-middle"><i class="fas fa-money-bill-alt fa-2x"></i></th>
                                    </tr>
                                    <tr>
                                        <th class="p-0">account balance
                                            <hr class="dividerDiv3 my-0">
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </a>
            </div>
            <!-- |||||||||||||||||||||||||||| END SMALL BOXES |||||||||||||||||||||||||||||||||||||||||||| -->
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-1">
                        <ul class="list-group list-group-horizontal-md">
                            <li class="list-group-item">
                                Expected Collection: <br> <strong>Ksh. <?= number_format($data['account']['totalBill'], 2) ?></strong>
                            </li>
                            <li class="list-group-item">
                                Collected Amount: <br> <strong>Ksh. <?= number_format($data['account']['totalPaid'], 2) ?></strong>
                            </li>
                            <li class="list-group-item">
                                Expected Collection Balance: <br> <strong>Ksh. <?= number_format($data['account']['collectionBalance'], 2) ?></strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-1 rounded">
                <h6>Quick Links</h6>
                <hr class="dividerDiv1 my-1">
                <ul class="list-group">
                    <li class="list-group-item bg-transparent border-0 p-1">
                        <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#createTerm" class="d-block">
                            <i class="fas fa-list-alt"></i> Create New Term
                        </a>
                    </li>
                    <li class="list-group-item bg-transparent border-0 p-1">
                        <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#postFees" class="d-block">
                            <i class="fas fa-sticky-note"></i> Post term fees
                        </a>
                    </li>
                    <li class="list-group-item bg-transparent border-0 p-1">
                        <a href="<?= ROOT . VIEWFOLDER ?>/cashier" class="d-block">
                            <i class="fas fa-wallet"></i> Receive payment
                        </a>
                    </li>
                    <li class="list-group-item bg-transparent border-0 p-1">
                        <a href="<?= ROOT . VIEWFOLDER ?>/expense/add" class="d-block">
                            <i class="fas fa-wallet"></i> Add Expense
                        </a>
                    </li>
                    <li class="list-group-item bg-transparent border-0 p-1">
                        <a href="<?= ROOT . VIEWFOLDER ?>/system/fees_structure" class="d-block">
                            <i class="fas fa-file-pdf"></i> Fees structure
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <?php if (!(empty($data['logs']))) : ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body rounded py-1">
                    <h6>Activity Logs</h6>
                    <hr class="dividerDiv1 my-1">
                    <div class="timelineCont">
                        <div class="timeline">
                            <?php include_once incFile("logs"); ?>
                        </div>
                    </div>
                    <a href="<?= ROOT . VIEWFOLDER ?>/log"><small class="text-danger"><i class="fas fa-external-link"></i> View all system logs</small></a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header pb-0 border-0 fw-bold">Unallocated Payments
                <hr class="dividerDiv1 my-1">
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover" id="dataTable1">
                        <thead class="bg-light">
                            <tr class="text-capitalize">
                                <th>Date</th>
                                <th>Pay Mode</th>
                                <th>Bill Ref</th>
                                <th>Amount [Ksh]</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['unallocated'])) { ?>
                                <?php foreach ($data['unallocated'] as $key => $value) { ?>
                                    <tr>
                                        <td><?= date("D d-m-Y", strtotime($value->date)) ?></td>
                                        <td><?= ucwords($value->fi_payM) ?></td>
                                        <td><?= $value->fi_ref ?></td>
                                        <td class="text-end"><?= number_format($value->fi_amnt, 2) ?></td>
                                        <td><a href="<?= ROOT . VIEWFOLDER ?>/cashier/allocate/<?= $value->fi_key ?>" class="btn btn-sm btn-outline-primary w-100"><i class="fas fa-edit"></i> Allocate</a></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>