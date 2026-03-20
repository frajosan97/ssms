<?php

switch ($fileView) {
    case "vote_head":
?>

        <div class="card border-0 shadow-sm">
            <div class="card-header">VOTE HEAD MANAGEMENT</div>
            <div class="card-body">
                <blockquote class="m-0 mb-2 bg-light">
                    <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#addVoteHead" class="btn btn-sm btn-outline-custom"><i class="fas fa-plus"></i> Add Votehead</a>
                </blockquote>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover align-middle text-capitalize" id="dataTable1">
                        <thead>
                            <tr>
                                <th class="pw-1">#</th>
                                <th>Vote Head</th>
                                <th class="pw-10">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['voteHeads'])) : ?>
                                <?php foreach ($data['voteHeads'] as $key => $value) { ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <td><?= $value->vote_head_name ?></td>
                                        <td class="text-nowrap">
                                            <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#voteAmount<?= $value->id ?>" class="btn btn-sm btn-outline-custom"><i class="fas fa-plus-circle"></i> Add Amount</a>
                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                        </td>
                                        <!-- Add amount modal -->
                                        <div class="modal fade" id="voteAmount<?= $value->id ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="voteAmount<?= $value->id ?>Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 p-2">
                                                    <form class="addVoteAmountForm">
                                                        <div class="modal-header bg-light p-1">
                                                            <h1 class="modal-title fs-5" id="voteAmount<?= $value->id ?>Label"><?= strtoupper($value->vote_head_name) ?></h1>
                                                            <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body border my-2">
                                                            <input type="hidden" name="vote_key" value="<?= $value->vote_head_key ?>">
                                                            <div class="form-group mb-2">
                                                                <label for="">Class</label>
                                                                <select name="class" class="form-control form-control-sm" required>
                                                                    <option value="">--Select Class--</option>
                                                                    <?php for ($i = 1; $i <= APPINFO->sch_cl_num; $i++) { ?>
                                                                        <option value="<?= $i ?>"><?= ucwords("form " . $i) ?></option>
                                                                    <?php } ?>
                                                                    <option value="all">All Classes</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="">Term</label>
                                                                <select name="term" class="form-control form-control-sm" required>
                                                                    <option value="">--Select Term--</option>
                                                                    <option value="1">Term 1</option>
                                                                    <option value="2">Term 2</option>
                                                                    <option value="3">Term 3</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="">Category</label>
                                                                <select name="category" class="form-control form-control-sm" required>
                                                                    <option value="">--Select Category--</option>
                                                                    <?php foreach (SCHCATEGORIES as $key => $value) { ?>
                                                                        <?php if (!($value == "day-boarding")) : ?>
                                                                            <option value="<?= $value ?>"><?= ucwords($value) ?></option>
                                                                        <?php endif; ?>
                                                                    <?php } ?>
                                                                    <option value="all">All Students</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="">Amount</label>
                                                                <input type="number" name="amount" placeholder="Amount" class="form-control form-control-sm" required />
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light p-1">
                                                            <button type="reset" class="btn btn-outline-danger"><i class="fas fa-history"></i> Reset</button>
                                                            <button type="submit" class="btn btn-outline-custom"><i class="fas fa-save"></i> Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                <?php } ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php
        break;
    case "fees_structure":
        ?>

            <ul class="list-group list-group-horizontal m-0 border-0 bg-light mb-2">
                <li class="list-group-item bg-transparent border-0 p-1"> <span class="btn btn-sm btn-outline-custom" onclick="printDiv('printFeesStructure')"><i class="fas fa-print"></i> Print</span> </li>
            </ul>
            <div class="card border-0 shadow-sm" id="printFeesStructure">
                <div class="card-body">
                    <?php if (isset($data['feeStructure'])) { ?>
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th class="pw-4"><img src="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>"></th>
                                <td class="text-center">
                                    <h4 class="m-0"><?= strtoupper(APPINFO->sch_name) ?></h4>
                                    <h6 class="m-0">P.O Box <?= ucwords(APPINFO->sch_address . ' - ' . APPINFO->sch_postcode . ', ' . APPINFO->sch_town) ?></h6>
                                    <h6 class="m-0">Tell: <?= smartPhone(APPINFO->sch_phone) ?></h6>
                                    <h5 class="m-0 text-danger">FEES STRUCTURE YEAR (<?= date("Y") ?>)</h5>
                                </td>
                            </tr>
                        </table>
                        <hr class="dividerDiv1" />
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-condensed text-nowrap border-dark align-middle text-capitalize">
                                <thead class="bg-light">
                                    <tr>
                                        <th>VOTE HEAD</th>
                                        <?php foreach (TERMS as $key => $value) { ?>
                                            <th><?= strtoupper($value) ?></th>
                                        <?php } ?>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $term = []; ?>
                                    <?php foreach ($data['feeStructure'] as $key => $value) {
                                        $voteTT = 0; ?>
                                        <tr>
                                            <td><?= strtoupper($value['vote_head_name']) ?></td>
                                            <?php foreach (TERMS as $termKey => $termValue) {
                                                $termAmnt = 0;
                                                foreach ($value['voteAmnt'] as $voteAmntKey => $voteAmntValue) {
                                                    if ($voteAmntValue->term == $termKey) {
                                                        $term[$voteAmntValue->term][] = $voteAmntValue->amount;
                                                        $termAmnt = $voteAmntValue->amount;
                                                    }
                                                }
                                                $voteTT += $termAmnt;
                                                $voteAmntPrint = ($termAmnt > 0) ?  number_format($termAmnt, 2) : "--";
                                            ?>
                                                <td class="text-end"><?= $voteAmntPrint ?></td>
                                            <?php } ?>
                                            <th class="text-end"><?= number_format($voteTT, 2) ?></th>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th>TOTALS</th>
                                        <?php $ttFees = 0;
                                        foreach (TERMS as $footKey => $footValue) {
                                            $termTT = 0; ?>
                                            <?php foreach ($term as $key => $value) {
                                                if ($footKey == $key) {
                                                    $termTT = array_sum($value);
                                                }
                                            }
                                            $ttFees += $termTT;
                                            $termTTPrint = ($termTT > 0) ?  number_format($termTT, 2) : "--";
                                            ?>
                                            <th class="text-end"><?= $termTTPrint ?></th>
                                        <?php } ?>
                                        <th class="text-end"><?= number_format($ttFees, 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- Fees structure notes -->
                        <?= APPINFO->sch_fsNotes ?>
                    <?php } ?>
                </div>
            </div>

        <?php
        break;
    case "exam":
        ?>

            <button class="btn py-2 text-capitalize shadow-sm rounded-pill text-start bg-white mb-3" data-bs-toggle="modal" data-bs-target="#createExam">
                <i class="fas fa-folder-open"></i> Create New Exam
            </button>
            <div class="card border-0 shadow-sm">
                <div class="card-header">SCHOOL EXAMS MANAGEMENT</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover align-middle text-capitalize" id="dataTable1">
                            <thead>
                                <tr>
                                    <th class="pw-1">#</th>
                                    <th>exam</th>
                                    <th>start date</th>
                                    <th>end date</th>
                                    <th class="pw-10">status</th>
                                    <th>action</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($data['exams'])) : ?>
                                    <?php foreach ($data['exams'] as $key => $exam) { ?>
                                        <tr>
                                            <form action="" method="post">
                                                <input type="hidden" name="exam_key" value="<?= $exam->exam_key ?>">
                                                <td><?= $sno++ ?></td>
                                                <td> <input type="text" name="exam_name" value="<?= $exam->exam ?>" class="form-control p-0 border-0 bg-transparent rounded-0"> </td>
                                                <td> <input type="date" name="start_date" value="<?= $exam->start_date ?>" class="form-control p-0 border-0 bg-transparent rounded-0"> </td>
                                                <td> <input type="date" name="end_date" value="<?= $exam->end_date ?>" class="form-control p-0 border-0 bg-transparent rounded-0"> </td>
                                                <td>
                                                    <select name="exam_status" class="form-control p-0 border-0 bg-transparent rounded-0">
                                                        <?php if ($key == array_key_first($data['exams'])) : ?>
                                                            <option value="active" <?php if ($exam->exam_status == "active") : ?>selected<?php endif; ?>>Active</option>
                                                        <?php endif; ?>
                                                        <option value="closed" <?php if ($exam->exam_status == "closed") : ?>selected<?php endif; ?>>Closed</option>
                                                    </select>
                                                </td>
                                                <td><button class="btn btn-outline-custom btn-sm"><i class="fas fa-trash-alt"></i> Save Changes</button></td>
                                            </form>
                                            <td><button value="<?= $exam->exam_key ?>" onclick="deleteExam(this)" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button></td>
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
    case "term":
        ?>

            <button class="btn py-2 text-capitalize shadow-sm rounded-pill text-start bg-white mb-3" data-bs-toggle="modal" data-bs-target="#createTerm">
                <i class="fas fa-list-alt"></i> Create New Term
            </button>
            <div class="card border-0 shadow-sm">
                <div class="card-header">SCHOOL TERMS MANAGEMENT</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover align-middle text-capitalize" id="dataTable1">
                            <thead>
                                <tr>
                                    <th class="pw-1">#</th>
                                    <th>term</th>
                                    <th>start date</th>
                                    <th>end date</th>
                                    <th class="pw-10">status</th>
                                    <th>action</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($data['terms'])) : ?>
                                    <?php foreach ($data['terms'] as $key => $term) { ?>
                                        <tr>
                                            <form action="" method="post">
                                                <input type="hidden" name="term_key" value="<?= $term->term_key ?>">
                                                <td><?= $sno++ ?></td>
                                                <td> <input type="text" name="term" value="<?= $term->term ?>" class="form-control p-0 border-0 bg-transparent rounded-0"> </td>
                                                <td> <input type="date" name="start_date" value="<?= $term->start_date ?>" class="form-control p-0 border-0 bg-transparent rounded-0"> </td>
                                                <td> <input type="date" name="end_date" value="<?= $term->end_date ?>" class="form-control p-0 border-0 bg-transparent rounded-0"> </td>
                                                <td>
                                                    <select name="term_status" class="form-control p-0 border-0 bg-transparent rounded-0">
                                                        <?php if ($key == array_key_first($data['terms'])) : ?>
                                                            <option value="active" <?php if ($term->term_status == "active") : ?>selected<?php endif; ?>>Active</option>
                                                        <?php endif; ?>
                                                        <option value="closed" <?php if ($term->term_status == "closed") : ?>selected<?php endif; ?>>Closed</option>
                                                    </select>
                                                </td>
                                                <td><button class="btn btn-outline-custom btn-sm"><i class="fas fa-trash-alt"></i> Save Changes</button></td>
                                            </form>
                                            <td><button value="<?= $term->term_key ?>" onclick="deleteTerm(this)" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button></td>
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
    case "subject":
        ?>

            <div class="card bg-transparent border-0 shadow-none">
                <div class="card-body p-0">
                    <select class="selectpicker" onchange="subjectAction(this,'addSubject')">
                        <option value="">--Select subject to add--</option>
                        <?php if (isset($data['sysSubjects'])) : ?>
                            <?php foreach ($data['sysSubjects'] as $subject) { ?>
                                <option value="<?= strtoupper($subject->sub_code . '-' . $subject->sub_name) ?>"><?= ucwords('[ ' . $subject->sub_code . ' ] - ' . $subject->sub_name) ?></option>
                            <?php } ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-header"><?= strtoupper("managing " . APPINFO->sch_name . " subjects") ?></div>
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-condensed text-nowrap text-capitalize table-striped table-hover align-middle" id="dataTable1">
                            <thead class="maincolor">
                                <tr>
                                    <th>#</th>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Category</th>
                                    <th>Cluster</th>
                                    <th class="pw-15">Compulsory</th>
                                    <th class="pw-10">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($data['schSubjects'])) : ?>
                                    <?php foreach ($data['schSubjects'] as $subject) { ?>
                                        <tr>
                                            <td><?= $sno++ ?>.</td>
                                            <td><?= $subject->sub_code ?></td>
                                            <td><?= $subject->sub_name ?></td>
                                            <td><?= $subject->cat_name ?></td>
                                            <td><?= $subject->sub_group ?></td>
                                            <td>
                                                <?php if ($subject->sch_sub_comp == 0) { ?>
                                                    <button value='<?= smartKey($subject->id . ' 1') . "-" . $subject->sub_name ?>' class="btn btn-outline-custom btn-sm w-100" onclick="subjectAction(this,'updateSubject')"><i class='fas fa-plus-circle'></i> Make Compulsory</button>
                                                <?php } else { ?>
                                                    <button value='<?= smartKey($subject->id . ' 0') . "-" . $subject->sub_name ?>' class="btn btn-outline-danger btn-sm w-100" onclick="subjectAction(this,'updateSubject')"><i class='fas fa-minus-circle'></i> Remove Compulsory</button>
                                                <?php } ?>
                                            </td>
                                            <td><button value="<?= $subject->id . "-" . $subject->sub_name ?>" class="btn btn-outline-danger btn-sm w-100" onclick="subjectAction(this,'deleteSubject')"><i class="fas fa-trash-alt"></i> Delete</button></td>
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
    case "other":
        ?>

            <form action="" method="post">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">SCHOOL ADDITIONAL SYSTEM SETTINGS</div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="sch_cl_num" class="mb-1">School Maximum Class Number</label>
                            <input type="number" name="sch_cl_num" value="<?= APPINFO->sch_cl_num ?>" placeholder="School Maximum Class Number" id="sch_cl_num" class="form-control" required />
                        </div>
                        <div class="form-group mb-3">
                            <label for="sch_type" class="mb-1">Select School Gender Type</label>
                            <select class="form-control" name="sch_type" id="sch_type" required>
                                <option value="">Select School Gender Type</option>
                                <?php foreach (SCHTYPE as $key => $value) { ?>
                                    <option value="<?= $key ?>" <?php if (APPINFO->sch_type === $key) : ?> selected <?php endif; ?>><?= $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="sch_category" class="mb-1">Select School Category</label>
                            <select class="form-control" name="sch_category" id="sch_category" required>
                                <option value="">Select School Category</option>
                                <?php foreach (SCHCATEGORIES as $key => $value) { ?>
                                    <option value="<?= $value ?>" <?php if (APPINFO->sch_category === $value) : ?> selected <?php endif; ?>><?= ucwords($value) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="sch_sum_type" class="mb-1">Results Calculation Type</label>
                            <select class="form-control" name="sch_sum_type" id="sch_sum_type" required>
                                <option value="">--Results Calculation Type--</option>
                                <option value="kcse" <?php if (APPINFO->sch_sum_type === "kcse") : ?> selected <?php endif; ?>>KCSE Level</option>
                                <option value="all" <?php if (APPINFO->sch_sum_type === "all") : ?> selected <?php endif; ?>>All Subjects</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="sch_rank_by" class="mb-1">Rank Students Results By?</label>
                            <select class="form-control" name="sch_rank_by" id="sch_rank_by" required>
                                <option value="">--Select Rank Category--</option>
                                <option value="re_tt" <?php if (APPINFO->sch_rank_by === "re_tt") : ?> selected <?php endif; ?>>Marks Scored</option>
                                <option value="re_pnt" <?php if (APPINFO->sch_rank_by === "re_pnt") : ?> selected <?php endif; ?>>Points Attained</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="sch_sms_mode" class="mb-1">SMS messager mode</label>
                            <select class="form-control" name="sch_sms_mode" id="sch_sms_mode" required>
                                <option value="">--Select SMS Mode--</option>
                                <?php foreach (SCHSMSMODE as $key => $value) { ?>
                                    <option value="<?= $key ?>" <?php if (APPINFO->sch_sms_mode === $key) : ?> selected <?php endif; ?>><?= $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (APPINFO->sch_sms_mode == 2) : ?>
                            <div class="row">
                                <div class="form-group col-md-4 mb-3">
                                    <label for="sch_sms_api" class="mb-1">SMS API Key</label>
                                    <input type="text" name="sch_sms_api" value="<?= APPINFO->sch_sms_api ?>" placeholder="SMS API Key" class="form-control" <?php if (!($_SESSION[VIEWFOLDER]->user_role == 7)) : ?>readonly<?php endif; ?> />
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label for="sch_partner_id" class="mb-1">SMS Partner ID</label>
                                    <input type="text" name="sch_partner_id" value="<?= APPINFO->sch_partner_id ?>" placeholder="SMS Partner ID" class="form-control" <?php if (!($_SESSION[VIEWFOLDER]->user_role == 7)) : ?>readonly<?php endif; ?> />
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label for="sch_short_code" class="mb-1">SMS Short Code</label>
                                    <input type="text" name="sch_short_code" value="<?= APPINFO->sch_short_code ?>" placeholder="SMS Short Code" class="form-control" <?php if (!($_SESSION[VIEWFOLDER]->user_role == 7)) : ?>readonly<?php endif; ?> />
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer border-0 bg-transparent pb-3">
                        <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset Inputs</button>
                        <button type="submit" class="btn float-end btn-outline-custom"><i class="fas fa-save"></i> Update Settings</button>
                    </div>
                </div>
            </form>

        <?php
        break;
    case "image":
        ?>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">SCHOOL THEME MANAGEMENT</div>
                    <div class="card-body text-capitalize">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card bg-light shadow-none">
                                    <div class="card-header border-0 bg-transparent shadow-sm fw-bolder text-uppercase">Selected image display</div>
                                    <div class="card-body">
                                        <img src="" class="img" style="max-height: 200px; max-width: 200px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="imgType" class="mb-1">Select Image Category</label>
                                <select name="imgType" class="form-control" required>
                                    <option value="">--Select Image Category--</option>
                                    <?php foreach (IMAGES as $key => $value) { ?>
                                        <option value="<?= $key ?>"><?= ucwords($value[1]) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="image" class="mb-1">Select Image to Upload</label>
                                <input type="file" name="image" accept="image/*" class="form-control" onchange="previewImg(this)" required />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent pb-3">
                        <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset Selection</button>
                        <button type="submit" class="btn float-end btn-outline-custom"><i class="fas fa-save"></i> Upload Image</button>
                    </div>
                </div>
                <!-- DISPLAY -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header">CURRENT RUNNING IMAGES</div>
                    <div class="card-body text-capitalize">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped text-nowrap text-capitalize align-middle">
                                <thead class="maincolor">
                                    <tr>
                                        <th class="pw-3">S/No</th>
                                        <th>Image Type</th>
                                        <th>Image</th>
                                        <th>Last Update</th>
                                        <th>Updated By</th>
                                        <th class="pw-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (IMAGES as $key => $value) { ?>
                                        <tr>
                                            <td><?= $sno++ ?>.</td>
                                            <td><?= $value[1] ?></td>
                                            <td>
                                                <a href="<?= imageCheck($value[0], APPINFO->$key, $value[2]) ?>" target="_blank">
                                                    <img src="<?= imageCheck($value[0], APPINFO->$key, $value[2]) ?>" class="img bg-light p-1" style="max-height: 50px; max-width: 50px" />
                                                </a>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</span></td>
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
    case "theme":
        ?>

            <form action="" method="post">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">SCHOOL THEME MANAGEMENT</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="sch_prim_theme" class="mb-1">School Main Color [ Primary Background ]</label>
                                <input type="color" name="sch_prim_theme" value="<?= APPINFO->sch_prim_theme ?>" id="sch_prim_theme" class="form-control p-1" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="sch_sec_theme" class="mb-1">School Transparent Color [ Secondary Background ]</label>
                                <input type="text" name="sch_sec_theme" value="<?= APPINFO->sch_sec_theme ?>" id="sch_sec_theme" class="form-control p-1" required>
                            </div>
                            <div class="col-md-12">
                                <h6 class="my-2 p-1 rounded bg-light">Documents PDF theme / color customization</h6>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="sch_pdf_theme" class="mb-1">School PDF Background [ PDF Background ]</label>
                                <input type="color" name="sch_pdf_theme" value="<?= APPINFO->sch_pdf_theme ?>" id="sch_pdf_theme" class="form-control p-1" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent pb-3">
                        <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset Inputs</button>
                        <button type="submit" class="btn float-end btn-outline-custom"><i class="fas fa-save"></i> Update Themes</button>
                    </div>
                </div>
            </form>

        <?php
        break;
    case "contact":
        ?>

            <form action="" method="post">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">SCHOOL CONTACTS MANAGEMENT</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="sch_phone" class="mb-1">Official School Phone Number</label>
                                <input type="tel" name="sch_phone" value="<?= APPINFO->sch_phone ?>" placeholder="Official School Phone Number" id="sch_phone" class="form-control" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="sch_email" class="mb-1">Official School Email Address</label>
                                <input type="email" name="sch_email" value="<?= APPINFO->sch_email ?>" placeholder="Official School Email Address" id="sch_email" class="form-control" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="sch_address" class="mb-1">School Box Number</label>
                                <input type="number" name="sch_address" value="<?= APPINFO->sch_address ?>" placeholder="School Box Number" id="sch_address" class="form-control" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="sch_postcode" class="mb-1">Post Code</label>
                                <input type="number" name="sch_postcode" value="<?= APPINFO->sch_postcode ?>" placeholder="Post Code" id="sch_postcode" class="form-control" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="sch_town" class="mb-1">School Local Town</label>
                                <input type="text" name="sch_town" value="<?= APPINFO->sch_town ?>" placeholder="School Local Town" id="sch_town" class="form-control" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="sch_city" class="mb-1">School Nearest City</label>
                                <input type="text" name="sch_city" value="<?= APPINFO->sch_city ?>" placeholder="School Nearest City" id="sch_city" class="form-control" required />
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="sch_map" class="mb-1">Embend School Google Map</label>
                                <textarea name="sch_map" placeholder="Embend School Google Map" id="sch_map" class="form-control" rows="3"><?= APPINFO->sch_map ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent pb-3">
                        <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset Inputs</button>
                        <button type="submit" class="btn float-end btn-outline-custom"><i class="fas fa-save"></i> Update Contacts</button>
                    </div>
                </div>
            </form>

        <?php
        break;
    case 'about':
        ?>

            <form action="" method="post">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-1">
                        <ul class="list-group list-group-horizontal m-0 border-0 bg-light">
                            <li class="list-group-item bg-transparent border-0 p-1"> <span class="btn btn-sm btn-outline-custom" id="actionBtn" onclick="vPF(this,'printAbout','editAbout')" value="show"><i class="fas fa-eye"></i> Edit Profile</span> </li>
                            <li class="list-group-item bg-transparent border-0 p-1"> <span class="btn btn-sm btn-outline-custom" id="printBtn" onclick="printDiv('printAbout')"><i class="fas fa-print"></i> Print Analysis</span> </li>
                        </ul>
                    </div>
                </div>
                <!-- view mode -->
                <div class="card border-0 shadow-sm" id="printAbout">
                    <div class="card-header bg-white border-0 pb-0">
                        <table class="table table-sm table-borderless mb-0 align-middle">
                            <tr>
                                <th class="pw-5"><img src="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>" alt=""></th>
                                <td class="text-center">
                                    <h3 class="m-0"><?= strtoupper(APPINFO->sch_name) ?></h3>
                                    <h5 class="m-0">P.O Box <?= ucwords(APPINFO->sch_address . ' - ' . APPINFO->sch_postcode . ', ' . APPINFO->sch_town) ?></h5>
                                    <small class="text-danger"><i><?= ucwords(APPINFO->sch_moto) ?></i></small>
                                    <h5><?= strtoupper("school profile") ?></h5>
                                </td>
                                <th class="pw-5"></th>
                            </tr>
                        </table>
                        <hr class="dividerDiv1" />
                    </div>
                    <div class="card-body">
                        <?= APPINFO->sch_about ?>
                    </div>
                </div>
                <!-- Edit mode -->
                <div class="card border-0 shadow-sm d-none" id="editAbout">
                    <div class="card-header">EDITING ABOUT THE SCHOOL</div>
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <textarea name="sch_about" class="form-control" id="editor"><?= APPINFO->sch_about ?></textarea>
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent pb-3">
                        <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset Inputs</button>
                        <button type="submit" class="btn float-end btn-outline-custom"><i class="fas fa-save"></i> Update About</button>
                    </div>
                </div>
            </form>

        <?php
        break;
    default:
        ?>

            <form action="" method="post">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">SCHOOL PROFILE MANAGEMENT</div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="sch_name" class="mb-1">Official School Name</label>
                            <input type="text" name="sch_name" value="<?= APPINFO->sch_name ?>" placeholder="Official School Name" id="sch_name" class="form-control" required />
                        </div>
                        <div class="form-group mb-3">
                            <label for="sch_moto" class="mb-1">School Moto</label>
                            <input type="text" name="sch_moto" value="<?= APPINFO->sch_moto ?>" placeholder="School Moto" id="sch_moto" class="form-control" required />
                        </div>
                        <div class="form-group mb-3">
                            <label for="sch_mission" class="mb-1">School Mission Statement</label>
                            <input type="text" name="sch_mission" value="<?= APPINFO->sch_mission ?>" placeholder="School Mission Statement" id="sch_mission" class="form-control" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="sch_vision" class="mb-1">School Vision Statement</label>
                            <input type="text" name="sch_vision" value="<?= APPINFO->sch_vision ?>" placeholder="School Vision Statement" id="sch_vision" class="form-control" />
                        </div>
                        <div class="form-group mb-3">
                            <label for="sch_domain" class="mb-1">School Domain Name</label>
                            <input type="link" name="sch_domain" value="<?= APPINFO->sch_domain ?>" placeholder="School Domain Name" id="sch_vision" class="form-control" />
                        </div>
                        <h6 class="my-2 p-1 rounded bg-light">Search Engine Optimization (SEO) keys</h6>
                        <div class="form-group mb-3">
                            <label for="sch_metadesc" class="mb-1">Search Engine Description</label>
                            <textarea name="sch_metadesc" placeholder="Search Engine Description" id="sch_metadesc" class="form-control" rows="1"><?= APPINFO->sch_metadesc ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="sch_metakey" class="mb-1">Search Engine Key Words</label>
                            <textarea name="sch_metakey" placeholder="Search Engine Key Words" id="sch_metakey" class="form-control" rows="1"><?= APPINFO->sch_metakey ?></textarea>
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent pb-3">
                        <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset Inputs</button>
                        <button type="submit" class="btn float-end btn-outline-custom"><i class="fas fa-save"></i> Update Profile</button>
                    </div>
                </div>
            </form>

    <?php
        break;
}
