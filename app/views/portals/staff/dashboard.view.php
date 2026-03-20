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
            <?php if ($_SESSION[VIEWFOLDER]->user_role > 1) : ?>
                <!-- small box data show -->
                <div class="col-md-4 text-capitalize">
                    <a href="<?= ROOT . "" . VIEWFOLDER . "/staff" ?>">
                        <div class="card border-0 shadow-sm bg-logo effect-on-hover">
                            <div class="card-body">
                                <table class="table table-borderless table-sm text-muted">
                                    <tbody>
                                        <tr>
                                            <th class="p-0 h3 fw-bold"><?= $data['sch_staff'] ?></th>
                                            <th rowspan="2" class="text-end p-0 align-middle"><i class="fas fa-user fa-2x"></i></th>
                                        </tr>
                                        <tr>
                                            <th class="p-0">Staff
                                                <hr class="dividerDiv3 my-0">
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <!-- small box data show -->
            <div class="col-md-4 text-capitalize">
                <a href="<?= ROOT . "" . VIEWFOLDER . "/student/search" ?>">
                    <div class="card border-0 shadow-sm bg-logo effect-on-hover">
                        <div class="card-body">
                            <table class="table table-borderless table-sm text-muted">
                                <tbody>
                                    <tr>
                                        <th class="p-0 h3 fw-bold"><?= $data['sch_students'] ?></th>
                                        <th rowspan="2" class="text-end p-0 align-middle"><i class="fas fa-graduation-cap fa-2x"></i></th>
                                    </tr>
                                    <tr>
                                        <th class="p-0">students
                                            <hr class="dividerDiv3 my-0">
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </a>
            </div>
            <?php if ($_SESSION[VIEWFOLDER]->user_role > 1) : ?>
                <!-- small box data show -->
                <div class="col-md-4 text-capitalize">
                    <a href="<?= ROOT . "" . VIEWFOLDER . "/classes" ?>">
                        <div class="card border-0 shadow-sm bg-logo effect-on-hover">
                            <div class="card-body">
                                <table class="table table-borderless table-sm text-muted">
                                    <tbody>
                                        <tr>
                                            <th class="p-0 h3 fw-bold"><?= $data['sch_classes'] ?></th>
                                            <th rowspan="2" class="text-end p-0 align-middle"><i class="fas fa-university fa-2x"></i></th>
                                        </tr>
                                        <tr>
                                            <th class="p-0">classes
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
                    <a href="<?= ROOT . "" . VIEWFOLDER . "/system/exam" ?>">
                        <div class="card border-0 shadow-sm bg-logo effect-on-hover">
                            <div class="card-body">
                                <table class="table table-borderless table-sm text-muted">
                                    <tbody>
                                        <tr>
                                            <th class="p-0 h3 fw-bold"><?= $data['sch_exam'] ?></th>
                                            <th rowspan="2" class="text-end p-0 align-middle"><i class="fas fa-folder fa-2x"></i></th>
                                        </tr>
                                        <tr>
                                            <th class="p-0">exams
                                                <hr class="dividerDiv3 my-0">
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <!-- small box data show -->
            <div class="col-md-4 text-capitalize">
                <a href="<?= ROOT . "" . VIEWFOLDER . "/library" ?>">
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
            <!-- small box data show -->
            <div class="col-md-4 text-capitalize">
                <a href="<?= ROOT . "" . VIEWFOLDER . "/download" ?>">
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
            <!-- |||||||||||||||||||||||||||| END SMALL BOXES |||||||||||||||||||||||||||||||||||||||||||| -->
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-1 rounded">
                <h6>Quick Links</h6>
                <hr class="dividerDiv1 my-1">
                <ul class="list-group">
                    <?php if ($_SESSION[VIEWFOLDER]->user_role > 1) : ?>
                        <li class="list-group-item bg-transparent border-0 p-1">
                            <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#createTerm" class="d-block">
                                <i class="fas fa-list-alt"></i> Create New Term
                            </a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-1">
                            <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#createExam" class="d-block">
                                <i class="fas fa-folder-open"></i> Create New Exam
                            </a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-1">
                            <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#" class="d-block">
                                <i class="fas fa-calendar"></i> Create Event
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="list-group-item bg-transparent border-0 p-1">
                        <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#" class="d-block">
                            <i class="fas fa-pencil"></i> Book Remedial Lesson
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

    <!-- Results print -->
    <div class="col-md-12">
        <div class="card border-0 shadow-sm text-capitalize">
            <?php if (!(isset($data['noRecentExam']))) { ?>
                <div class="card-header border-0 fw-bold text-muted text-uppercase">
                    <?= $data['currExamHeading'] ?>
                </div>
                <div class="card-body bg-light p-2">
                    <div class="card-group border-0 text-center">
                        <?php foreach ($data['recentExam'] as $class => $classData) { ?>
                            <div class="card shadow-none border-0">

                                <?php if (!(isset($classData['currentExam']['notFound']))) { ?>
                                    <a href="<?= $classData['resRedirectUrl'] ?>" <?php if (isset($classData['notFound'])) : ?> data-bs-toggle="modal" data-bs-target="#resultsNotFound" <?php endif; ?>>
                                        <div class="card-header bg-transparent p-2 text-uppercase border-0">
                                            <h1 class="m-0"><i class="fas fa-university"></i></h1>
                                            <h4 class="m-0 fw-bolder"><?= ucwords('form ' . $class) ?></h4>
                                        </div>
                                        <?php if (!(isset($classData['notFound']))) { ?>
                                            <div class="card-body p-2 pb-0">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless mb-0">
                                                        <tr class="b-m">
                                                            <td class="bg-light rounded r-m">
                                                                Mean Marks
                                                                <h4 class="fw-bold maincolor">
                                                                    <?= number_format($classData['resFAvgMark'], 2) ?>
                                                                    <br>
                                                                    <?= dev($classData['resFAvgMarkDev']) ?>
                                                                </h4>
                                                            </td>
                                                            <td class="bg-light rounded r-m">
                                                                Mean Points
                                                                <h4 class="fw-bold maincolor">
                                                                    <?= number_format($classData['resFAvgPnts'], 2) ?>
                                                                    <br>
                                                                    <?= dev($classData['resFAvgPntsDev']) ?>
                                                                </h4>
                                                            </td>
                                                        </tr>
                                                        <tr class="b-m">
                                                            <td class="bg-light rounded r-m">
                                                                Students
                                                                <h4 class="fw-bold maincolor"><?= strtoupper($classData['resFCount']) ?></h4>
                                                            </td>
                                                            <td class="bg-light rounded r-m">
                                                                Mean Grade
                                                                <h4 class="fw-bold maincolor"><?= strtoupper($classData['resFAvgGrade']) ?></h4>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card-footer p-2 pt-0 border-0 bg-transparent">
                                                <button class="btn btn-sm btn-custom w-100"><i class="fas fa-chart-line"></i> Analyze Performance</button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="card-body text-danger">
                                                <?= $classData['notFound'] ?>
                                            </div>
                                        <?php } ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-footer border-0 fw-bold text-muted bg-white">
                    <a href="<?= ROOT ?>staff/result">
                        EXPLORE ALL STUDENT RESULTS <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            <?php } else { ?>
                <div class="card-body">
                    <?= $data['noRecentExam'] ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>