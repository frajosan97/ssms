<?php

switch (VIEWFOLDER) {
    case "staff":
?>

        <!-- STAFF MODALS -->
        <!-- create grading -->
        <div class="modal fade" id="creategrading" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="creategradingLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 p-2">
                    <form action="" method="post" class="creategradingForm">
                        <div class="modal-header bg-light p-1">
                            <h1 class="modal-title fs-5" id="creategradingLabel">CREATE NEW GRADING SYSTEM</h1>
                            <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body border my-2">
                            <div class="alertbox modalAlertContainer"></div>
                            <div class="row">
                                <div class="form-group mb-2">
                                    <label for="grd_subcat" class="mb-1">Grading System</small> </label>
                                    <select name="grd_subcat" id="grd_subcat" class="form-control" required>
                                        <option value="">--Select grading system--</option>
                                        <option value="default">School Default Grading System</option>
                                        <?php foreach (SYSTEMSUBCAT as $key => $value) { ?>
                                            <option value="<?= $value->cat_key ?>"><?= ucwords($value->cat_name . " grading system") ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light p-1">
                            <button type="reset" class="btn btn-outline-danger"><i class="fas fa-history"></i> Reset</button>
                            <button type="submit" class="btn btn-outline-custom"><i class="fas fa-plus-circle"></i> Save grading system</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- create exam -->
        <div class="modal fade" id="createExam" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createExamLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 p-2">
                    <form action="" method="post" class="createExamForm">
                        <div class="modal-header bg-light p-1">
                            <h1 class="modal-title fs-5" id="createExamLabel">CREATE NEW EXAM</h1>
                            <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <?php if (!(empty(CURRENTTERM))) { ?>
                            <?php if (empty(CURRENTEXAM)) { ?>
                                <div class="modal-body border my-2">
                                    <input type="hidden" name="postTime" value="<?= time() ?>">
                                    <input type="hidden" name="exam_term" value="<?php if (CURRENTTERM) : ?><?= CURRENTTERM->term_key ?><?php endif ?>">
                                    <div class="row">
                                        <div class="form-group mb-2">
                                            <label for="exam" class="mb-1">Exam Name / Type <small>(NB: Don't include term "Exam" in this input)</small> </label>
                                            <input type="text" name="exam" id="exam" placeholder="Exam Name / Type e.g Opening" class="form-control" required />
                                        </div>
                                        <div class="col-md-6 form-group mb-2">
                                            <label for="start_date" class="mb-1">Starting Date</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control" required />
                                        </div>
                                        <div class="col-md-6 form-group mb-2">
                                            <label for="end_date" class="mb-1">Ending Date</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light p-1">
                                    <button type="reset" class="btn btn-outline-danger"><i class="fas fa-history"></i> Reset</button>
                                    <button type="submit" class="btn btn-outline-custom"><i class="fas fa-plus-circle"></i> Save exam</button>
                                </div>
                            <?php } else { ?>
                                <div class="modal-body border my-2 text-center text-danger">You cannot create new exam for there is still a running exam!</div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="modal-body border my-2 text-center text-danger">You cannot create an exam for the term is not yet set, you MUST create term in order to continue!</div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
        <!-- / STAFF MODALS -->

    <?php
        break;
    case "finance":
    ?>

        <!-- FINANCE MODALS -->
        <div class="modal fade" id="postFees" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="postFeesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 p-2">
                    <form class="postFeesForm">
                        <div class="modal-header bg-light p-1">
                            <h1 class="modal-title fs-5" id="postFeesLabel">POST TERM FEES</h1>
                            <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body border my-2">
                            <div class="form-group mb-2">
                                <label for="">Term</label>
                                <select name="term" class="form-control form-control-sm">
                                    <option value="">--Select Term--</option>
                                    <?php foreach (ALLTERMS as $key => $value) { ?>
                                        <option value="<?= $value->term_key ?>" <?php if ($key == array_key_last(ALLTERMS)) : ?> selected <?php endif; ?>><?= ucwords("term " . $value->term . " - " . date("Y", strtotime($value->date))) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Class</label>
                                <select name="class" class="form-control form-control-sm">
                                    <option value="">--Select Class--</option>
                                    <?php for ($i = 1; $i <= APPINFO->sch_cl_num; $i++) { ?>
                                        <option value="<?= $i ?>"><?= ucwords("form " . $i) ?></option>
                                    <?php } ?>
                                    <option value="all">All Classes</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Category</label>
                                <select name="category" class="form-control form-control-sm">
                                    <option value="">--Select Category--</option>
                                    <?php foreach (SCHCATEGORIES as $key => $value) { ?>
                                        <?php if (!($value == "day-boarding")) : ?>
                                            <option value="<?= $value ?>"><?= ucwords($value) ?></option>
                                        <?php endif; ?>
                                    <?php } ?>
                                    <option value="all">All Students</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Amount</label>
                                <input type="number" name="amount" placeholder="Amount" class="form-control form-control-sm" required />
                            </div>
                        </div>
                        <div class="modal-footer bg-light p-1">
                            <button type="reset" class="btn btn-outline-danger"><i class="fas fa-history"></i> Reset</button>
                            <button type="submit" class="btn btn-outline-custom"><i class="fas fa-plus-circle"></i> Post Fees</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addVoteHead" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addVoteHeadLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 p-2">
                    <form class="addVoteHeadForm">
                        <div class="modal-header bg-light p-1">
                            <h1 class="modal-title fs-5" id="addVoteHeadLabel">ADD VOTEHEAD</h1>
                            <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body border my-2">
                            <div class="form-group mb-2">
                                <label for="">Vote Head</label>
                                <input type="text" name="vote_head_name" placeholder="Vote Head" class="form-control fotm-control-sm" />
                            </div>
                        </div>
                        <div class="modal-footer bg-light p-1">
                            <button type="reset" class="btn btn-outline-danger"><i class="fas fa-history"></i> Reset</button>
                            <button type="submit" class="btn btn-outline-custom"><i class="fas fa-plus-circle"></i> Post Fees</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addIncomeSource" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addIncomeSourceLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 p-2">
                    <form class="addIncomeSourceForm">
                        <div class="modal-header bg-light p-1">
                            <h1 class="modal-title fs-5" id="addIncomeSourceLabel">ADD SOURCE OF INCOME FOR SCHOOL</h1>
                            <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body border my-2">
                            <div class="form-group mb-2">
                                <label for="">Type</label>
                                <input type="text" name="type" placeholder="Type e.g asset" class="form-control fotm-control-sm" required />
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Source</label>
                                <input type="text" name="source" placeholder="Source of Income e.g School Bus" class="form-control fotm-control-sm" required />
                            </div>
                        </div>
                        <div class="modal-footer bg-light p-1">
                            <button type="reset" class="btn btn-outline-danger"><i class="fas fa-history"></i> Reset</button>
                            <button type="submit" class="btn btn-outline-custom"><i class="fas fa-plus-circle"></i> Add Income</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- / FINANCE MODALS -->

    <?php
        break;
    case "admin":
    ?>

        <!-- ADMIN MODALS -->
        <div class="modal fade" id="loadPayment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loadPaymentLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 p-2">
                    <form action="" method="post" class="loadPaymentForm">
                        <div class="modal-header bg-light p-1">
                            <h1 class="modal-title fs-5" id="loadPaymentLabel">LOAD INVOICE PAYMENT</h1>
                            <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body border my-2">
                            <div class="alertbox modalAlertContainer"></div>
                            <div class="row">
                                <input type="hidden" name="timeStamp" value="<?= time() ?>">
                                <div class="form-group mb-2">
                                    <label for="sch_token" class="mb-1">School receiving payment for</small> </label>
                                    <select name="sch_token" id="sch_token" class="form-control" onchange="getSchoolInv(this)" required>
                                        <option value="" required>--Select school receiving payment for--</option>
                                        <?php foreach (SCHOOLS as $school) { ?>
                                            <option value="<?= $school->sch_token ?>"><?= ucfirst($school->sch_name) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2 invoiceCont"></div>
                                <div class="form-group mb-2 invoiceInfo"></div>
                                <div class="form-group d-none paymentMethod">
                                    <label for="pay_mode" class="mb-1">Payment Method</small> </label>
                                    <select name="pay_mode" id="pay_mode" class="form-control" onchange="requestLoad(this)" required>
                                        <option value="" required>--Select Pay Method--</option>
                                        <option value="mpesa">M-Pesa</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                                <div class="loadPayment"></div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light p-1">
                            <button class="btn btn-success payButton" disabled>Submit Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- / ADMIN MODALS -->

<?php
        break;
    default:
        break;
}

?>

<!-- COMMON MODALS -->
<!-- create term -->
<div class="modal fade" id="createTerm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createTermLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 p-2">
            <form action="" method="post" class="createTermForm">
                <div class="modal-header bg-light p-1">
                    <h1 class="modal-title fs-5" id="createTermLabel">CREATE NEW TERM</h1>
                    <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php if (empty(CURRENTTERM)) { ?>
                    <div class="modal-body border my-2">
                        <div class="row">
                            <input type="hidden" name="postTime" value="<?= time() ?>">
                            <div class="form-group mb-2">
                                <label for="term" class="mb-1">Term</label>
                                <select name="term" id="term" class="form-control" required>
                                    <option value="">--Select Term--</option>
                                    <option value="1">Term 1</option>
                                    <option value="2">Term 2</option>
                                    <option value="3">Term 3</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-2">
                                <label for="start_date" class="mb-1">Opening Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required />
                            </div>
                            <div class="col-md-6 form-group mb-2">
                                <label for="end_date" class="mb-1">Closing Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-1">
                        <button type="reset" class="btn btn-outline-danger"><i class="fas fa-history"></i> Reset</button>
                        <button type="submit" class="btn btn-outline-custom"><i class="fas fa-plus-circle"></i> Save term</button>
                    </div>
                <?php } else { ?>
                    <div class="modal-body border my-2 text-center text-danger">You cannot create new term for there is still a running term!</div>
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<!-- add stream -->
<div class="modal fade" id="addStream" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addStreamLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 p-2">
            <form action="" method="post" class="addStreamForm">
                <div class="modal-header bg-light p-1">
                    <h1 class="modal-title fs-5" id="addStreamLabel">ADD SCHOOL STREAM</h1>
                    <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border my-2">
                    <div class="alertbox modalAlertContainer"></div>
                    <input type="hidden" name="add_stream" value="add_stream">
                    <div class="form-group mb-2">
                        <label class="" for="stream">stream</label>
                        <input name="stream" type="stream" class="form-control bg-transparent" id="stream" placeholder="Stream e.g west" required />
                    </div>
                </div>
                <div class="modal-footer bg-light p-1">
                    <button type="reset" class="btn btn-outline-danger"><i class="fas fa-history"></i> Reset</button>
                    <button type="submit" class="btn btn-outline-custom"><i class="fas fa-plus-circle"></i> Save stream</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- add class -->
<div class="modal fade" id="addClass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addClassLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 p-2">
            <form action="" method="post" class="addClassForm">
                <div class="modal-header bg-light p-1">
                    <h1 class="modal-title fs-5" id="addClassLabel">ADD SCHOOL STREAM</h1>
                    <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border my-2">
                    <input type="hidden" name="postType" value="class">
                    <div class="alertbox modalAlertContainer"></div>
                    <div class="form-group mb-2">
                        <label for="" class="mb-1">Class / Form</label>
                        <select class="form-control" name="class" style="width: 100%;">
                            <option value="">Select Class</option>
                            <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) { ?>
                                <option value="<?= $classNum ?>"><?= $classNum ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="mb-1">Stream</label>
                        <select class="form-control" name="stream" style="width: 100%;">
                            <option value="">Select Stream</option>
                            <?php if (STREAMS) : ?>
                                <?php foreach (STREAMS as $key => $value) { ?>
                                    <option value="<?= $value->str_key ?>"><?= ucwords($value->stream) ?></option>
                                <?php } ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light p-1">
                    <button type="reset" class="btn btn-outline-danger"><i class="fas fa-history"></i> Reset</button>
                    <button type="submit" class="btn btn-outline-custom"><i class="fas fa-plus-circle"></i> Save class</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Overlay Loader -->
<div class="overlay" id="overlayLoader">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<!-- Custom students movement -->
<div class="modal fade" id="customStudentMove" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="customStudentMoveLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 p-2">
            <div class="modal-header bg-light p-1">
                <h1 class="modal-title fs-5" id="customStudentMoveLabel">MOVE STUDENTS</h1>
                <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border my-2">
                <blockquote class="m-0 mb-3 bg-light">
                    Notes: To move students,
                    <ol>
                        <li>Kindly load students list</li>
                        <li>Select all students you would like to move</li>
                        <li>Select the category to move</li>
                    </ol>
                    MOVE BY:
                </blockquote>
                <label for="category">
                    <input type="radio" id="category" name="category" value="stud_form"> Class/Form
                    <input type="radio" id="category" name="category" value="stud_stream"> Stream
                    <input type="radio" id="category" name="category" value="stud_gender"> Gender
                </label>
                <input type="hidden" name="changeCategory" id="changeCategory" value="">
                <div class="col-md-4" id="moveSelectedValue"></div>
            </div>
            <div class="modal-footer d-none bg-light p-1" id="moveModalFooter">
                <button type="reset" class="btn btn-outline-danger"><i class="fas fa-history"></i> Reset</button>
                <button type="submit" class="btn btn-outline-custom" onclick="moveStudents()"><i class="fas fa-plus-circle"></i> Move Students</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('input[type=radio][name=category]').change(function() {
        var type = $(this).val();
        switch (type) {
            case 'stud_form':
                html = '<select class="form-control form-control-sm select2" id="moveOption">';
                html += '<option value="">--Move to which class?</option>';
                <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) { ?>
                    html += '<option value="<?= $classNum ?>"> <?= ucwords("form " . $classNum) ?> </option>';
                <?php } ?>
                html += '</select>';
                break;
            case 'stud_stream':
                html = '<select class="form-control form-control-sm select2" id="moveOption">';
                html += '<option value="">--Move to which stream?</option>';
                <?php foreach (STREAMS as $stream) { ?>
                    html += '<option value="<?= $stream->stream ?>"><?= $stream->stream ?></option>';
                <?php } ?>
                html += '</select>';
                break;
            case 'stud_gender':
                html = '<select class="form-control form-control-sm select2" id="moveOption">';
                html += '<option value="">--Change to which gender?</option>';
                html += '<option value="male">male</option>';
                html += '<option value="female">female</option>';
                html += '</select>';
                break;
            default:
                html = 'Invalid select option!';
                break;
        }
        $('#changeCategory').val(type);
        $('#moveSelectedValue').html(html);
    });

    $(document).on('change', '#moveOption', function() {
        var option = $(this).val();
        var type = $('#changeCategory').val();
        $('#moveModalFooter').addClass('d-none');
        if (option.length > 0) {
            html = '<input type="hidden" id="actionType" name="actionType" value="moveStudents">';
            html += '<input type="hidden" id="type" name="type" value="' + type + '">';
            html += '<input type="hidden" id="moveTo" name="moveTo" value="' + option + '">';
            $('#actionInputs').html(html);
            $('#moveModalFooter').removeClass('d-none');
        }
    });
</script>