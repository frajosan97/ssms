<?php

switch ($fileView) {
    case "analyze":
        if (!(isset($data['notFound']))) {
?>

            <blockquote class="m-0 mb-3">
                <ul class="list-group list-group-horizontal m-0 border-0 bg-light">
                    <li class="list-group-item bg-transparent border-0 p-1">
                        <button class="btn btn-sm btn-outline-custom text-capitalize" id="actionBtn" onclick="vPF(this,'viewAnalysis','printAnalysis','analysis report')" value="show"><i class="fas fa-eye"></i> View analysis report</button>
                    </li>
                    <li class="list-group-item bg-transparent border-0 p-1">
                        <button class="btn btn-sm btn-outline-custom text-capitalize d-none" id="printBtn" onclick="printDiv('printAnalysis')"><i class="fas fa-print"></i> Print analysis report</button>
                    </li>
                </ul>
            </blockquote>
            <div class="card border-0 shadow-none bg-transparent" id="viewAnalysis">
                <div class="card-body p-0">
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-header h6 text-uppercase bg-white"><?= strtoupper($data['currentExam']['resHeading'] . ' - performance analysis.') ?></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 py-2">
                                    <div class="card shadow-none h-100">
                                        <div class="card-header bg-transparent text-center border-0 text-muted">
                                            <i class="fas fa-university fa-3x"></i>
                                            <h4 class="p-0 mb-0"><strong><?= ucwords('form ' . $data['currentExam']['resFullClass']) ?></strong></h4>
                                            <h6 class="p-0 mb-0"><strong><?= ucwords($data['currentExam']['resExamName'] . ' exam') ?></strong></h6>
                                        </div>
                                        <div class="card-body">
                                            <hr class="dividerDiv1" />
                                            <table class="table table-borderless align-middle">
                                                <tr>
                                                    <th class="p-1 px-0">Avg Marks</th>
                                                    <th class="p-1 px-0 h4 fw-bold"><?= number_format($data['currentExam']['resFAvgMark'], 2) ?></th>
                                                    <th class="p-1 px-0 text-end"><?= dev($data['dev']['avgMarksDev']) ?></th>
                                                </tr>
                                                <tr>
                                                    <th class="p-1 px-0">Avg Points</th>
                                                    <th class="p-1 px-0 h4 fw-bold"><?= number_format($data['currentExam']['resFAvgPnts'], 2) ?></th>
                                                    <th class="p-1 px-0 text-end"><?= dev($data['dev']['avgPointsDev']) ?></th>
                                                </tr>
                                                <tr>
                                                    <th class="p-1 px-0">Avg Grade</th>
                                                    <th class="p-1 px-0 text-end h3 fw-bold" colspan="2"><?= $data['currentExam']['resFAvgGrade'] ?></th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 py-2">
                                    <div class="card shadow-none h-100">
                                        <div class="card-header text-muted"><strong>Streams performance graphical analysis against Class Performance</strong></div>
                                        <div class="card-body">
                                            <canvas id="formGraphView" style="max-height: inherit; max-width: 100%;"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 py-2">
                                    <div class="card shadow-none h-100">
                                        <div class="card-header bg-transparent text-center border-0 text-muted">
                                            <i class="fas fa-graduation-cap fa-3x"></i>
                                            <h4 class="p-0 mb-0"><strong><?= ucwords($data['currentExam']['resFCount'] . ' students') ?></strong></h4>
                                            <h6 class="p-0 mb-0"><strong><?= 'Who sat for the exam' ?></strong></h6>
                                        </div>
                                        <div class="card-body">
                                            <hr class="dividerDiv1" />
                                            <ul class="list-group text-center rounded-0 bg-transparent text-capitalize">
                                                <li class="list-group-item bg-transparent border-0 py-1">
                                                    <div class="dropdown">
                                                        <button class="btn btn-custom btn-sm dropdown-toggle w-100" id="dropdownMenuButton" data-bs-toggle="dropdown"><i class="fas fa-file-alt"></i> Merit Lists</button>
                                                        <div class="dropdown-menu p-0 border-0 shadow-sm w-100" aria-labelledby="dropdownMenuButton">
                                                            <a href="<?= ROOT . VIEWFOLDER ?>/report/merit/<?= $data['currentExam']['resExam'] ?>/<?= $data['currentExam']['resClass'] ?>" class="btn btn-sm rounded-0 dropdown-item maincolor"><?= "form " . $data['currentExam']['resClass'] ?></a>
                                                            <?php if (count($data['currentExam']['streamsData']) > 0) : ?>
                                                                <?php foreach ($data['currentExam']['streamsData'] as $stream => $streamData) { ?>
                                                                    <a href="<?= ROOT . VIEWFOLDER ?>/report/merit/<?= $data['currentExam']['resExam'] ?>/<?= rawSmartKey($data['currentExam']['resClass'] . " " . $stream) ?>" class="btn btn-sm rounded-0 dropdown-item maincolor"><?= "form " . $data['currentExam']['resClass'] . " " . $stream ?></a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item bg-transparent border-0 py-1">
                                                    <div class="dropdown">
                                                        <button class="btn btn-custom btn-sm dropdown-toggle w-100" id="dropdownMenuButton" data-bs-toggle="dropdown"><i class="fas fa-file-pdf"></i> Report Forms</button>
                                                        <div class="dropdown-menu p-0 border-0 shadow-sm w-100" aria-labelledby="dropdownMenuButton">
                                                            <a href="<?= ROOT . VIEWFOLDER ?>/report/report_forms/f/<?= $data['currentExam']['resExam'] ?>/<?= $data['currentExam']['resClass'] ?>" class="btn btn-sm rounded-0 dropdown-item maincolor"><?= "form " . $data['currentExam']['resClass'] ?></a>
                                                            <?php if (count($data['currentExam']['streamsData']) > 0) : ?>
                                                                <?php foreach ($data['currentExam']['streamsData'] as $stream => $streamData) { ?>
                                                                    <a href="<?= ROOT . VIEWFOLDER ?>/report/report_forms/cs/<?= $data['currentExam']['resExam'] ?>/<?= $data['currentExam']['resClass'] ?>/<?= $stream ?>" class="btn btn-sm rounded-0 dropdown-item maincolor"><?= "form " . $data['currentExam']['resClass'] . " " . $stream ?></a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item bg-transparent border-0 py-1">
                                                    <a href="<?= ROOT . VIEWFOLDER ?>/report/most_improved/<?= $data['currentExam']['resExam'] ?>/<?= $data['currentExam']['resClass'] ?>" class="btn btn-custom btn-sm text-center w-100"><i class="fas fa-chart-line"></i> Most Improved List</a>
                                                </li>
                                                <!-- <li class="list-group-item bg-transparent border-0 py-1">
                                                    <a href="<?= ROOT . VIEWFOLDER ?>/report/term_based/<?= $data['currentExam']['resTermKey'] ?>/<?= $data['currentExam']['resClass'] ?>" class="btn btn-custom btn-sm text-center w-100"><i class="fas fa-chart-line"></i> Term Based Reports</a>
                                                </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body text-capitalize">
                            <div class="row">
                                <div class="col-md-4 py-2">
                                    <div class="card shadow-none h-100">
                                        <div class="card-body pb-0 subPerfView"></div>
                                    </div>
                                </div>
                                <div class="col-md-8 py-2">
                                    <div class="card shadow-none h-100">
                                        <div class="card-header text-uppercase text-muted">Subject performance graphical analysis against Class Performance</div>
                                        <div class="card-body">
                                            <canvas id="subPerfGraph" style="max-height: inherit; max-width: 100%;"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body text-capitalize">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shadow-none h-100">
                                        <div class="card-header pb-0 border-0">
                                            <select onchange="showCategory(this)" class="form-control selectpicker pw-20">
                                                <?php foreach ($data['currentExam']['gradesDistr'] as $grdDist => $grdDistData) { ?>
                                                    <option value="<?= $grdDist ?>"><?= ucwords($grdDist) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="card-body pb-0">
                                            <div class="table-responsive contentDisplay"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm d-none" id="printAnalysis">
                <div class="card-header bg-white border-0 pb-0">
                    <table class="table table-sm table-borderless mb-0 align-middle">
                        <tr>
                            <th class="pw-5"><img src="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>" alt=""></th>
                            <td class="text-center">
                                <h3 class="m-0"><?= strtoupper(APPINFO->sch_name) ?></h3>
                                <h5 class="m-0">P.O Box <?= ucwords(APPINFO->sch_address . ' - ' . APPINFO->sch_postcode . ', ' . APPINFO->sch_town) ?></h5>
                                <small class="text-danger"><i><?= ucwords(APPINFO->sch_moto) ?></i></small>
                                <h5><?= strtoupper($data['currentExam']['resHeading'] . ' - performance analysis.') ?></h5>
                            </td>
                            <th class="pw-5"></th>
                        </tr>
                    </table>
                    <hr class="dividerDiv1" />
                </div>
                <div class="card-body">
                    <div class="card shadow-none rounded-0">
                        <div class="card-header rounded-0">
                            <h6 class="mb-0">SUBJECT ANALYSIS</h6>
                        </div>
                        <div class="card-body subPerfPrint">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm table-hover text-nowrap align-middle mb-0 text-capitalize">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Subject</th>
                                            <th>Points</th>
                                            <th>Grade</th>
                                            <th>Dev</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($data['currentExam']['subjectsData'] as $subject => $subjectData) {
                                            $subDev = 0;
                                            if (isset($data['previousExam'])) {
                                                foreach ($data['previousExam']['subjectsData'] as $subject2 => $subjectData2) {
                                                    if ($subject == $subject2) {
                                                        if ($subjectData2['subMeanPoints'] > 0 && $subjectData['subMeanPoints'] > 0) {
                                                            $subDev = $subjectData2['subMeanPoints'] - $subjectData['subMeanPoints'];
                                                        } else {
                                                            $subDev = 0;
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td><?= $subject ?></td>
                                                <td><?= $subjectData['subMeanPoints'] ?></td>
                                                <td><?= $subjectData['subGrade'] ?></td>
                                                <td><?= dev($subDev) ?></td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-none rounded-0">
                        <div class="card-header rounded-0">
                            <h6 class="mb-0">PERFORMANCE GRADES DISTRIBUTION</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <?php foreach ($data['currentExam']['gradesDistr'] as $grdDist => $grdDistData) { ?>
                                    <li class="list-group-item rounded-0 border-0 p-0 my-2">
                                        <h5 class="text-muted text-capitalize"><?= $grdDist . " performance grade distribution" ?></h5>
                                        <hr class="dividerDiv1" />
                                        <div class="table-responsive" id="<?= $grdDist ?>">
                                            <table class="table table-striped table-bordered table-sm table-hover text-nowrap align-middle text-capitalize mb-0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Form</th>
                                                        <?php foreach (DEFAULTGRADES as $grade => $value) { ?>
                                                            <th><?= ucwords($grade) ?></th>
                                                        <?php } ?>
                                                        <th>Entries</th>
                                                        <th>Mean</th>
                                                        <th>Points</th>
                                                        <th>Grade</th>
                                                        <th>Teacher</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($grdDistData as $grdDataKey => $finalData) { ?>

                                                        <tr>
                                                            <td><?= $grdDataKey ?></td>
                                                            <?php foreach (DEFAULTGRADES as $grade => $value) { ?>
                                                                <td><?= $finalData[$grade] ?></td>
                                                            <?php } ?>
                                                            <td><?= $finalData['entries'] ?></td>
                                                            <td><?= number_format($finalData['mMarks'], 2) ?></td>
                                                            <td><?= number_format($finalData['mPoints'], 2) ?></td>
                                                            <td><?= $finalData['grade'] ?></td>
                                                            <td><?= $finalData['cTeacher'] ?></td>
                                                        </tr>

                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    showCategory("overall");
                    var viewSubData = $(".subPerfPrint").html();
                    $(".subPerfView").html(viewSubData);
                });

                const formV = document.getElementById('formGraphView');
                const view = new Chart(formV, {
                    type: 'bar',
                    data: {
                        datasets: [{
                            label: 'Stream Mean',
                            data: [<?php foreach ($data['currentExam']['streamsData'] as $stream => $streamData) { ?> '<?= ucwords(round($streamData['resStrMMark'], 4)) ?>', <?php } ?>],
                            order: 2,
                            backgroundColor: [<?php foreach ($data['currentExam']['streamsData'] as $stream => $streamData) { ?> '<?= APPINFO->sch_sec_theme ?>', <?php } ?>]
                        }, {
                            label: '<?= ucwords("form " . $data['currentExam']['resFullClass'] . " mean") ?>',
                            data: [<?php foreach ($data['currentExam']['streamsData'] as $stream => $streamData) { ?> '<?= ucwords(round($data['currentExam']['resFAvgMark'], 4)) ?>', <?php } ?>],
                            type: 'line',
                            order: 1
                        }],
                        labels: [<?php foreach ($data['currentExam']['streamsData'] as $stream => $streamData) { ?> '<?= ucwords($stream) ?>', <?php } ?>]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 100,
                                }
                            }]
                        }
                    }
                });

                // subjects performance
                const subP = document.getElementById('subPerfGraph');
                const mixedChartSub = new Chart(subP, {
                    type: 'bar',
                    data: {
                        datasets: [{
                            label: 'Subject Mean',
                            data: [<?php foreach ($data['currentExam']['subjectsData'] as $subject => $subjectData) { ?> '<?= ucwords($subjectData['subMeanMarks']) ?>', <?php } ?>],
                            order: 2,
                            backgroundColor: [<?php foreach ($data['currentExam']['subjectsData'] as $subject => $subjectData) { ?> '<?= APPINFO->sch_sec_theme ?>', <?php } ?>]
                        }, {
                            label: '<?= ucwords("form " . $data['currentExam']['resFullClass'] . " mean") ?>',
                            data: [<?php foreach ($data['currentExam']['subjectsData'] as $subject => $subjectData) { ?> '<?= ucwords(round($data['currentExam']['resFAvgMark']), 4) ?>', <?php } ?>],
                            type: 'line',
                            order: 1
                        }],
                        labels: [<?php foreach ($data['currentExam']['subjectsData'] as $subject => $subjectData) { ?> '<?= ucwords($subject) ?>', <?php } ?>]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 100,
                                    stepSize: 10,
                                }
                            }]
                        }
                    }
                });
            </script>

        <?php
        } else {
        ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body"><?= $data['notFound'] ?></div>
            </div>

        <?php }
        break;
    default:
        ?>

        <div class="card bg-transparent border-0 shadow-none">
            <div class="card-body p-0">
                <select class="selectpicker pw-20" onchange="getExams(this)">
                    <option value="">--Academic Year--</option>
                    <?php for ($i = date("Y"); $i >= 2020; $i--) { ?>
                        <option value="<?= $i ?>" <?php if ($data['acYear'] == $i) : ?> selected <?php endif; ?>><?= $i ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <?php if (!(isset($data['examsError']))) { ?>
            <?php foreach ($data['termData'] as $key => $value) { ?>
                <!-- Term data start -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6><span class="bg-white px-2 mx-2 text-uppercase"><?= "term " . $key . " exams" ?></span></h6>
                        <div class="col-12 border border-custom px-3" style="padding-top: 20px; margin-top:-18px">
                            <!-- Term exams data start -->
                            <?php if (isset($value['termExams'])) { ?>
                                <?php if (count($value['termExams']) > 0) { ?>
                                    <?php foreach ($value['termExams'] as $examKey => $examValue) {
                                        $appData = new App;
                                        $examInfo = $appData->examInfo($examKey);
                                    ?>
                                        <!-- according start -->
                                        <div class="card shadow-none border border-custom collapse-icon accordion-icon-rotate">
                                            <div id="accordHead<?= $examKey ?>" class="card-header bg-transparent p-2 border-0">
                                                <a data-bs-toggle="collapse" data-bs-parent="#accordionWrap6" href="#accordCont<?= $examKey ?>" aria-expanded="false" aria-controls="accordCont<?= $examKey ?>" class="maincolor w-100">
                                                    <div class="h6 mb-0"><?= strtoupper($examInfo->exam . " exam") ?> <span class="float-end"><i class="fas fa-plus-circle"></i></span></div>
                                                </a>
                                            </div>
                                            <div id="accordCont<?= $examKey ?>" role="tabpanel" aria-labelledby="accordHead<?= $examKey ?>" class="card-collapse collapse " aria-expanded="false">
                                                <div class="card-body p-2 border-top-custom">
                                                    <div class="card-body p-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover text-capitalize align-middle mb-0">
                                                                <thead class="maincolor">
                                                                    <tr>
                                                                        <th>Class</th>
                                                                        <th>Total</th>
                                                                        <th>Status</th>
                                                                        <th colspan="2" class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($examValue as $class => $classData) { ?>

                                                                        <tr>
                                                                            <td class="pw-20"><?= $class ?></td>
                                                                            <?php if ($classData['res_count'] > 0) { ?>
                                                                                <td class="pw-20"><?= $classData['res_count'] ?> records</td>

                                                                                <?php if ($classData['res_pending'] > 0) {
                                                                                    if ($_SESSION[VIEWFOLDER]->user_role > 1) { ?>
                                                                                        <form action="" method="post">
                                                                                            <input type="hidden" name="examKey" value="<?= $examKey ?>">
                                                                                            <td class="pw-20"><button name="approve" value="<?= $class ?>" class="btn btn-sm btn-outline-custom text-capitalize"><?= $classData['res_pending'] ?> pending approval | Click to Approve</button></td>
                                                                                        </form>
                                                                                    <?php } else { ?> <td><?= $classData['res_pending'] ?> pending approval</td> <?php }
                                                                                                                                                            } else { ?>
                                                                                    <td class="pw-20">Approved</td>
                                                                                <?php } ?>

                                                                                <td class="pw-20"><a href="<?= ROOT . VIEWFOLDER ?>/result/analyze/<?= $examKey ?>/<?= $class ?>" class="btn btn-outline-custom btn-sm">Analyze Results</a></td>
                                                                            <?php } else { ?>
                                                                                <td class="pw-20" colspan="3"><i class="text-danger">No records found!</i></td>
                                                                            <?php } ?>

                                                                            <?php if (($sno == 1) && ($_SESSION[VIEWFOLDER]->user_role > 1)) : ?>
                                                                                <td class="pw-20 text-center" rowspan="<?= APPINFO->sch_cl_num ?>">
                                                                                    <ul class="list-group">
                                                                                        <li class="list-group-item border-0 rounded-0 bg-transparent">
                                                                                            <button value="<?= $examKey ?>" onclick="deleteInvalid(this)" class="btn btn-sm btn-outline-warning"><i class="fas fa-trash-alt"></i> Delete Invalid Results Records</button>
                                                                                        </li>
                                                                                        <li class="list-group-item border-0 rounded-0 bg-transparent">
                                                                                            <button value="<?= $examKey ?>" onclick="deleteExam(this)" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete Exam</button>
                                                                                        </li>
                                                                                    </ul>
                                                                                </td>
                                                                            <?php endif;
                                                                            $sno++; ?>
                                                                        </tr>

                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / according end -->
                                    <?php } ?>
                                <?php } else { ?>
                                    <span class="text-danger">There are no exams done for this term yet!</span>
                                <?php } ?>
                            <?php } else { ?>
                                <span class="text-danger">There are no exams done for this term yet!</span>
                            <?php } ?>
                            <!-- Term exams data end -->
                        </div>
                    </div>
                </div>
                <!-- Term data end -->
            <?php } ?>
        <?php } else { ?>
            <div class='card border-0 shadow-sm'>
                <div class='card-body text-danger'><?= $data['examsError'] ?></div>
            </div>
        <?php } ?>

<?php
        break;
}
