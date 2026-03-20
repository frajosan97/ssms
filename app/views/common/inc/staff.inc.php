<?php

switch ($fileView) {
    case "create":
?>

        <form class="userRegForm">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 rounded-0 bg-transparent card-title">Create new Staff or Teacher account</div>
                <div class="pb-1 bg-light"></div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-4 mb-2">
                            <label for="user_gender" class="mb-2">Gender</label>
                            <select name="user_gender" id="user_gender" class="form-control" required>
                                <option value="">--Select Gender--</option>
                                <?php foreach (GENDER as $key => $value) { ?>
                                    <option value="<?= $key ?>"><?= ucwords($key) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="user_salutation" class="mb-2">Salutaion</label>
                            <select name="user_salutation" id="user_salutation" class="form-control" required>
                                <option value="">--Select Salutaion--</option>
                                <?php foreach (SALUTATION as $key => $value) { ?>
                                    <option value="<?= $value ?>"><?= ucwords($value) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="user_name" class="mb-2">User Name</label>
                            <input type="text" id="user_name" name="user_name" placeholder="User Name" class="form-control" oninput="checkUserName(this)" required>
                            <small id="userNameError"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 mb-2">
                            <label for="user_fname" class="mb-2">First Name</label>
                            <input type="text" id="user_fname" name="user_fname" placeholder="First Name" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="user_lname" class="mb-2">Sir Name</label>
                            <input type="text" id="user_lname" name="user_lname" placeholder="Sir Name" class="form-control" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 mb-2">
                            <label for="user_email" class="mb-2">Email</label>
                            <input type="user_email" id="user_email" name="user_email" placeholder="Email" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="user_phone" class="mb-2">Phone Number</label>
                            <input type="tel" id="user_phone" name="user_phone" placeholder="Phone Number" class="form-control" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 mb-2">
                            <label for="user_id" class="mb-2">ID Number</label>
                            <input type="number" id="user_id" name="user_id" placeholder="ID Number" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="user_snumber" class="mb-2">TSC / Staff Number</label>
                            <input type="text" id="user_snumber" name="user_snumber" placeholder="TSC / Staff Number" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 bg-transparent mb-2">
                    <button type="reset" class="btn btn-outline-danger float-start"><i class="fas fa-undo"></i> Reset</button>
                    <button type="submit" class="btn btn-outline-custom submitBtn float-end" disabled><i class="fas fa-user-plus"></i> Register Staff</button>
                </div>
            </div>
        </form>

    <?php
        break;
    case "profile":
    ?>

        <?php if (isset($data['profile'])) { ?>
            <style>
                #cover-photo {
                    width: 100%;
                    height: 150px;
                    background-image: url('<?= imageCheck("bg", APPINFO->sch_bg, "default.png") ?>');
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
                            <img id="profile-picture" src="<?= imageCheck("profiles", $data['profile']->user_pass, "avatar.png") ?>" class="img bg-white rounded-circle p-1 mb-2" style="max-height: 100px; max-width: 100px" />
                        </div>
                        <div class="col-md-10">
                            <div class="table-responsive bg-white rounded p-2 m-0">
                                <table class="table table-sm table-borderless text-nowrap bg-light border">
                                    <tr>
                                        <td class="p-0">Full Name:<strong> <?= strtoupper($data['profile']->user_fname . ' ' . $data['profile']->user_lname . ' [ ' . $data['profile']->user_salutation . ' ]'); ?></strong></td>
                                        <td class="p-0">User Name:<strong> <?= $data['profile']->user_name ?></strong></td>
                                        <td class="p-0">Position:<strong> <?= ucwords(userRole($data['profile']->user_role)) ?></strong></td>
                                        <td class="p-0">Access:<strong> <?= ucwords(userStatus($data['profile']->user_status)) ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="dividerDiv1 my-2">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-capitalize fw-bold active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true"><i class="fas fa-user-edit"></i> profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-capitalize fw-bold" id="subjects-tab" data-bs-toggle="tab" data-bs-target="#subjects-tab-pane" type="button" role="tab" aria-controls="subjects-tab-pane" aria-selected="false"><i class="fas fa-book"></i> subjects</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-capitalize fw-bold" id="classes-tab" data-bs-toggle="tab" data-bs-target="#classes-tab-pane" type="button" role="tab" aria-controls="classes-tab-pane" aria-selected="false"><i class="fas fa-university"></i> classes</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane border border-top-0 fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <!-- PROFILE MANAGEMENT -->
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="card border-0 shadow-none mb-0">
                                    <div class="card-body">
                                        <div class="row clearfix">
                                            <div class="col-md-4 mb-2">
                                                <label for="passport" class="form-label">Passport Photo</label>
                                                <div class="passport" id="getFileInput">
                                                    <input type="file" name="passport" accept=".jpg, .jpeg, .png" class="d-none fileInput" onchange="previewImg(this)">
                                                    <button class="btn btn-sm w-100 text-start btn-outline-custom file-upload" href="#"><i class="fas fa-image"></i> Change Passport Photo</button>
                                                </div>
                                            </div>
                                            <?php if ($_SESSION[VIEWFOLDER]->user_role > 1) : ?>
                                                <div class="col-md-4 mb-2">
                                                    <label for="user_role" class="form-label text-capitalize">Position / Department [Role]</label>
                                                    <select name="user_role" class="form-control form-control-sm" required>
                                                        <option value="">--Select position / Department [Role]--</option>
                                                        <?php foreach (STAFFTITLES as $key => $value) { ?>
                                                            <option value="<?= $key ?>" <?php if ($data['profile']->user_role == $key) : ?> selected <?php endif; ?>><?= ucwords($value) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label for="user_status" class="form-label text-capitalize">Status</label>
                                                    <select name="user_status" class="form-control form-control-sm" required>
                                                        <option value="">--Select Status--</option>
                                                        <?php foreach (STAFFSTATUS as $key => $value) { ?>
                                                            <option value="<?= $key ?>" <?php if ($data['profile']->user_status == $key) : ?> selected <?php endif; ?>><?= ucwords($value) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-md-4 mb-2">
                                                <label for="user_gender" class="form-label text-capitalize">Gender</label>
                                                <select name="user_gender" id="user_gender" class="form-control form-control-sm" required>
                                                    <option value="">--Select Gender--</option>
                                                    <?php foreach (GENDER as $key => $value) { ?>
                                                        <option value="<?= $key ?>" <?php if ($data['profile']->user_gender == $key) : ?> selected <?php endif; ?>><?= ucwords($key) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="user_salutation" class="form-label text-capitalize">salutation</label>
                                                <select name="user_salutation" id="user_salutation" class="form-control form-control-sm" required>
                                                    <option value="">--Select salutation--</option>
                                                    <?php foreach (SALUTATION as $key => $value) { ?>
                                                        <option value="<?= $value ?>" <?php if ($data['profile']->user_salutation == $value) : ?> selected <?php endif; ?>><?= ucwords($value) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="user_fname" class="form-label text-capitalize">first name</label>
                                                <input type="text" id="user_fname" placeholder="First Name" name="user_fname" value="<?= $data['profile']->user_fname ?>" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="user_lname" class="form-label text-capitalize">sir name</label>
                                                <input type="text" id="user_lname" placeholder="Sir Name" name="user_lname" value="<?= $data['profile']->user_lname ?>" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="user_id" class="form-label text-capitalize">ID Number</label>
                                                <input type="number" id="user_id" placeholder="ID Number" name="user_id" value="<?= $data['profile']->user_id ?>" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="user_phone" class="form-label text-capitalize">Phone Number</label>
                                                <input type="tel" id="user_phone" placeholder="Phone Number" name="user_phone" value="<?= '0' . $data['profile']->user_phone ?>" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="user_snumber" class="form-label text-capitalize">Staff Number</label>
                                                <input type="number" id="user_snumber" placeholder="Staff Number" name="user_snumber" value="<?= $data['profile']->user_snumber ?>" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="user_email" class="form-label text-capitalize">Staff Email</label>
                                                <input type="email" id="user_email" placeholder="Staff Email" name="user_email" value="<?= $data['profile']->user_email ?>" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="user_toemp" class="form-label text-capitalize">T.O.E</label>
                                                <select name="user_toemp" class="form-control form-control-sm" style="width: 100%" required>
                                                    <option value="">--Select T.O.E--</option>
                                                    <?php foreach (TEACHERTERMS as $key => $value) { ?>
                                                        <option value="<?= $value ?>" <?php if ($data['profile']->user_toemp == $value) : ?> selected <?php endif; ?>><?= ucwords($value) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="user_county" class="form-label text-capitalize">County</label>
                                                <select class="form-control form-control-sm" name="user_county" required>
                                                    <option value="">Select student county</option>
                                                    <?php foreach (COUNTIES as $county) { ?>
                                                        <option value="<?= $county ?>" <?php if ($county === $data['profile']->user_county) : ?> selected <?php endif; ?>><?= ucwords($county) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer border-0 bg-transparent mb-2">
                                        <button type="reset" class="btn btn-sm btn-outline-danger float-start"><i class="fas fa-undo"></i> Reset</button>
                                        <button type="submit" class="btn btn-sm btn-outline-custom float-end"><i class="fas fa-edit"></i> Update Student</button>
                                    </div>
                                </div>
                            </form>
                            <!-- / PROFILE MANAGEMENT -->
                        </div>
                        <div class="tab-pane border border-top-0 fade" id="subjects-tab-pane" role="tabpanel" aria-labelledby="subjects-tab" tabindex="0">
                            <!-- subjects -->
                            <div class="card border-0 shadow-none mb-0">
                                <div class="card-body">
                                    <blockquote class="m-0 mb-3 bg-light">
                                        <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#addTeacherSubject">Add subject for <?= strtoupper($data['profile']->user_fname . ' ' . $data['profile']->user_lname . ' [ ' . $data['profile']->user_salutation . ' ]'); ?></a>
                                    </blockquote>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover" id="dataTable3">
                                            <thead class="maincolor">
                                                <tr>
                                                    <th class="pw-5">#</th>
                                                    <th>Class</th>
                                                    <th>Subject</th>
                                                    <th class="pw-10">Students</th>
                                                    <th class="pw-10">Performance</th>
                                                    <th class="pw-10">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['subjects'] as $key => $value) { ?>
                                                    <?php $subInfo = $appData->subInfo($value->tsub_code); ?>
                                                    <?php $subStudents = $appData->subStudents(rawSmartKey($value->tsub_form . " " . $value->tsub_stream), $value->tsub_code); ?>
                                                    <tr>
                                                        <td><?= $sno++ ?></td>
                                                        <td><?= ucwords($value->tsub_form . " " . $value->tsub_stream) ?></td>
                                                        <td><?= ucwords($subInfo->sub_name) ?></td>
                                                        <td><a href="<?= ROOT . VIEWFOLDER ?>/classes/manage_sub/<?= rawSmartKey($value->tsub_form . " " . $value->tsub_stream) ?>/<?= $value->tsub_code ?>" class="btn btn-sm btn-outline-custom w-100"><i class="fas fa-list-alt"></i> <?= $subStudents ?> Students</a></td>
                                                        <td></td>
                                                        <td><button class="btn btn-sm btn-outline-danger w-100" onclick="deleteSubTeacher('<?= $value->id ?>')"><i class="fas fa-trash-alt"></i> Delete</button></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- / subjects -->
                        </div>
                        <div class="tab-pane border border-top-0 fade" id="classes-tab-pane" role="tabpanel" aria-labelledby="classes-tab" tabindex="0">
                            <!-- classes -->
                            <div class="card border-0 shadow-none mb-0">
                                <div class="card-body">
                                    The content that you are looking for is currently unavailable or its being updated, please keep checking for any posting
                                </div>
                            </div>
                            <!-- / classes -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addTeacherSubject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addTeacherSubjectLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 p-2">
                        <form class="addTeacherSubjectForm">
                            <div class="modal-header bg-light p-1">
                                <h1 class="modal-title fs-5" id="addTeacherSubjectLabel"><?= strtoupper("Add subject for " . $data['profile']->user_fname . ' ' . $data['profile']->user_lname . ' [ ' . $data['profile']->user_salutation . ' ]') ?></h1>
                                <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body border my-2">
                                <input type="hidden" name="teacher" value="<?= $data['profile']->user_key ?>">
                                <input type="hidden" name="postFrom" value="teacher">
                                <div class="form-group mb-2">
                                    <label for="">Class</label>
                                    <select class="form-control" name="class" required>
                                        <option value="">Select Class</option>
                                        <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) { ?>
                                            <option value="<?= $classNum ?>"><?= ucwords("form " . $classNum) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Stream</label>
                                    <select class="form-control" name="stream">
                                        <option value="">Select Stream</option>
                                        <?php foreach (STREAMS as $stream) { ?>
                                            <option value="<?= $stream->stream ?>"><?= ucwords($stream->stream) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Subjects</label>
                                    <select class="form-control" name="subject">
                                        <option value="">Select Subject</option>
                                        <?php foreach (SCHSUBJECTS as $subject) { ?>
                                            <?php $subInfo = $appData->subInfo($subject->sch_sub_code); ?>
                                            <option value="<?= $subInfo->sub_code ?>"><?= ucwords($subInfo->sub_name) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer bg-light p-1">
                                <button type="reset" class="btn btn-outline-danger"><i class="fas fa-history"></i> Reset</button>
                                <button type="submit" class="btn btn-outline-custom"><i class="fas fa-plus-circle"></i> Add Subject</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php } else { ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-danger">
                    There is no staff member found matching your search quesry!
                </div>
            </div>
        <?php } ?>

    <?php
        break;
    default:
    ?>

        <?php if (isset($data['staffData'])) { ?>
            <ul class="list-group list-group-horizontal-md mb-2 pb-2 rounded-0 border-bottom">
                <li class="list-group-item p-0 rounded-0 border-0 dropdown">
                    <a class="btn text-start border rounded-0 w-100" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <ul class="dropdown-menu rounded-0 p-0">
                        <li><a class="dropdown-item" href="<?= ROOT . VIEWFOLDER ?>/pdf/staff"><i class="fas fa-download"></i> PDF</a></li>
                        <li><a class="dropdown-item" href="<?= ROOT . VIEWFOLDER ?>/excel/staff"><i class="fas fa-download"></i> Excel</a></li>
                    </ul>
                </li>
            </ul>
            <div class="row clearfix">
                <?php foreach ($data['staffData'] as $user) { ?>
                    <div class="col-md-2 mb-2">
                        <div class="card border-0 h-100 shadow-sm">
                            <div class="card-body text-center">
                                <img src="<?= imageCheck("profiles", $user->user_pass, "avatar.png") ?>" class="img bg-white rounded-circle shadow-sm p-1 mb-2" style="max-height: 100px; max-width: 100px" />
                                <ul class="list-group">
                                    <li class="list-group-item border-0 p-0 rounded-0"><?= ucwords("<b>" . ucwords($user->user_salutation) . ".</b> " . $user->user_fname . " " . $user->user_lname) ?></li>
                                    <li class="list-group-item border-0 p-0 py-1 rounded-0"><span class="bg-light rounded-pill px-4"><?= $user->user_name ?></span></li>
                                </ul>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-center">
                                <a href="<?= ROOT . VIEWFOLDER . "/staff/profile/" . $user->user_key ?>" class="btn btn-sm btn-custom rounded-pill shadow-sm"><i class="fa fa-eye"></i> | <i class="fa fa-pencil"></i></a>
                                <button class="btn btn-sm btn-danger rounded-circle shadow-sm" onclick="deleteStaff('<?= $user->user_key ?>')"><i class="fa fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="card shadow-sm border-0">
                <div class="card-body text-danger">No staff records for this school available for display!</div>
            </div>
        <?php } ?>


<?php
        break;
}
