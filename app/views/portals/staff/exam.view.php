<?php

switch ($fileView) {
    case "create":

?>

        <form class="createMartksEntryForm">
            <div class="card border-0 shadow-sm">
                <?php if (!(isset($data['examRegError']))) { ?>
                    <div class="card-header text-uppercase"><?= $data['heading'] ?></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col">
                                <label for="examForm" class="mb-1">Form / Class</label>
                                <select name="examForm" id="examForm" class="form-control" required>
                                    <option value="">--Select Form / Class--</option>
                                    <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) { ?>
                                        <option value="<?= $classNum ?>">Form <?= $classNum ?></option>
                                    <?php } ?>
                                    <option value="all" selected>All Classes</option>
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="examOutOf" class="mb-1">Exam Out Of</label>
                                <input type="number" name="examOutOf" id="examOutOf" placeholder="Exam Out Of e.g 100" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent pb-3">
                        <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset</button>
                        <button class="btn btn-outline-custom float-end"><i class="fas fa-save"></i> Create List</button>
                    </div>
                <?php } else { ?>
                    <div class="card-body text-danger text-uppercase"><?= ucfirst($data['examRegError']) ?></div>
                <?php } ?>
            </div>
        </form>

    <?php
        break;
    case "entry":
    ?>

        <form class="marksEntryRequestForm">
            <div class="card border-0 shadow-sm">
                <?php if (!(isset($data['examRegError']))) { ?>
                    <div class="card-header text-uppercase">REQUEST STUDENTS LIST FOR MARKS ENTRY</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <label for="re_studF" class="mb-1">Form / Class</label>
                                <select name="re_studF" id="re_studF" class="form-control" required>
                                    <option value="">--Select Form / Class--</option>
                                    <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) { ?>
                                        <option value="<?= $classNum ?>">Form <?= $classNum ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="re_studS" class="mb-1">Stream ( Optional )</label>
                                <select name="re_studS" id="re_studS" class="form-control">
                                    <option value="">--Select Stream ( Optional )--</option>
                                    <?php foreach (STREAMS as $stream) { ?>
                                        <option value="<?= $stream->stream ?>"><?= ucwords($stream->stream) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="subject" class="mb-1">Subject</label>
                                <select name="subject" id="subject" class="form-control" required>
                                    <option value="">--Select Subject--</option>
                                    <?php foreach (SCHSUBJECTS as $subject) {
                                        $app = new App;
                                        $thisSub = $app->subInfo($subject->sch_sub_code);
                                    ?>
                                        <option value="<?= $thisSub->sub_code ?>"><?= ucwords("[ " . $thisSub->sub_code . " ] " . $thisSub->sub_name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent pb-3">
                        <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset</button>
                        <button class="btn btn-outline-custom float-end"><i class="fas fa-tasks"></i> Request List</button>
                    </div>
                <?php } else { ?>
                    <div class="card-body text-danger text-uppercase"><?= ucfirst($data['examRegError']) ?></div>
                <?php } ?>
            </div>
        </form>

    <?php
        break;
    case "marks_entry":
    ?>

        <form class="marksEntryForm">
            <div class="card border-0 shadow-sm">
                <?php if (!(isset($data['marksEntryError']))) { ?>
                    <div class="card-header"><?= strtoupper($data["heading"]) ?></div>
                    <div class="card-body">
                        <blockquote class="m-0 mb-2 rounded bg-light">
                            <a href="<?= ROOT ?>staff/exam/entry" class="btn btn-sm btn-outline-custom"><i class="fas fa-arrow-left"></i> Back to Entry Request</a>
                            <!-- <a href="" class="btn btn-sm btn-outline-custom"><i class="fas fa-download"></i> Download Excel List</a>
                            <a href="" class="btn btn-sm btn-outline-custom"><i class="fas fa-upload"></i> Upload Excel List</a> -->
                        </blockquote>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped text-capitalize m-0 table-bordered">
                            <!-- <table class="table table-sm table-striped text-capitalize m-0" id="dataTable1"> -->
                                <thead class="text-nowrap bg-light">
                                    <tr>
                                        <th class="pw-1">Adm</th>
                                        <th>Name</th>
                                        <th>Score</th>
                                        <th>Percentage</th>
                                        <th>Grade</th>
                                        <th>Points</th>
                                        <th>Comment</th>
                                        <th>Teacher</th>
                                        <th class="pw-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data['entryData'])) : foreach ($data["entryData"] as $value) { ?>
                                            <tr>
                                                <input type="hidden" name="re_key[]" value="<?= $value['re_key'] ?>">
                                                <td><?= $value['stud_adm'] ?></td>
                                                <td><a href="<?= ROOT ?>staff/student/profile/<?= $value['stud_key'] ?>"><?= $value['stud_name'] ?></a></td>
                                                <td><input type="number" name="score[]" class="form-control form-control-sm bg-transparent" value="<?php if ($value['sub_score'] > 0) : ?><?= $value['sub_score'] ?><?php endif; ?>" placeholder="Score" min="0" max="<?= $value['sub_max_score'] ?>" step="any" /></td>
                                                <td><?= $value['sub_percent'] . " %" ?></td>
                                                <td><?= $value['sub_grade'] ?></td>
                                                <td><?= $value['sub_points'] ?></td>
                                                <td><?= $value['sub_remarks'] ?></td>
                                                <td><?= $value['sub_teacher'] ?></td>
                                                <td><button class="btn btn-sm btn-outline-custom w-100 text-nowrap"><i class="fa fa-save"></i> Save</button></td>
                                            </tr>
                                    <?php }
                                    endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent pb-3">
                        <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset</button>
                        <button class="btn btn-outline-custom float-end"><i class="fas fa-save"></i> Save Edited</button>
                    </div>
                <?php } else { ?>
                    <div class="card-body text-danger"><?= ucfirst($data['marksEntryError']) ?></div>
                <?php } ?>
            </div>
        </form>

<?php
        break;
    default:
        break;
}
