<section>
    <div class="col-12 bg-img">
        <div class="container py-5 text-white text-capitalize">
            <h1>E-Library</h1>
            <?php if (isset($data['resHeading'])) { ?>
                <h5><?= $data['resHeading'] ?></h5>
            <?php } else { ?>
                <h5>Get all <i>Learning</i> and <i>Revision</i> materials from our well equiped library</h5>
            <?php } ?>
        </div>
    </div>
    <div class="container py-4">

        <?php
        switch ($fileView) {
            case 'list':
        ?>

                <ul class="list-group rounded">
                    <?php if (isset($data['resources'])) {
                        foreach ($data['resources'] as $resource) {
                            $appData = new App;
                            $subInfo = $appData->subInfo($resource->el_sub)
                    ?>

                            <li class="list-group-item bg-light rounded border-0 mb-2 ">
                                <table class="table table-borderless table-sm m-0 align-middle">
                                    <tr>
                                        <td class="pw-5"><span style="font-size: 35px;"><?= resExt($resource->el_ext) ?></span></td>
                                        <td class="text-start ">
                                            <a href="<?= ROOT . "library/read/" . $resource->el_key ?>" class="text-dark d-block">
                                                <b class="text-capitalize"><?= "form " . $resource->el_form . " " . $resource->el_stream . " " . $subInfo->sub_name . " " . $data['resCat'] ?></b>
                                                <br>
                                                <small class="show-read-more"><?= $resource->el_desc ?></small>
                                            </a>
                                        </td>
                                        <td class="pw-5">
                                            <?php if (docCheck("library", $resource->el_doc)) : ?>
                                                <a href="<?= docCheck("library", $resource->el_doc) ?>" class="btn btn-sm btn-outline-custom shadow-sm w-100 text-nowrap" download><i class="fas fa-download"></i>
                                                    <div class="d-none d-md-inline">Download</div>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </li>

                        <?php
                        }
                    } else { ?>

                        <li class="list-group-item bg-light rounded border-0 mb-2 py-3 ">
                            <?= $data['noRec'] ?>
                        </li>

                    <?php } ?>
                </ul>

            <?php
                break;
            case 'read':
            ?>

                <div class="card border-0 shadow-sm">
                    <?php if (!empty($data['resources']->el_desc)) : ?>
                        <div class="card-body">
                            <?= $data['resources']->el_desc ?>
                        </div>
                    <?php endif; ?>

                    <?php if (docCheck("library", $data['resources']->el_doc)) : ?>
                        <div class="card-body">
                            <iframe src="<?= docCheck("library", $data['resources']->el_doc) ?>" frameborder="0" style="width: 100%; height: 450px"></iframe>
                        </div>
                    <?php endif; ?>
                </div>

            <?php
                break;
            default:
            ?>

                <div class="row">
                    <div class="col-md-9">

                        <ul class="list-group rounded">
                            <?php if (!(isset($data['noRec']))) {
                                foreach ($data['resources'] as $resource) {
                                    $appData = new App;
                                    $subInfo = $appData->subInfo($resource->el_sub)
                            ?>

                                    <li class="list-group-item bg-light rounded border-0 mb-2 ">
                                        <table class="table table-borderless table-sm m-0 align-middle">
                                            <tr>
                                                <td class="pw-5"><span style="font-size: 35px;"><?= resExt($resource->el_ext) ?></span></td>
                                                <td class="text-start ">
                                                    <a href="<?= ROOT . "library/list/" . $resource->el_form . "/" . $resource->el_category ?>" class="text-dark d-block">
                                                        <b class="text-capitalize"><?= "form " . $resource->el_form . " " . $resource->el_stream . " " . $subInfo->sub_name . " " . str_replace("_", " ", $resource->el_category) ?></b>
                                                        <br>
                                                        <small class="show-read-more"><?= $resource->el_desc ?></small>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>

                                <?php
                                }
                            } else { ?>

                                <li class="list-group-item bg-light rounded border-0 mb-2 py-3 ">
                                    <?= $data['noRec'] ?>
                                </li>

                            <?php } ?>
                        </ul>

                    </div>
                    <div class="col-md-3">
                        <ul class="list-group">
                            <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) {
                                foreach (LIBRARY as $key => $value) { ?>
                                    <li class="list-group-item p-0 rounded-0"><a class="d-block p-2 px-3" href="<?= ROOT . "library/list/" . $classNum . "/" . $key ?>"><i class="fas fa-book"></i> <?= ucwords("form " . $classNum . " " . $value) ?> <i class="fas fa-arrow-right float-end"></i> </a></li>
                            <?php }
                            } ?>
                        </ul>
                    </div>
                </div>

        <?php
                break;
        }
        ?>

    </div>
</section>