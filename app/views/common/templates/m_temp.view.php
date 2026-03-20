<?php include_once incFile("header"); ?>

<body>

    <?php include_once incFile("alert"); ?>
    <?php include_once incFile("alert2"); ?>
    <?php if (VIEWFOLDER == "auth") { ?>

        <div class="container-fluid d-flex align-items-center justify-content-center vh-100 bg-img">
            <?php if ($fileView == "account") { ?>

                <div class="col-12">
                    <h6 class="text-white">I WANT TO LOGIN AS:</h6>
                    <ul class="list-group">
                        <?php foreach (PORTALS as $portal => $values) { ?>
                            <li class="list-group-item p-0 rounded-0 my-1 border"><a class="d-block p-2 px-3" href="<?= ROOT . $portal ?>"><i class="fas fa-user"></i> <?= ucwords($portal) ?> <i class="fas fa-arrow-right float-end"></i> </a></li>
                        <?php } ?>
                        <li class="border-0 my-1 border"><a href="<?= APPINFO->sch_domain ?>" target="_blank" class="btn btn-custom d-block text-white">Go to main website <i class="fas fa-external-link"></i></a></li>
                    </ul>
                </div>

            <?php } else { ?>

                <div class="col-md-4">
                    <div class="card border-custom overlayContainer">
                        <!-- loader start -->
                        <div class="col-12 loadContainer d-none d-flex justify-content-center align-items-center">
                            <div class="col">
                                <div class="spinner-grow" role="status"></div>
                                <h6>Validating, Please wait...</h6>
                            </div>
                        </div>
                        <!-- loader end -->
                        <div class="card-header border-0 bg-transparent text-center">
                            <img src="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>" alt="School Logo" style="max-height: 80px;">
                            <h6><?= strtoupper(APPINFO->sch_name) ?></h6>
                            <h6 class="bg-light rounded-pill p-1 text-uppercase"><?= $data['formTitle'] ?></h6>
                            <hr class="dividerDiv1 my-1" />
                        </div>
                        <div class="card-body p-0">
                            <?php require $fileName; ?>
                        </div>
                    </div>
                    <center class="mt-3"><a href="<?= APPINFO->sch_domain ?>" target="_blank" class="text-white">Go to main website <i class="fas fa-external-link"></i></a></center>
                </div>
            <?php } ?>
        </div>

    <?php } else { ?>

        <section class="<?php if (VIEWFOLDER == "home") { ?>home-bg<?php } else { ?> pg-theme <?php } ?>">
            <div class="container py-3">
                <table class="table table-borderless table-sm align-middle m-0">
                    <tr>
                        <td class="p-0 text-start"><img src="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>" alt="School Logo" style="max-height: 60px;"></td>
                        <td class="p-0 text-end"><button class="btn btn-light" onclick="openNav()"><i class="fas fa-bars"></i></button></td>
                    </tr>
                </table>
                <?php if (VIEWFOLDER == "home") : ?>
                    <div class="col-md-12 text-center text-white text-uppercase py-5 mb-5">
                        <h4><i>Welcome!</i></h4>
                        <h5><?= APPINFO->sch_name ?></h5>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php if (file_exists(LIB_PATH . DS . 'app/views/common/menu/page.menu.php')) : ?><?php include_once LIB_PATH . DS . 'app/views/common/menu/page.menu.php' ?><?php endif; ?>
        <!-- DYNAMIC PAGES BODY -->
        <?php if (VIEWFOLDER == "home") {
            require $fileName;
        } else { ?>
            <section class="mb-5 bg-light" style="min-height: 100vh">
                <?php require $fileName; ?>
            </section>
        <?php } ?>
        <!-- DYNAMIC PAGES BODY END -->
        <!-- MOBILE APP MENU -->
        <section class="">
            <ul class="nav fixed-bottom nav-pills nav-fill bg-white shadow text-center">
                <li class="nav-item" style="width: 20%;">
                    <a class="nav-link text-dark" href="<?= ROOT ?>"><i class="fas fa-home"></i><br>Home</a>
                </li>
                <li class="nav-item" style="width: 20%;">
                    <a class="nav-link text-dark" href="<?= ROOT ?>about"><i class="fas fa-file"></i><br>About</a>
                </li>
                <li class="nav-item" style="width: 20%;">
                    <a class="nav-link text-dark" href="<?= ROOT ?>auth/account"><i class="fas fa-user-plus"></i><br>Profile</a>
                </li>
                <li class="nav-item" style="width: 20%;">
                    <a class="nav-link text-dark" href="<?= ROOT ?>library"><i class="fas fa-folder-open"></i><br>Library</a>
                </li>
                <li class="nav-item" style="width: 20%;">
                    <a class="nav-link text-dark" href="<?= ROOT ?>contact"><i class="fas fa-phone"></i><br>Contact</a>
                </li>
            </ul>
        </section>

    <?php } ?>

    <?php include_once incFile("footer"); ?>