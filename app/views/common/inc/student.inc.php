<?php

$appData = new App;
switch ($fileView) {
    case "create":
?>

        <div class="card border-0 shadow-sm bg-img">
            <div class="card-header text-warning fw-bold border-light py-1 text-uppercase">You want to register more than 1 students at once ? Use this tab</div>
            <div class="card-body">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <a href="<?= ROOT ?>public/assets/docs/regdocs/stud_reg_form.xlsx" class="btn btn-sm btn-light mb-2 text-start" download><i class="fas fa-download"></i> Download students data entry excel template</a>
                        <form class="studRegForm" enctype="multipart/form-data">
                            <div class="form-group row">
                                <h6 class="text-light m-0 mb-1">Select the filled excel to upload</h6>
                                <div class="col-auto">
                                    <input type="file" name="studentsExel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-auto">
                                    <button name="loadStudExcelData" class="btn btn-light btn-sm"><i class="fas fa-upload"></i> Upload List</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form class="bulkStudPassForm" enctype="multipart/form-data">
                            <div class="form-group row">
                                <h6 class="text-light m-0 mb-1">Upload Students Passport in bulk</h6>
                                <div class="col-auto">
                                    <input type="file" name="passports[]" accept=".jpg, .jpeg, .png" class="form-control form-control-sm me-2" required>
                                </div>
                                <div class="col-auto">
                                    <button name="loadStudExcelData" class="btn btn-light btn-sm"><i class="fas fa-upload"></i> Upload Passports</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- single student registration -->
        <div class="card border-0 shadow-sm">
            <form class="studRegForm">
                <div class="card-header text-muted text-uppercase">REGISTER SINGLE STUDENT</div>
                <div class="card-body pb-0">
                    <div class="form-group row">
                        <div class="col-md-6 col-lg-4 my-2">
                            <input type="text" class="form-control" name="stud_lname" placeholder="Sir Name e.g Kilonzo" required>
                        </div>
                        <div class="col-md-6 col-lg-4 my-2">
                            <input type="text" class="form-control" name="stud_fname" placeholder="First Name e.g Francis" required>
                        </div>
                        <div class="col-md-6 col-lg-4 my-2">
                            <input type="text" class="form-control" name="stud_oname" placeholder="Other Name e.g Kioko ( Optional )">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 col-lg-4 my-2">
                            <input type="number" class="form-control" name="stud_adm" value="<?= (LATEST_ADM + 1) ?>" placeholder="Admission Number" required>
                        </div>
                        <div class="col-md-6 col-lg-4 my-2">
                            <select class="form-control" name="stud_form" required>
                                <option value="">Select Class</option>
                                <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) { ?>
                                    <option value="<?= $classNum ?>"><?= $classNum ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-4 my-2">
                            <select class="form-control" name="stud_stream">
                                <option value="">Select Stream</option>
                                <?php foreach (STREAMS as $stream) { ?>
                                    <option value="<?= $stream->stream ?>"><?= $stream->stream ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 col-lg-6 my-2">
                            <select class="form-control" name="stud_gender" required>
                                <option value="">Select Student Gender</option>
                                <?php foreach (GENDER as $genderKey => $gender) { ?>
                                    <option value="<?= $genderKey ?>" <?php if (APPINFO->sch_type === $genderKey) : ?> selected <?php endif; ?>><?= $gender ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-6 my-2">
                            <select class="form-control" name="stud_cat" required>
                                <option value="">Select student category</option>
                                <option value="day" <?php if (APPINFO->sch_category === "day") : ?> selected <?php endif; ?>>Day School</option>
                                <option value="boarding" <?php if (APPINFO->sch_category === "boarding") : ?> selected <?php endif; ?>>Bording School</option>
                                <option value="day-boarding" <?php if (APPINFO->sch_category === "day-boarding") : ?> selected <?php endif; ?>>Day / Bording School</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 col-lg-6 my-2">
                            <input type="number" class="form-control" name="stud_kcpe_index" placeholder="KCPE Index Number" />
                        </div>
                        <div class="col-md-6 col-lg-6 my-2">
                            <input type="number" class="form-control" name="stud_kcpe_marks" placeholder="KCPE Marks" max="500" value="0" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 col-lg-6 my-2">
                            <input type="date" class="form-control" name="stud_birth_date" />
                        </div>
                        <div class="col-md-6 col-lg-6 my-2">
                            <input type="number" class="form-control" name="stud_birth_cert" placeholder="Birth Certificate Number" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 col-lg-6 my-2">
                            <select class="form-control" name="stud_county" required>
                                <option value="">Select student county</option>
                                <?php foreach (COUNTIES as $county) { ?>
                                    <option value="<?= $county ?>" <?php if ($county === APPINFO->sch_city) : ?> selected <?php endif; ?>><?= ucwords($county) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-6 my-2">
                            <input type="tel" class="form-control" name="stud_phone" placeholder="Phone Number E.g ( 0796594366 )" maxlength="10" required />
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 bg-transparent mb-2">
                    <button type="reset" class="btn btn-outline-danger float-start"><i class="fas fa-undo"></i> Reset</button>
                    <button class="btn btn-outline-custom float-end"><i class="fas fa-user-plus"></i> Register Student</button>
                </div>
            </form>
        </div>

    <?php
        break;
    case "search":
    ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form class="studentSearchForm">
                    <a href="<?= ROOT . VIEWFOLDER ?>/student" class="btn btn-sm btn-outline-custom mb-2"><i class="fas fa-users"></i> Go to all students <i class="fas fa-external-link"></i></a>
                    <blockquote class="bg-light m-0 mb-3">
                        <div class="row clearfix">
                            <div class="col-md-3 my-1">
                                <label for="stud_adm">SEARCH BY: REG/ADM</label>
                                <input type="search" name="stud_adm" placeholder="REG/ADM Number" class="form-control form-control-sm searchInput" />
                            </div>
                            <div class="col-md-3 my-1">
                                <label for="stud_lname">Sir Name</label>
                                <input type="search" name="stud_lname" placeholder="Last Name" class="form-control form-control-sm searchInput" />
                            </div>
                            <div class="col-md-3 my-1">
                                <label for="stud_fname">First Name</label>
                                <input type="search" name="stud_fname" placeholder="First Name" class="form-control form-control-sm searchInput" />
                            </div>
                            <div class="col-md-3 my-1">
                                <label for="stud_phone">Phone Number</label>
                                <input type="search" name="stud_phone" placeholder="Phone Number" class="form-control form-control-sm searchInput" />
                            </div>
                        </div>
                    </blockquote>
                </form>
                <div class="table-responsive border p-2">
                    <table class="table table-sm table-striped text-capitalize" id="dataTable1">
                        <thead class="text-nowrap bg-light">
                            <tr>
                                <th>#</th>
                                <?php foreach (STUDEXPORTDATA as $exportKey) { ?>
                                    <th><?= str_replace("stud_", "", $exportKey) ?></th>
                                <?php } ?>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="searchData"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.searchInput').on('input', function() {
                    $('.studentSearchForm').submit();
                });
            });
        </script>

    <?php
        break;
    case "profile":
    ?>

        <?php if (isset($data['stud_profile'])) { ?>
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
                            <img id="profile-picture" src="<?= imageCheck("profiles", $data['stud_profile']->stud_pass, "avatar.png") ?>" class="img bg-white rounded-circle p-1 mb-2" style="max-height: 100px; max-width: 100px" />
                        </div>
                        <div class="col-md-10">
                            <div class="table-responsive bg-white rounded p-2 m-0">
                                <table class="table table-sm table-borderless text-nowrap bg-light border text-capitalize">
                                    <tr>
                                        <td class="p-0">Full Name:<strong> <?= $data['stud_profile']->stud_lname . " " . $data['stud_profile']->stud_fname . " " . $data['stud_profile']->stud_oname ?></strong></td>
                                        <td class="p-0">Reg/Adm Number:<strong> <?= $data['stud_profile']->stud_adm ?></strong></td>
                                        <td class="p-0">Class / Form:<strong> <?= $data['stud_profile']->stud_form . " " . $data['stud_profile']->stud_stream ?></strong></td>
                                        <td class="p-0">Status:<strong> <?= ucwords($data['stud_profile']->stud_status) ?></strong></td>
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
                            <button class="nav-link text-capitalize fw-bold" id="exams-tab" data-bs-toggle="tab" data-bs-target="#exams-tab-pane" type="button" role="tab" aria-controls="exams-tab-pane" aria-selected="false"><i class="fas fa-folder-open"></i> exams</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-capitalize fw-bold" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance-tab-pane" type="button" role="tab" aria-controls="finance-tab-pane" aria-selected="false"><i class="fas fa-wallet"></i> finance</button>
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
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_adm" class="form-label">admission number</label>
                                                <input type="number" name="stud_adm" value="<?= $data['stud_profile']->stud_adm ?>" id="stud_adm" placeholder="Admission Number" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_status" class="form-label">Student Status</label>
                                                <select class="form-control form-control-sm" name="stud_status" id="stud_status">
                                                    <option value="active" <?php if ($data['stud_profile']->stud_status === "active") : ?> selected <?php endif; ?>>active</option>
                                                    <option value="suspended" <?php if ($data['stud_profile']->stud_status === "suspended") : ?> selected <?php endif; ?>>suspended</option>
                                                    <option value="dormant" <?php if ($data['stud_profile']->stud_status === "dormant") : ?> selected <?php endif; ?>>dormant</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_lname" class="form-label">sir name</label>
                                                <input type="text" name="stud_lname" value="<?= $data['stud_profile']->stud_lname ?>" id="stud_lname" placeholder="Sir Name" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_fname" class="form-label">first name</label>
                                                <input type="text" name="stud_fname" value="<?= $data['stud_profile']->stud_fname ?>" id="stud_fname" placeholder="First Name" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_oname" class="form-label">other name</label>
                                                <input type="text" name="stud_oname" value="<?= $data['stud_profile']->stud_oname ?>" id="stud_oname" placeholder="Other Name" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_gender" class="form-label">gender</label>
                                                <select class="form-control form-control-sm" name="stud_gender" id="stud_gender">
                                                    <option value="">Select Student Gender</option>
                                                    <?php foreach (GENDER as $genderKey => $gender) { ?>
                                                        <option value="<?= $genderKey ?>" <?php if ($data['stud_profile']->stud_gender === $genderKey) : ?> selected <?php endif; ?>><?= $gender ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_form" class="form-label">form</label>
                                                <select class="form-control form-control-sm" name="stud_form" id="stud_form">
                                                    <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) { ?>
                                                        <option value="<?= $classNum ?>" <?php if ($data['stud_profile']->stud_form == $classNum) : ?> selected <?php endif; ?>><?= $classNum ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_stream" class="form-label">stream</label>
                                                <select class="form-control form-control-sm" name="stud_stream" id="stud_stream">
                                                    <option value="">--select stream--</option>
                                                    <?php if (STREAMS) : ?>
                                                        <?php foreach (STREAMS as $stream) { ?>
                                                            <option value="<?= $stream->stream ?>" <?php if ($data['stud_profile']->stud_stream === $stream->stream) : ?> selected <?php endif; ?>><?= $stream->stream ?></option>
                                                        <?php } ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_cat" class="form-label">category</label>
                                                <select class="form-control form-control-sm" name="stud_cat" id="stud_cat">
                                                    <option value="">Select student category</option>
                                                    <?php foreach (SCHCATEGORIES as $category) { ?>
                                                        <option value="<?= $category ?>" <?php if ($data['stud_profile']->stud_cat === $category) : ?> selected <?php endif; ?>><?= str_replace("-", " /", $category) . " schoool" ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_kcpe_index" class="form-label">KCPE Index</label>
                                                <input type="number" name="stud_kcpe_index" value="<?= $data['stud_profile']->stud_kcpe_index ?>" id="stud_kcpe_index" placeholder="KCPE Index Number" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_kcpe_marks" class="form-label">KCPE Marks</label>
                                                <input type="number" name="stud_kcpe_marks" value="<?= $data['stud_profile']->stud_kcpe_marks ?>" id="stud_kcpe_marks" placeholder="KCPE Marks" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_birth_cert" class="form-label">B. Cert No.</label>
                                                <input type="number" name="stud_birth_cert" value="<?= $data['stud_profile']->stud_birth_cert ?>" id="stud_birth_cert" placeholder="Birth Cerificate No." class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_birth_date" class="form-label">B. Dates</label>
                                                <input type="date" name="stud_birth_date" value="<?= $data['stud_profile']->stud_birth_date ?>" id="stud_birth_date" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="stud_phone" class="form-label">Parent Phone No.</label>
                                                <input type="tel" name="stud_phone" value="<?= $data['stud_profile']->stud_phone ?>" id="stud_phone" placeholder="Parent Phone Number" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer border-0 bg-transparent mb-2">
                                        <button type="reset" class="btn btn-sm btn-outline-danger float-start"><i class="fas fa-undo"></i> Reset</button>
                                        <button class="btn btn-sm btn-outline-custom float-end"><i class="fas fa-edit"></i> Update Student</button>
                                    </div>
                                </div>
                            </form>
                            <!-- / PROFILE MANAGEMENT -->
                        </div>
                        <div class="tab-pane border border-top-0 fade" id="subjects-tab-pane" role="tabpanel" aria-labelledby="subjects-tab" tabindex="0">
                            <!-- SUBJECTS -->
                            <div class="card border-0 shadow-none mb-0">
                                <div class="card-body">
                                    <?php if (VIEWFOLDER == "staff") { ?>
                                        <form action="" method="post" class="manageSubjectsForm">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover mb-0" id="dataTable1">
                                                    <thead class="maincolor">
                                                        <tr>
                                                            <th class="pw-3"><input type="checkbox" onclick="$('input[name*=\'subCode\']').prop('checked', this.checked);" /></th>
                                                            <th>Subject</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($data["stud_subjects"] as $category => $value) {
                                                            foreach ($value as $subject) { ?>
                                                                <tr>
                                                                    <td><input type="checkbox" name="subCode[]" value="<?= $subject->sub_code ?>"></td>
                                                                    <input type="hidden" name="subUp[]" value="<?= $subject->sub_code ?>">
                                                                    <td><?= $subject->sub_code . " " . $subject->sub_name ?></td>
                                                                    <td><?= subStatus($category) ?></td>
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-12 pt-2 text-end">
                                                <button name="updateSubjects" value="dropped" class="btn btn-sm btn-danger"> Drop Selected</button>
                                                <button name="updateSubjects" value="active" class="btn btn-sm btn-success"> Activate Selected</button>
                                            </div>
                                        </form>
                                    <?php } else { ?>
                                        <span class="text-danger">You have no permission to access this content!</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- / SUBJECTS -->
                        </div>
                        <div class="tab-pane border border-top-0 fade" id="exams-tab-pane" role="tabpanel" aria-labelledby="exams-tab" tabindex="0">
                            <!-- EXAMS -->
                            <div class="card border-0 shadow-none mb-0">
                                <div class="card-body">
                                    <?php if (VIEWFOLDER == "staff") { ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover m-0" id="dataTable2">
                                                <thead class="maincolor text-capitalize">
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
                                                    <?php if (count($data['results']) > 0) :
                                                        foreach ($data['results'] as $key => $value) {
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
                                                    endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <span class="text-danger">You have no permission to access this content!</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- / EXAMS -->
                        </div>
                        <div class="tab-pane border border-top-0 fade" id="finance-tab-pane" role="tabpanel" aria-labelledby="finance-tab" tabindex="0">
                            <!-- FINANCE -->
                            <div class="card border-0 shadow-none mb-0">
                                <div class="card-body">
                                    <?php if (VIEWFOLDER == "finance") { ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm table-condensed text-uppercase text-nowrap table-striped table-hover" id="dataTable3">
                                                <thead class="maincolor">
                                                    <tr>
                                                        <th width="5%">Date</th>
                                                        <th>Type</th>
                                                        <th>Ref</th>
                                                        <th>description</th>
                                                        <th>debit</th>
                                                        <th>credit</th>
                                                        <th>balance</th>
                                                        <th width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (count($data['finance']) > 0) :
                                                        foreach ($data['finance'] as $finKey => $finance) { ?>
                                                            <tr>
                                                                <td><?= date("d M Y", strtotime($finance->date)) ?></td>
                                                                <td><?= $finance->fi_type ?></td>
                                                                <td><?= prepend($finance->id) ?></td>
                                                                <td>
                                                                    <?php if ($finance->fi_type == "post") {
                                                                        echo $finance->fi_desc;
                                                                    } else {
                                                                        echo $finance->fi_ref;
                                                                    } ?>
                                                                </td>
                                                                <td class="text-end"><?php if ($finance->fi_type == "post") : ?><?= number_format($finance->fi_amnt, 2) ?><?php endif; ?></td>
                                                                <td class="text-end"><?php if ($finance->fi_type == "pay") : ?><?= number_format($finance->fi_amnt, 2) ?><?php endif; ?></td>
                                                                <td class="text-end"><?= number_format($finance->rect_bal, 2) ?></td>
                                                                <td><?php if ($finance->fi_type == "pay") : ?><a href="<?= ROOT ?>finance/printtemp/<?= $finance->fi_key ?>" class="btn btn-sm btn-custom"><i class="fas fa-print"></i> Print Receipt</a><?php endif; ?></td>
                                                            </tr>
                                                    <?php }
                                                    endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <span class="text-danger">You have no permission to access this content!</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- / FINANCE -->
                        </div>
                    </div>

                </div>
            </div>

        <?php } else { ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-danger">
                    There is no student found matching your search quesry!
                </div>
            </div>
        <?php } ?>

    <?php
        break;
    default:
    ?>

        <?php if (isset($data['switch'])) { ?>

            <!-- control buttons -->
            <ul class="nav nav-pills theme2 mb-3">
                <!-- seach student -->
                <li class="nav-item"><a class="nav-link btn btn-sm btn-custom text-start rounded-0" href="<?= ROOT . VIEWFOLDER ?>/student/search"><i class="fas fa-search"></i> Search Student</a></li>
                <li class="nav-item"><a class="nav-link btn btn-sm btn-custom text-start rounded-0" href="<?= ROOT . VIEWFOLDER ?>/student/create"><i class="fas fa-user-plus"></i> Add student</a></li>
                <?php if ($_SESSION[VIEWFOLDER]->user_role > 1) : ?>
                    <!-- move -->
                    <li class="nav-item dropdown">
                        <a class="nav-link btn btn-sm btn-custom text-start rounded-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-arrow-right-arrow-left"></i> Move Students
                        </a>
                        <ul class="dropdown-menu rounded-0 p-0">
                            <li><button class="dropdown-item" onclick="studActionBtn('promote','<?= $data['switch'] ?>')"><i class="fas fa-tags"></i> Promote</button></li>
                            <li><button class="dropdown-item" onclick="studActionBtn('demote','<?= $data['switch'] ?>')"><i class="fas fa-tags"></i> Demote</button></li>
                            <li><button class="dropdown-item" onclick="studActionBtn('exportToAlumni','<?= $data['switch'] ?>')"><i class="fas fa-tags"></i> Export to alumni</button></li>
                            <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#customStudentMove"><i class="fas fa-tags"></i> Custom Move</button></li>
                        </ul>
                    </li>
                    <!-- More -->
                    <li class="nav-item dropdown">
                        <a class="nav-link btn btn-sm btn-custom text-start rounded-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i> More
                        </a>
                        <ul class="dropdown-menu rounded-0 p-0">
                            <?php if (VIEWFOLDER == "finance") : ?>
                                <li><button class="dropdown-item" onclick="syncStudents('<?= APPINFO->sch_domain ?>')"><i class="fas fa-refresh"></i> Sync students list</button></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <!-- / end control buttons -->
            <form class="studentsActionForm">

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent fw-bold text-muted"><?= strtoupper($data['heading']) ?></div>
                    <div class="card-body">
                        <!-- Hidden inputs -->
                        <div id="actionInputs"></div>
                        <!-- /Hidden inputs -->
                        <ul class="list-group list-group-horizontal-md mb-2 pb-2 rounded-0 border-bottom">
                            <li class="list-group-item p-0 rounded-0 border-0">
                                <select class="btn text-start border rounded-0 w-100 text-capitalize" onchange="switchViewType(this)">
                                    <optgroup label="all students">
                                        <option value="" <?php if ($data['switch'] == "") : ?>selected<?php endif; ?>>all students</option>
                                    </optgroup>
                                    <optgroup label="form or class">
                                        <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) { ?>
                                            <option value="<?= $classNum ?>" <?php if ($data['switch'] == $classNum) : ?>selected<?php endif; ?>><?= "form " . $classNum ?></option>
                                        <?php } ?>
                                    </optgroup>
                                    <optgroup label="stream">
                                        <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) {
                                            foreach (STREAMS as $stream) {
                                        ?>
                                                <option value="<?= smartKey($classNum . " " . $stream->stream) ?>" <?php if ($data['switch'] == smartKey($classNum . " " . $stream->stream)) : ?>selected<?php endif; ?>><?= "form " . $classNum . " " . $stream->stream ?></option>
                                        <?php
                                            }
                                        } ?>
                                    </optgroup>
                                </select>
                            </li>
                            <li class="list-group-item p-0 rounded-0 border-0 p-1"></li>
                            <li class="list-group-item p-0 rounded-0 border-0 dropdown">
                                <a class="btn text-start border rounded-0 w-100" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <ul class="dropdown-menu rounded-0 p-0">
                                    <li><a class="dropdown-item" href="<?= ROOT . VIEWFOLDER ?>/pdf/student/<?= $data['switch'] ?>"><i class="fas fa-download"></i> PDF</a></li>
                                    <li><a class="dropdown-item" href="<?= ROOT . VIEWFOLDER ?>/excel/student/<?= $data['switch'] ?>"><i class="fas fa-download"></i> Excel</a></li>
                                </ul>
                            </li>
                            <li class="list-group-item p-0 rounded-0 border-0 p-1"></li>
                            <li class="list-group-item p-0 rounded-0 border-0">
                                <button type="button" class="btn text-start rounded-0 w-100 btn-outline-danger" onclick="deleteStudents()"><i class="fas fa-trash-alt"></i> Delete</button>
                            </li>
                        </ul>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover table-striped text-nowrap text-capitalize align-middle" id="dataTable1">
                                <thead class="maincolor">
                                    <tr>
                                        <th class="pw-1"><input type="checkbox" onclick="$('input[name*=\'stud_key\']').prop('checked', this.checked);" /></th>
                                        <th>Adm</th>
                                        <th>Full Name</th>
                                        <th>Class</th>
                                        <?php if (APPINFO->sch_category == "mixed") : ?> <th>Gender</th> <?php endif; ?>
                                        <th>Contact</th>
                                        <?php if (VIEWFOLDER == "finance") { ?>
                                            <th class="pw-5">Billed</th>
                                            <th class="pw-5">Paid</th>
                                            <th class="pw-5">Balance</th>
                                            <th class="pw-3">Action</th>
                                            <th></th>
                                        <?php } else { ?>
                                            <th class="pw-5">KCPE Marks</th>
                                            <th class="pw-3">Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data['studData'])) :
                                        foreach ($data['studData'] as $student) {
                                            $finSum = $appData->studentInfo($student->stud_key)['finSummary'];
                                    ?>
                                            <tr>
                                                <td><input type="checkbox" name="stud_key[]" value="<?= $student->stud_key ?>"><span class="d-none"><?= $sno++ ?></span></td>
                                                <td><?= $student->stud_adm ?></td>
                                                <td><?= $student->stud_lname . " " . $student->stud_fname . " " . $student->stud_oname ?></td>
                                                <td><?= $student->stud_form . " " . $student->stud_stream ?></td>
                                                <?php if (APPINFO->sch_category == "mixed") : ?> <td><?= $student->stud_gender ?></td> <?php endif; ?>
                                                <td><?= smartPhone($student->stud_phone) ?></td>
                                                <?php if (VIEWFOLDER == "finance") { ?>
                                                    <td class="text-end"><?= number_format($finSum['ttBilled'], 2) ?></td>
                                                    <td class="text-end text-success"><?= number_format($finSum['ttPaid'], 2) ?></td>
                                                    <td class="text-end text-danger"><?= number_format($finSum['ttBalance'], 2) ?></td>
                                                    <td class="text-nowrap"><a href="<?= ROOT . VIEWFOLDER ?>/cashier/<?= $student->stud_key ?>" class="btn btn-outline-custom btn-sm w-100"><i class="fas fa-wallet"></i> Receive Payment</a></td>
                                                    <td class="text-nowrap"><a href="<?= ROOT . VIEWFOLDER ?>/student/profile/<?= $student->stud_key ?>" class="btn btn-outline-custom btn-sm w-100"><i class="fas fa-edit"></i> Manage</a></td>
                                                <?php } else { ?>
                                                    <td><?= $student->stud_kcpe_marks ?></td>
                                                    <td class="text-nowrap"><a href="<?= ROOT . VIEWFOLDER ?>/student/profile/<?= $student->stud_key ?>" class="btn btn-outline-custom btn-sm w-100"><i class="fas fa-edit"></i> Manage</a></td>
                                                <?php } ?>
                                            </tr>
                                    <?php
                                        }
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </form>

        <?php } else { ?>

            <div class="card border-0 shadow-sm">
                <div class="card-body text-uppercase text-danger">
                    Wrong redirectory!
                </div>
            </div>

        <?php } ?>

<?php
        break;
}
