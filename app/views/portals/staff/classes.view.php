<!-- control buttons -->
<ul class="nav nav-pills theme2 mb-3 text-capitalize">
    <li class="nav-item"> <span class="nav-link btn btn-sm rounded-0 btn-custom text-start" onclick="location.href='<?= ROOT . 'staff/classes' ?>'"><i class="fas fa-cogs"></i> Manage classes</span></li>
    <li class="nav-item"> <span class="nav-link btn btn-sm rounded-0 btn-custom text-start" onclick="location.href='<?= ROOT . 'staff/classes/create' ?>'"><i class="fas fa-plus-circle"></i> Add new class</span></li>
</ul>
<!-- / end control buttons -->

<?php

switch ($fileView) {
    case "create":
?>

        <div class="card border-0 shadow-sm">
            <div class="card-header">SCHOOL STREAMS MANAGEMENT</div>
            <div class="card-body">
                <blockquote class="bg-light rounded m-0 mb-3">
                    <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#addStream" class="btn btn-outline-custom btn-sm fw-bold"><i class="fas fa-plus-circle"></i> ADD STREAM</a>
                    <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#addClass" class="btn btn-outline-custom btn-sm fw-bold"><i class="fas fa-plus-circle"></i> ADD CLASS</a>
                </blockquote>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover" id="dataTable1">
                        <thead class="maincolor">
                            <tr>
                                <th width="5%">#</th>
                                <th>Stream</th>
                                <th>Add by</th>
                                <th>Date</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['schoolStreams'])) :
                                foreach ($data['schoolStreams'] as $stream) { ?>
                                    <tr>
                                        <td><?= $sno++ ?>.</td>
                                        <td><?= ucwords($stream->stream) ?></td>
                                        <td><?= ucwords($stream->addby) ?></td>
                                        <td><?= date("d/m/Y", strtotime($stream->date)) ?></td>
                                        <td><button class="btn btn-outline-danger btn-sm w-100"><i class="fas fa-trash-alt"></i> Delete</button></td>
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
    case "manage_sub":
    ?>

        <form action="" method="post">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-1">
                    <ul class="list-group list-group-horizontal m-0 border-0 bg-light">
                        <li class="list-group-item bg-transparent border-0 p-1"> <span class="btn btn-sm btn-outline-custom" onclick="printDiv('subList')"><i class="fas fa-print"></i> Print</span> </li>
                        <li class="list-group-item bg-transparent border-0 p-1"> <button name="updateStatus" value="activate" class="btn btn-sm btn-outline-success"><i class="fas fa-plus-circle"></i> Activate Selected</button> </li>
                        <li class="list-group-item bg-transparent border-0 p-1"> <button name="updateStatus" value="drop" class="btn btn-sm btn-outline-danger"><i class="fas fa-minus-circle"></i> Drop Selected</button> </li>
                    </ul>
                </div>
            </div>
            <div class="card border-0 shadow-sm" id="subList">
                <div class="card-header bg-transparent border-0 pb-0">
                    <table class="table table-sm table-borderless mb-0 align-middle">
                        <tr>
                            <th class="pw-5"><img src="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>" alt=""></th>
                            <td class="text-center">
                                <h5 class="m-0"><?= strtoupper(APPINFO->sch_name) ?></h5>
                                <h6 class="m-0">P.O Box <?= ucwords(APPINFO->sch_address . ' - ' . APPINFO->sch_postcode . ', ' . APPINFO->sch_town) ?></h6>
                                <small class="text-danger"><i><?= ucwords(APPINFO->sch_moto) ?></i></small>
                                <h6><?= strtoupper($data['heading']) ?></h6>
                            </td>
                            <th class="pw-5"></th>
                        </tr>
                    </table>
                    <hr class="dividerDiv1" />
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered text-nowrap text-capitalize">
                            <thead class="bg-light">
                                <tr>
                                    <th class="pw-2"><input type="checkbox" onclick="$('input[name*=\'checkedStudKeys\']').prop('checked', this.checked);" /><span class="d-none">S/NO</span></th>
                                    <th class="pw-10">Adm</th>
                                    <th class="pw-10">Class</th>
                                    <th>Student Name</th>
                                    <th class="pw-10">Status</th>
                                    <th class="pw-20 text-center">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($data["students"])) {
                                    foreach ($data["students"] as $student => $studentData) {  ?>
                                        <tr>
                                            <td><input type="checkbox" name="checkedStudKeys[]" value="<?= $student ?>"></td>
                                            <td><?= ucwords($studentData['stud_adm']) ?></td>
                                            <td><?= ucwords($studentData['stud_class']) ?></td>
                                            <td><a href="<?= ROOT ?>staff/student/profile/<?= $studentData['stud_key'] ?>"><?= ucwords($studentData['stud_name']) ?></a></td>
                                            <td><?= subStatus($studentData['sub_status']) ?></td>
                                            <td></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td class="text-center" colspan="6">No student registered for the selected subject</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>

    <?php
        break;
    case "subjects":
    ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header"><?= strtoupper("managing form " . str_replace("-", " ", $data['class']) . " subjects") ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped text-nowrap table-hover text-capitalize">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th class="pw-10">Students</th>
                                <th class="pw-30">Subject Teacher</th>
                                <th class="pw-10">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data["subjects"])) {
                                foreach ($data["subjects"] as $subject) { ?>
                                    <tr>
                                        <td><?= $subject['sub_code'] . " " . $subject['sub_name'] ?></td>
                                        <td><?= $subject['sub_count'] ?></td>
                                        <td>
                                            <select name="" class="form-control form-control-sm" onchange="addSTeacher(this,'<?= $subject['sub_code'] ?>','<?= rawSmartKey($data['class']) ?>')">
                                                <option value="">--Select Subject Teacher--</option>
                                                <?php foreach ($data['staffData'] as $staff) { ?>
                                                    <option value="<?= $staff->user_key ?>" <?php if ($subject['sub_teacher'] == $staff->user_key) : ?>selected<?php endif; ?>><?= ucwords("<b>" . ucwords($staff->user_salutation) . ".</b> " . $staff->user_fname . " " . $staff->user_lname) ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="text-center"><a href="<?= ROOT . "staff/classes/manage_sub/" . rawSmartKey($data['class']) . "/" . rawSmartKey($subject['sub_code']) ?>" class="btn btn-sm btn-custom"><i class="fas fa-cogs"></i> Manage</a></td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center">School subjects not set yet, ensure you go to manage school subjects to enable this!</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php
        break;
    case "streams":
    ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header"><?= strtoupper("managing form " . $data['class'] . " streams") ?></div>
            <div class="card-body">
                <?php
                if (isset($data['classInfo']['streams'])) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-condensed text-nowrap text-capitalize align-middle table-striped table-hover">
                            <thead class="maincolor">
                                <tr>
                                    <th>Stream</th>
                                    <?php if (APPINFO->sch_type === "mixed") : ?>
                                        <?php foreach (GENDER as $genderKey => $gender) { ?>
                                            <th class="pw-10"><?= $gender ?></th>
                                        <?php } ?>
                                    <?php endif; ?>
                                    <th class="pw-10">Total Students</th>
                                    <th>Managed By</th>
                                    <th class="pw-5 text-center" colspan="3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($data['classInfo']['streams']) > 0) {
                                    foreach ($data['classInfo']['streams'] as $key => $value) { ?>
                                        <tr>
                                            <td><?= $key ?></td>
                                            <?php if (APPINFO->sch_type === "mixed") : ?>
                                                <?php foreach (GENDER as $genderKey => $gender) { ?>
                                                    <td class="pw-10"><?= $value[$gender] ?></td>
                                                <?php } ?>
                                            <?php endif; ?>
                                            <td class="pw-10"><?= $value['total'] ?></td>
                                            <td>
                                                <select name="" class="form-control form-control-sm" onchange="addCTeacher(this,'<?= $value['streamKey'] ?>')">
                                                    <option value="">--Select Class Manager--</option>
                                                    <?php foreach ($data['staffData'] as $staff) { ?>
                                                        <option value="<?= $staff->user_key ?>" <?php if ($value['teacher'] == $staff->user_key) : ?>selected<?php endif; ?>><?= ucwords("<b>" . ucwords($staff->user_salutation) . ".</b> " . $staff->user_fname . " " . $staff->user_lname) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td><a href="<?= ROOT . VIEWFOLDER ?>/classes/subjects/<?= $data['class'] . "/" . $key ?>" class="btn btn-outline-custom btn-sm"><i class="fas fa-book"></i> Subjects</a></td>
                                            <td><a href="<?= ROOT . VIEWFOLDER ?>/student/<?= $data['class'] . "/" . $key ?>" class="btn btn-outline-custom btn-sm"><i class="fas fa-list-alt"></i> Class List</a></td>
                                            <td><a href="javascript.void:(0)" onclick="deleteClass('<?= trim($value['streamKey']) ?>')" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td class="text-center" colspan="7">No streams added for this class</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Totals</th>
                                    <?php if (APPINFO->sch_type === "mixed") : ?>
                                        <?php foreach (GENDER as $genderKey => $gender) { ?>
                                            <th class="pw-10"><?= $data['classInfo'][$gender] ?></th>
                                        <?php } ?>
                                    <?php endif; ?>
                                    <th><?= $data['classInfo']['total'] ?></th>
                                    <th colspan="4" class="bg-light"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php } else { ?>
                    Wrong redirectory!
                <?php } ?>
            </div>
        </div>

    <?php
        break;
    default:
    ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header">SCHOOL CLASSES MANAGEMENT</div>
            <div class="card-body">
                <?php if (isset($data['classData'])) { ?>
                    <blockquote class="bg-light rounded m-0 mb-3">The school has a total of <b><?= count($data['classData']) ?></b> registered classes</blockquote>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-condensed text-nowrap text-capitalize align-middle table-striped table-hover">
                            <thead class="maincolor">
                                <tr>
                                    <th>Form</th>
                                    <?php if (APPINFO->sch_type === "mixed") : ?>
                                        <?php foreach (GENDER as $genderKey => $gender) { ?>
                                            <th><?= $gender ?></th>
                                        <?php } ?>
                                    <?php endif; ?>
                                    <th>Total Students</th>
                                    <th>Managed By</th>
                                    <th class="pw-5 text-center" colspan="4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach (GENDER as $genderKey => $gender) {
                                    $$gender = 0;
                                }
                                $streams = 0;
                                foreach ($data['classData'] as $key => $value) {
                                    $total += $value['total'];
                                    $streams += $value['streamCount'];
                                ?>
                                    <tr>
                                        <td><?= "form " . $key ?></td>
                                        <?php if (APPINFO->sch_type === "mixed") : ?>
                                            <?php foreach (GENDER as $genderKey => $gender) {
                                                $$gender += $value[$gender];
                                            ?>
                                                <td><?= $value[$gender] ?></td>
                                            <?php } ?>
                                        <?php endif; ?>
                                        <td><?= $value['total'] ?></td>
                                        <td>
                                            <select class="form-control form-control-sm" onchange="addCTeacher(this,'<?= trim($value['classKey']) ?>')">
                                                <option value="">--Select Class Manager--</option>
                                                <?php foreach ($data['staffData'] as $staff) { ?>
                                                    <option value="<?= $staff->user_key ?>" <?php if ($value['teacher'] == $staff->user_key) : ?>selected<?php endif; ?>><?= ucwords("<b>" . ucwords($staff->user_salutation) . ".</b> " . $staff->user_fname . " " . $staff->user_lname) ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td><a href="<?= ROOT . VIEWFOLDER ?>/classes/streams/<?= trim($key) ?>" class="btn btn-outline-custom btn-sm"><i class="fas fa-university"></i> Streams [<?= $value['streamCount'] ?>]</a></td>
                                        <td><a href="<?= ROOT . VIEWFOLDER ?>/classes/subjects/<?= trim($key) ?>" class="btn btn-outline-custom btn-sm"><i class="fas fa-book"></i> Subjects</a></td>
                                        <td><a href="<?= ROOT . VIEWFOLDER ?>/student/<?= trim($key) ?>" class="btn btn-outline-custom btn-sm"><i class="fas fa-list-alt"></i> Class List</a></td>
                                        <td><a href="javascript.void:(0)" onclick="deleteClass('<?= trim($value['classKey']) ?>')" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Totals</th>
                                    <?php if (APPINFO->sch_type === "mixed") : ?>
                                        <?php foreach (GENDER as $genderKey => $gender) { ?>
                                            <th class="pw-10"><?= $$gender ?></th>
                                        <?php } ?>
                                    <?php endif; ?>
                                    <th><?= $total ?></th>
                                    <th class="bg-light"></th>
                                    <th class="bg-light" colspan="4">Total registered streams: <?= $streams ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php } else { ?>
                    Wrong redirectory!
                <?php } ?>
            </div>
        </div>

<?php
        break;
}
