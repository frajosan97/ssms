<?php

switch ($fileView) {
    case "create":
?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="card border-0 shadow-sm text-capitalize">
                <div class="card-header">CREATE LIBRARY RESOURCE</div>
                <div class="card-body">
                    <div class="row clearfix">
                        <input type="hidden" name="keyGen" value="<?= time() ?>">
                        <div class="col-md-6 mb-3">
                            <select name="el_form" class="form-control" required>
                                <option value="">--Resource Class / Form--</option>
                                <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) { ?>
                                    <option value="<?= $classNum ?>"><?= strtoupper("form " . $classNum) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <select name="el_stream" class="form-control">
                                <option value="">--Class Stream (Optional)--</option>
                                <?php foreach (STREAMS as $stream) { ?>
                                    <option value="<?= $stream->stream ?>"><?= strtoupper($stream->stream) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <select name="el_sub" class="form-control" required>
                                <option value="">--Subject--</option>
                                <?php foreach ($data['sch_sub'] as $key => $value) { ?>
                                    <option value="<?= $key ?>"><?= strtoupper("[" . $key . "] " . $value->sub_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <select name="el_category" class="form-control" required>
                                <option value="">--Resource Category--</option>
                                <?php foreach (LIBRARY as $key => $value) { ?>
                                    <option value="<?= $key ?>"><?= strtoupper($value) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <input type="file" name="doc" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <textarea name="el_desc" rows="3" class="form-control" placeholder="Description / Message here..."></textarea>
                        </div>
                        <div class="col-md-12 d-flex justify-content-between">
                            <button type="reset" class="btn btn-outline-danger"><i class="fas fa-undo"></i> Reset</button>
                            <button class="btn btn-outline-custom"><i class="fas fa-save"></i> Post Resource</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    <?php
        break;
    default:
    ?>

        <div class="card border-0 shadow-sm text-capitalize">
            <div class="card-header">LIBRARY RESOURCES</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-condensed table-striped table-hover align-middle" id="dataTable1">
                        <thead class="maincolor text-nowrap">
                            <tr>
                                <th class="pw-1">#</th>
                                <th>Subject</th>
                                <th>Content</th>
                                <th>Type</th>
                                <th>Class</th>
                                <th>Date</th>
                                <th class="pw-10">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['resources'])) :
                                $appData = new App;
                                foreach ($data['resources'] as $resource) {
                                    $subInfo = $appData->subInfo($resource->el_sub);
                            ?>
                                    <tr>
                                        <td><?= $sno++ ?></td>
                                        <td><?= $subInfo->sub_name ?></td>
                                        <td><?= $resource->el_desc ?></td>
                                        <td><?= resExt($resource->el_ext) . " " . $resource->el_ext ?></td>
                                        <td><?= $resource->el_form . " " . $resource->el_stream ?></td>
                                        <td><?= date("d, M-Y", strtotime($resource->date)) ?></td>
                                        <td class="text-nowrap">
                                            <a href="<?= ROOT . "library/read/" . $resource->el_key ?>" target="_blank" class="btn btn-sm btn-outline-custom"><i class="fas fa-eye"></i> Explore</a>
                                            <?php if (!(VIEWFOLDER == "student")) : ?>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php
                                } endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<?php
        break;
}
