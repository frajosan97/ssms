<?php

switch ($fileView) {
    case "receive":
?>

        <div class="card border-0 shadow-sm">
            <?php if (isset($data['source'])) { ?>
                <div class="card-header">RECEIVING INCOME FROM</div>
                <div class="card-body">
                </div>
            <?php } else { ?>
                <div class="card-body">
                    You cannot receive income from an unexisting income source!
                </div>
            <?php } ?>
        </div>

    <?php
        break;
    case "statement":
        break;
    default:
    ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header">OTHER SOURCES OF REVENUE</div>
            <div class="card-body">
                <blockquote class="m-0 mb-3 bg-light">
                    <a href="javascript.void:(0)" data-bs-toggle="modal" data-bs-target="#addIncomeSource" class="d-block"><i class="fas fa-plus-circl"></i> Add source of income</a>
                </blockquote>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-condensed text-nowrap table-striped table-hover" id="dataTable1">
                        <thead class="bg-light">
                            <tr class="text-capitalize">
                                <th>Source of income</th>
                                <th>Type</th>
                                <th class="pw-10">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['incomeSource'])) : ?>
                                <?php foreach ($data['incomeSource'] as $key => $value) { ?>
                                    <tr>
                                        <td><?= ucfirst($value->source) ?></td>
                                        <td><?= ucwords($value->type) ?></td>
                                        <td>
                                            <a href="<?= ROOT . VIEWFOLDER ?>/income/receive/<?= $value->source_key ?>" class="btn btn-sm btn-outline-custom"><i class="fas fa-hand"></i> Receive Income</a>
                                            <a href="<?= ROOT . VIEWFOLDER ?>/income/statement/<?= $value->source_key ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-list-alt"></i> Statement</a>
                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<?php
        break;
}
