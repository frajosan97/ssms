<?php

switch ($fileView) {
    case "create":
        if (in_array(VIEWFOLDER, array_keys(PORTALS))) {
?>

            <form enctype="multipart/form-data" class="addDownloadForm">
                <div class="card border-0 shadow-sm">
                    <div class="card-header text-uppercase">create new download</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="down_title">Download Title</label>
                            <input type="text" name="down_title" id="down_title" placeholder="Download Title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="doc">Download File</label>
                            <input type="file" name="doc" id="doc" placeholder="Download Title" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent mb-2">
                        <button type="reset" class="btn btn-outline-danger float-start"><i class="fas fa-history"></i> Reset</button>
                        <button class="btn btn-outline-custom float-end"><i class="fas fa-save"></i> Save Download</button>
                    </div>
                </div>
            </form>

        <?php } else { ?>

            <script>
                window.location.href = "<?= ROOT ?>download";
            </script>

        <?php
        }
        break;
    case "read":
        if (isset($data['downInfo'])) {
        ?>

            <div class="container py-4">
                <div class="card border-0 shadow-sm my-3">
                    <div class="card-header text-uppercase bg-transparent border-0 h4"><?= $data['downInfo']->down_title ?></div>
                    <hr class="dividerDiv1 m-0">
                    <div class="card-body">
                        <?php
                        switch ($data['downInfo']->down_type) {
                            case 'pdf':
                        ?>
                                <iframe class="framecustom" src="<?= ROOT . "public/assets/docs/downloads/" . $data['downInfo']->down_link ?>" frameborder="0"></iframe>
                        <?php
                                break;
                            default:

                                break;
                        }
                        ?>
                    </div>
                </div>
            </div>

        <?php } else { ?>

            <div class="container py-4">
                <div class="card border-0 shadow my-3">
                    <div class="card-body text-center py-5">
                        <h4>Sorry, but there is no download found matching your search request!</h4>
                    </div>
                </div>
            </div>

        <?php
        }
        break;
    default:
        if (in_array(VIEWFOLDER, array_keys(PORTALS))) {
        ?>

            <div class="card border-0 shadow-sm text-capitalize">
                <div class="card-header text-uppercase">school downloads</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-condensed table-striped table-hover align-middle" id="dataTable1">
                            <thead class="maincolor text-nowrap">
                                <tr>
                                    <th>Title</th>
                                    <th>Document</th>
                                    <th class="pw-10">Type</th>
                                    <th class="pw-10">Size</th>
                                    <th class="pw-10">Date</th>
                                    <th class="pw-10">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($data['downloads'])) :
                                    foreach ($data['downloads'] as $key => $value) {
                                ?>
                                        <tr>
                                            <td><?= $value->down_title ?></td>
                                            <td><a href="<?= ROOT . "download/read/" . $value->down_key ?>" target="_blank"><?= $value->down_link ?></a></td>
                                            <td><?= $value->down_type ?></td>
                                            <td><?= number_format(($value->down_size / 1024), 2) ?> Mb</td>
                                            <td><?= date("d/m/Y", strtotime($value->date)) ?></td>
                                            <td><button class="btn btn-sm btn-outline-danger w-100" onclick="deleteDown('<?= $value->down_key ?>')"><i class="fas fa-trash-alt"></i> Delete</button></td>
                                        </tr>
                                <?php
                                    }
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php } else { ?>

            <div class="col-12 bg-img">
                <div class="container py-3 text-white text-capitalize">
                    <h3><?= APPINFO->sch_name ?></h3>
                    <h4>Downloads</h4>
                </div>
            </div>
            <div class="container py-4">

                <ul class="list-group rounded">
                    <?php if (isset($data['downloads'])) {
                        foreach ($data['downloads'] as $key => $value) {
                    ?>

                            <li class="list-group-item bg-light rounded border-0 mb-2 ">
                                <table class="table table-borderless table-sm m-0 align-middle">
                                    <tr>
                                        <td class="pw-5"><span style="font-size: 35px;"><?= resExt($value->down_type) ?></span></td>
                                        <td class="text-start ">
                                            <a href="<?= ROOT . "download/read/" . $value->down_key ?>" class="text-dark d-block">
                                                <b class="text-capitalize"><?= $value->down_title ?></b>
                                                <br>
                                                <small class="show-read-more"><?= $value->down_link ?></small>
                                                <br>
                                                <i><small>File Size: <?= $value->down_size ?> Date: <?= date("d/m/Y", strtotime($value->date)) ?></small></i>
                                            </a>
                                        </td>
                                        <td class="pw-5">
                                            <?php if (docCheck("downloads", $value->down_link)) : ?>
                                                <a href="<?= docCheck("downloads", $value->down_link) ?>" class="btn btn-sm btn-outline-custom shadow-sm w-100 text-nowrap" download><i class="fas fa-download"></i>
                                                    <div class="d-none d-md-inline">Download</div>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </li>

                        <?php
                        }
                    } else {
                        ?>

                        <li class="list-group-item bg-light rounded border-0 py-5 text-center ">
                            <h4>Sorry, but there is no download found matching your search request!</h4>
                        </li>

                    <?php } ?>
                </ul>

            </div>
        <?php } ?>
<?php
        break;
}
