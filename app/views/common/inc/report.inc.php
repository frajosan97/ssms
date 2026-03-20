<?php

switch ($fileView) {
    case "most_improved":
?>

        <div class="card shadow-sm border-0 h-100">
            <div class="card-header text-uppercase"><b><?= $data['heading'] ?></b></div>
            <div class="card-body pb-0">
                <?php if (!(isset($data['noRec']))) { ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-hover table-bordered text-nowrap align-middle mb-0 text-capitalize">
                            <thead class="bg-light">
                                <tr>
                                    <th>Adm</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>KCPE</th>
                                    <th>Marks</th>
                                    <th>Mean</th>
                                    <th>Pnt</th>
                                    <th>Avg</th>
                                    <th>Grade</th>
                                    <th>Rank</th>
                                    <th>Postn</th>
                                    <th>V.A.P</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['mostImproved'] as $key => $value) { ?>
                                    <tr>
                                        <td><?= $value['re_adm'] ?></td>
                                        <td><?= $value['re_lname'] . " " . $value['re_name'] ?></td>
                                        <td><?= $value['re_class'] ?></td>
                                        <td><?= $value['re_kcpe'] ?></td>
                                        <td><?= $value['re_marks'] ?></td>
                                        <td><?= $value['re_avgmarks'] ?></td>
                                        <td><?= $value['re_pnt'] ?></td>
                                        <td><?= $value['re_avgpnt'] ?></td>
                                        <td><?= $value['re_grade'] ?></td>
                                        <td><?= $value['re_srank'] ?></td>
                                        <td><?= $value['re_frank'] ?></td>
                                        <td><?= $value['vap'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <h6 class="text-danger m-0"><?= $data['noRec'] ?></h6>
                <?php } ?>
            </div>
        </div>

    <?php
        break;
    case "report_forms":

    ?>

        <div class="card shadow-sm border-0 h-100">
            <div class="card-body pb-0">
                <?php if (isMobile()) { ?>
                    <blockquote class="bg-light rounded m-0">
                        <h6>Important Notice!</h6>
                        Report Forms have been downloaded to your device, Kindly go to downloads to view the Report Forms.
                    </blockquote>
                    <iframe src="<?= ROOT . VIEWFOLDER ?>/pdf/report_forms/<?= $data['type'] ?>/<?= $data['exam'] ?>/<?= $data['class'] ?>/<?= $data['filter'] ?>" class="w-100 border-0 p-0" style="height: 0px;"></iframe>
                <?php } else { ?>
                    <iframe src="<?= ROOT . VIEWFOLDER ?>/pdf/report_forms/<?= $data['type'] ?>/<?= $data['exam'] ?>/<?= $data['class'] ?>/<?= $data['filter'] ?>" class="w-100 border" style="min-height: 450px;"></iframe>
                <?php } ?>
            </div>
        </div>

    <?php
        break;
    case "merit_pdf":
    ?>

        <div class="card shadow-sm border-0 h-100">
            <div class="card-body pb-0">
                <?php if (isMobile()) { ?>
                    <blockquote class="bg-light rounded m-0">
                        <h6>Important Notice!</h6>
                        Merit list have been downloaded to your device, Kindly go to downloads to view the merit list.
                    </blockquote>
                    <iframe src="<?= ROOT . VIEWFOLDER ?>/pdf/merit/<?= $data['exam'] ?>/<?= $data['class'] ?>" class="w-100 border-0 p-0" style="height: 0px;"></iframe>
                <?php } else { ?>
                    <iframe src="<?= ROOT . VIEWFOLDER ?>/pdf/merit/<?= $data['exam'] ?>/<?= $data['class'] ?>" class="w-100 border" style="min-height: 450px;"></iframe>
                <?php } ?>
            </div>
        </div>

        <?php
        break;
    case "merit":
        if (!(isset($data['noRec']))) {
            $appData = new App;
        ?>

            <form action="" method="post" class="resultsDelForm">
                <!-- control buttons -->
                <ul class="nav nav-pills theme2 mb-3 text-capitalize">
                    <li class="nav-item dropdown">
                        <a class="nav-link btn btn-sm btn-custom rounded-0 text-start" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-download"></i> Download | Print</a>
                        <ul class="dropdown-menu rounded-0 p-0">
                            <li><a class="dropdown-item" href="<?= ROOT . VIEWFOLDER ?>/report/merit_pdf/<?= $data['currentExam']['resExam'] . "/" . $data['currentExam']['resFullClass'] ?>"><i class="fas fa-file-pdf"></i> PDF</a></a></li>
                            <li><a class="dropdown-item" href="<?= ROOT . VIEWFOLDER ?>/excel/merit/<?= $data['currentExam']['resExam'] . "/" . $data['currentExam']['resFullClass'] ?>"><i class="fas fa-file-excel"></i> Excel</a></a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><button class="nav-link btn btn-sm btn-custom rounded-0 text-start"><i class="fas fa-trash-alt"></i> Delete Selected</button></li>
                </ul>
                <!-- / end control buttons -->
                <div class="card shadow-none border-0">
                    <div class="card-header h6 text-uppercase bg-white"><?= strtoupper($data['currentExam']['resHeading'] . ' - merit list.') ?></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover table-bordered text-nowrap align-middle mb-0 text-capitalize">
                                <!-- <table class="table table-striped table-sm table-hover table-bordered text-nowrap align-middle mb-0 text-capitalize" id="dataTable1"> -->
                                <thead class="bg-light">
                                    <tr>
                                        <th><input type="checkbox" onclick="$('input[name*=\'delResRec\']').prop('checked', this.checked);" /></th>
                                        <th>Adm</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>KCPE</th>
                                        <?php foreach ($data['currentExam']['schoolSubjects'] as $subject) { ?>
                                            <th><?= ucwords($subject->sub_short_name) ?></th>
                                        <?php } ?>
                                        <th>Count</th>
                                        <th>Marks</th>
                                        <th>Mean</th>
                                        <th>Pnt</th>
                                        <th>Avg</th>
                                        <th>Grade</th>
                                        <th>Rank</th>
                                        <th>Postn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!(isset($data['currentExam']['notFound']))) : ?>
                                        <?php foreach ($data['currentExam']['meritData'] as $record => $recordData) { ?>
                                            <tr class="clickable-tr">
                                                <td><input type="checkbox" name="delResRec[]" value="<?= $recordData['re_key'] ?>"></td>
                                                <td><?= $recordData['re_adm'] ?></td>
                                                <td><a href="<?= ROOT . VIEWFOLDER ?>/student/profile/<?= $record ?>"><?= "<b>" . strtoupper($recordData['re_lname']) . "</b> " . $recordData['re_name'] ?></a></td>
                                                <td><?= $recordData['re_class'] ?></td>
                                                <td><?= $recordData['re_kcpe'] ?></td>
                                                <?php foreach ($data['currentExam']['schoolSubjects'] as $subject) {
                                                    $subInfo = $appData->get_sub_data($subject->sub_code, $recordData["re_s" . $subject->sub_code]);
                                                ?>
                                                    <td><?= ucwords($subInfo['marks'] . " " . $subInfo['grade']) ?></td>
                                                <?php } ?>
                                                <td><?= $recordData['re_subC'] ?></td>
                                                <th class="text-danger"><?= $recordData['re_marks'] ?></th>
                                                <th class="text-primary"><?= $recordData['re_avgmarks'] ?></th>
                                                <th class="text-danger"><?= $recordData['re_pnt'] ?></th>
                                                <th class="text-primary"><?= $recordData['re_avgpnt'] ?></th>
                                                <th class="text-success"><?= $recordData['re_grade'] ?></th>
                                                <th><?= $recordData['re_srank'] ?></th>
                                                <th><?= $recordData['re_frank'] ?></th>
                                            </tr>
                                        <?php } ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>

        <?php
        } else {
        ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body"><?= $data['noRec'] ?></div>
            </div>
        <?php
        }
        break;
    default:
        ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body">No report selected for display</div>
        </div>

<?php
        break;
}
