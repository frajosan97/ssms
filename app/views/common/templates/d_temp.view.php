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

        <!-- Top Contacts -->
        <section class="col-12 top-contacts theme2">
            <div class="container">
                <div class="col">
                    <ul class="list-group list-group-horizontal contacts-listing">
                        <li class="list-group-item rounded-0 border-0 py-2 bg-transparent d-none d-sm-none d-md-block"><a href="tel: <?= '+254' . APPINFO->sch_phone ?>"> Call Us: <?= '+254' . APPINFO->sch_phone ?></a></li>
                        <li class="list-group-item rounded-0 border-0 py-2 bg-transparent d-none d-sm-none d-md-block"><a href="mailto:<?= APPINFO->sch_email ?>"> Email Us: <?= APPINFO->sch_email ?></a></li>
                        <li class="list-group-item rounded-0 border-0 py-2 bg-transparent d-none d-sm-none d-md-block"><div id="google_translate_element"></div></li>
                    </ul>
                </div>
            </div>
            <div class="col-12 pih-4 bg-dark"></div>
            <div class="col-12 pih-1 bg-white"></div>
            <div class="col-12 pih-4 bg-danger"></div>
            <div class="col-12 pih-1 bg-white"></div>
            <div class="col-12 pih-4 bg-success"></div>
        </section>
        <section class="">
            <div class="container py-2">
                <a href="<?= ROOT ?>" class="text-dark text-center text-uppercase">
                    <table class="">
                        <tr>
                            <td class="p-0"><img src="<?= ROOT ?>public/assets/images/logos/min.jpg" alt="School Logo" style="max-height: 80px;"></td>
                            <td class="p-0"><img src="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>" alt="School Logo" style="max-height: 80px;"></td>
                            <td class="p-0">
                                <h4 class="m-0 fw-bolder maincolor">Ministry of Education</h4>
                                <h5 class="m-0 fw-bolder">
                                    <?= APPINFO->sch_name ?>
                                </h5>
                            </td>
                        </tr>
                    </table>
                </a>
            </div>
        </section>
        <!-- ============= COMPONENT ============== -->
        <section class="nav-section">
            <?php if (file_exists(LIB_PATH . DS . 'app/views/common/menu/page.menu.php')) : ?><?php include_once LIB_PATH . DS . 'app/views/common/menu/page.menu.php' ?><?php endif; ?>
        </section>
        <!-- ============= COMPONENT END// ============== -->

        <!-- DYNAMIC PAGES BODY -->
        <?php require $fileName; ?>
        <!-- DYNAMIC PAGES BODY END -->

        <!-- footer section -->
        <section class="footer-section pg-theme">
            <div class="container py-5">
                <div class="row clearfix">
                    <!-- footer links 1 -->
                    <div class="col-sm-6 col-md-3 py-4">
                        <h6 class="text-uppercase fw-bold text-start">
                            <?= ucwords(APPINFO->sch_name) ?>
                        </h6>
                        <hr class="dividerDiv4" />
                        <p>
                            <?= ucfirst(APPINFO->sch_metadesc) ?>
                        </p>
                    </div>
                    <!-- footer links 2 -->
                    <div class="col-sm-6 col-md-3 py-4">
                        <h6 class="text-uppercase fw-bold text-start">Quick Links</h6>
                        <hr class="dividerDiv4" />
                        <ul class="list-group rounded-0 text-capitalize">
                            <?php foreach (PORTALS as $portal => $values) { ?>
                                <?php if (!($portal == 'admin')) : ?>
                                    <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap"><a href="<?= ROOT . $portal ?>"><i class="fas fa-arrow-right"></i>
                                            <?= ucwords($portal) ?>
                                        </a></li>
                                <?php endif; ?>
                            <?php } ?>
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap"><a href="<?= ROOT . 'library' ?>"><i class="fas fa-arrow-right"></i> library</a></li>
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap"><a href="<?= ROOT . 'downloads' ?>"><i class="fas fa-arrow-right"></i> downloads</a></li>
                        </ul>
                    </div>
                    <!-- footer links 3 -->
                    <div class="col-sm-6 col-md-3 py-4">
                        <h6 class="text-uppercase fw-bold text-start">Useful links</h6>
                        <hr class="dividerDiv4" />
                        <ul class="list-group rounded-0">
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap"><a href="https://www.education.go.ke" target="_blank"><i class="fas fa-arrow-right"></i> Ministry of Education</a></li>
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap"><a href="https://kuccps.net" target="_blank"><i class="fas fa-arrow-right"></i> KUCCPS</a></li>
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap"><a href="https://www.tsc.go.ke" target="_blank"><i class="fas fa-arrow-right"></i> TSC</a></li>
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap"><a href="https://kicd.ac.ke" target="_blank"><i class="fas fa-arrow-right"></i> KICD</a></li>
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap"><a href="https://nemis.education.go.ke" target="_blank"><i class="fas fa-arrow-right"></i> NEMIS</a></li>
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap"><a href="https://www.knec.ac.ke" target="_blank"><i class="fas fa-arrow-right"></i> KNEC</a></li>
                        </ul>
                    </div>
                    <!-- footer links 4 -->
                    <div class="col-sm-6 col-md-3 py-4">
                        <h6 class="text-uppercase fw-bold text-start">Contact</h6>
                        <hr class="dividerDiv4" />
                        <ul class="list-group rounded-0">
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap">
                                <a href="javascript.void:(0)"><i class="fas fa-location-arrow"></i> P.O Box
                                    <?= APPINFO->sch_address . " - " . APPINFO->sch_postcode ?>
                                </a>
                            </li>
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap">
                                <a href="javascript.void:(0)"><i class="fas fa-location"></i>
                                    <?= APPINFO->sch_town . " - " . APPINFO->sch_city ?>
                                </a>
                            </li>
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap">
                                <a href="tel: +254<?= APPINFO->sch_phone ?>"><i class="fas fa-phone"></i> +254
                                    <?= APPINFO->sch_phone ?>
                                </a>
                            </li>
                            <li class="list-group-item px-0 rounded-0 bg-transparent border-0 footer-links text-nowrap">
                                <a href="mailto:info@<?= APPINFO->sch_email ?>"><i class="fas fa-envelope"></i>
                                    <?= APPINFO->sch_email ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- copyright -->
                <hr class="dividerDiv2">
                <div class="col-md-12 text-center text-md-start footer-links">
                    <?php include_once incFile("copyright"); ?>
                </div>
            </div>
        </section>

    <?php } ?>

    <?php include_once incFile("footer"); ?>