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
                                <?php if (VIEWFOLDER == "student") { ?>
                                    <h6 class=""><?= "Name: " . $data['studInfo']['profile']->stud_lname . " " . $data['studInfo']['profile']->stud_fname . " " . $data['studInfo']['profile']->stud_oname ?></h6>
                                    <h6 class="m-0"><?= "Adm No: " . $data['studInfo']['profile']->stud_adm ?></h6>
                                    <h6 class="m-0"><?= "Class: " . $data['studInfo']['profile']->stud_form . " " . $data['studInfo']['profile']->stud_stream ?></h6>
                                <?php } else { ?>
                                    <h6>Welcome back, <u><?= ucwords($_SESSION[VIEWFOLDER]->user_fname . " " . $_SESSION[VIEWFOLDER]->user_lname) ?></u>,</h6>
                                <?php } ?>
                                Track the progress of your <?= studSalutation() ?> from the comfort of your device
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- |||||||||||||||||||||||||||| START SMALL BOXES |||||||||||||||||||||||||||||||||||||||||||| -->
            <!-- small box data show -->
            <div class="col-md-4 text-capitalize">
                <a href="<?= ROOT . "library" ?>">
                    <div class="card border-0 shadow-sm bg-logo effect-on-hover">
                        <div class="card-body">
                            <table class="table table-borderless table-sm text-muted">
                                <tbody>
                                    <tr>
                                        <th class="p-0 h3 fw-bold"><?= $data['sch_lib_res'] ?></th>
                                        <th rowspan="2" class="text-end p-0 align-middle"><i class="fas fa-book fa-2x"></i></th>
                                    </tr>
                                    <tr>
                                        <th class="p-0">library
                                            <hr class="dividerDiv3 my-0">
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 text-capitalize">
                <a href="<?= ROOT  . "download" ?>">
                    <div class="card border-0 shadow-sm bg-logo effect-on-hover">
                        <div class="card-body">
                            <table class="table table-borderless table-sm text-muted">
                                <tbody>
                                    <tr>
                                        <th class="p-0 h3 fw-bold"><?= $data['sch_downloads'] ?></th>
                                        <th rowspan="2" class="text-end p-0 align-middle"><i class="fas fa-download fa-2x"></i></th>
                                    </tr>
                                    <tr>
                                        <th class="p-0">downloads
                                            <hr class="dividerDiv3 my-0">
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 text-capitalize">
                <a href="<?= ROOT . "" . VIEWFOLDER . "/finance" ?>">
                    <div class="card border-0 shadow-sm bg-logo effect-on-hover">
                        <div class="card-body">
                            <table class="table table-borderless table-sm text-muted">
                                <tbody>
                                    <tr>
                                        <th class="p-0 h3 fw-bold"><?= number_format($data['paidFees'], 0) ?>/=</th>
                                        <th rowspan="2" class="text-end p-0 align-middle"><i class="fas fa-wallet fa-2x"></i></th>
                                    </tr>
                                    <tr>
                                        <th class="p-0">finance
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
            <!-- performance -->
            <div class="col-md-12">
                <div class="card border-0 shadow-sm text-capitalize">
                    <div class="card-header">EXAMS</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover">
                                <thead class="maincolor">
                                    <tr>
                                        <th class="pw-5">#</th>
                                        <th>class</th>
                                        <th>description</th>
                                        <th>marks</th>
                                        <th>mean</th>
                                        <th>points</th>
                                        <th>avg points</th>
                                        <th>grade</th>
                                        <th>rank</th>
                                        <th>position</th>
                                        <th class="pw-10">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($data['studInfo']['results']) > 0) {
                                        foreach ($data['studInfo']['results'] as $key => $value) {
                                            $appData = new App;
                                            $thisExam = $appData->examInfo($value->re_exam);
                                            $thisTerm = $appData->termInfo($value->re_term);
                                    ?>
                                            <tr>
                                                <td><?= $sno++ ?></td>
                                                <td><?= $value->re_studF . " " . $value->re_studS ?></td>
                                                <td><?= "term " . $thisTerm->term . " " . date("Y", strtotime($thisTerm->date)) . " <b>" . $thisExam->exam . "</b> exam" ?></td>
                                                <td class="text-center"><?= $value->re_tt ?></td>
                                                <td class="text-center"><?= $value->re_mean ?></td>
                                                <td class="text-center"><?= $value->re_pnt ?></td>
                                                <td class="text-center"><?= $value->re_avgpnt ?></td>
                                                <td class="text-center"><?= $value->re_grade ?></td>
                                                <td><?= $value->re_sRank ?></td>
                                                <td><?= $value->re_fRank ?></td>
                                                <td><a href="<?= ROOT . "" . VIEWFOLDER ?>/report/report_forms/s/<?= $value->re_exam . "/" . $value->re_studF . "/" . $value->re_key ?>" class="btn btn-outline-custom btn-sm w-100"><i class="fas fa-print"></i> Print Report Form</a></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="11" class="text-center">No results records found for display!</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
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
</div>