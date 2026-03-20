<?php

switch ($fileView) {
    case "manage":
?>

        <div class="card border-0 shadow-sm">
            <?php if (isset($data['grdSys'])) { ?><div class="card-body text-capitalize">
                    <form action="" method="post">
                        <input type="hidden" name="grading_type" value="<?= $data['grdSys']['grd_subcat'] ?>">
                        <ul class="list-group list-group-horizontal m-0 border-0 bg-light mb-2">
                            <li class="list-group-item bg-transparent border-0 p-1"> <span class="btn btn-sm btn-outline-custom" onclick="printDiv('printGrdSys')"><i class="fas fa-print"></i> Print</span> </li>
                            <li class="list-group-item bg-transparent border-0 p-1"> <button class="btn btn-sm btn-outline-success"><i class="fas fa-save"></i> Save Edited</button> </li>
                        </ul>
                        <div class="table-responsive" id="printGrdSys">
                            <table class="table table-bordered table-hover table-striped text-nowrap text-capitalize align-middle">
                                <thead class="maincolor">
                                    <tr>
                                        <th colspan="6" class="text-center">
                                            <h5 class="m-0"><?= strtoupper(APPINFO->sch_name) ?></h5>
                                            <h6 class="m-0"><?= strtoupper($data['grdSys']['grd_subcat'] . " grading system") ?></h6>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Lowest Mark</th>
                                        <th>Highest Mark</th>
                                        <th>Grade</th>
                                        <th>Points</th>
                                        <th>Remarks</th>
                                        <th>Kisw (Remarks)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['grdSys']['grades'] as $key => $value) { ?>
                                        <tr>
                                            <input type="hidden" name="grds_key[]" value="<?= $value->grds_key ?>">
                                            <td class="p-0"><input type="number" name="grds_min[]" value="<?= $value->grds_min ?>" class="form-control bg-transparent form-control-sm rounded-0 border-0" required /></td>
                                            <td class="p-0"><input type="number" name="grds_max[]" value="<?= $value->grds_max ?>" class="form-control bg-transparent form-control-sm rounded-0 border-0" required /></td>
                                            <td class="p-0"><input type="text" name="grds_grade[]" value="<?= $value->grds_grade ?>" class="form-control bg-transparent form-control-sm rounded-0 border-0" required /></td>
                                            <td class="p-0"><input type="number" name="grds_point[]" value="<?= $value->grds_point ?>" class="form-control bg-transparent form-control-sm rounded-0 border-0" required /></td>
                                            <td class="p-0"><input type="text" name="grds_rem[]" value="<?= $value->grds_rem ?>" class="form-control bg-transparent form-control-sm rounded-0 border-0" required /></td>
                                            <td class="p-0"><input type="text" name="grds_lugha[]" value="<?= $value->grds_lugha ?>" class="form-control bg-transparent form-control-sm rounded-0 border-0" required /></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            <?php } else { ?>
                <div class="card-body text-capitalize text-danger">
                    Error accessing the grading system!
                </div>
            <?php } ?>
        </div>

    <?php
        break;
    default:
    ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header">SCHOOL ACTIVE GRADING SYSTEMS</div>
            <div class="card-body text-capitalize">
                <blockquote class="bg-light rounded m-0 mb-3">
                    <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#creategrading" class="btn btn-outline-custom btn-sm fw-bold"><i class="fas fa-plus-circle"></i> add grading system</a>
                </blockquote>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped text-nowrap text-capitalize align-middle" id="dataTable1">
                        <thead class="maincolor">
                            <tr>
                                <th class="pw-3">S/No</th>
                                <th>Grading System</th>
                                <th class="pw-15">Created By</th>
                                <th class="pw-15">Date</th>
                                <th class="pw-15">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($data['grdSys'])) :
                                foreach ($data['grdSys'] as $grading => $value) {
                            ?>
                                    <tr>
                                        <td><?= $sno++ ?>.</td>
                                        <td><?= $value->grd_subcat . " grading system" ?></td>
                                        <td><?= $value->addby ?></td>
                                        <td><?= date(date("d/m/Y", strtotime($value->date))) ?></td>
                                        <td class="text-nowrap">
                                            <a href="<?= ROOT ?>staff/grading/manage/<?= $value->grd_key ?>" class="btn btn-outline-custom btn-sm"><i class="fas fa-eye"></i> | <i class="fas fa-edit"></i></a>
                                            <button class="btn btn-outline-danger btn-sm" <?php if (!($value->grd_subcat == "default")) : ?> onclick="deleteGrdSys('<?= $value->grd_key ?>','<?= $value->grd_subcat . ' grading system' ?>')" <?php endif; ?>><i class="fas fa-trash-alt"></i> Delete</button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<?php
        break;
}
