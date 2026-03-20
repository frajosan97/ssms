<?php include_once incFile("header"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>" alt="" height="60" width="60">
            <h6>Loading... Please Wait!</h6>
        </div>
        <!-- top nav bar -->
        <section class="<?php if ($name == "dashboard") : ?> nav-section <?php endif; ?>">
            <nav class="main-header navbar navbar-expand navbar-white navbar-light border-0 shadow-sm">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?= ROOT ?>" class="nav-link">Main website <i class="fas fa-external-link"></i></a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="navbar-search" href="#" role="button"><i class="fas fa-search"></i></a>
                        <div class="navbar-search-block">
                            <form class="form-inline">
                                <div class="input-group input-group-sm">
                                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-navbar" type="submit"><i class="fas fa-search"></i></button>
                                        <button class="btn btn-navbar" type="button" data-widget="navbar-search"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-user-tie"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                            <?php if (!(VIEWFOLDER == "student")) : ?>
                                <li><a class="dropdown-item" href="<?= ROOT . VIEWFOLDER ?>/staff/profile/<?= $_SESSION[VIEWFOLDER]->user_key ?>"><i class="fas fa-wrench"></i> My Account</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?= ROOT ?>logout/<?= VIEWFOLDER ?>"><i class="fas fa-sign-out"></i> Sign Out</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </section>
        <!-- / top navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-custom elevation-4 pg-theme">
            <!-- Brand Logo -->
            <a href="" class="cursor-pointer2 brand-link pg-theme text-white">
                <img src="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>" alt="" class="brand-image img-circle bg-light my-auto" style="opacity: .8">
                <span class="brand-text text-white my-auto">
                    <strong><?= strtoupper("- " . VIEWFOLDER . ' portal') ?></strong>
                </span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- user photo -->
                <div class="user-panel p-3">
                    <div class="col-md-12 user-profile d-flex justify-content-center align-items-middle my-3">
                        <?php if (VIEWFOLDER == "student") { ?>
                            <img src="<?= imageCheck("profiles", $_SESSION[VIEWFOLDER]->stud_pass, "avatar.png") ?>" class="rounded-circle bg-light p-1" alt="User Image">
                        <?php } else { ?>
                            <img src="<?= imageCheck("profiles", $_SESSION[VIEWFOLDER]->user_pass, "avatar.png") ?>" class="rounded-circle bg-light p-1" alt="User Image">
                        <?php } ?>
                    </div>
                </div>
                <!-- / end user photo -->
                <!-- Sidebar Menu -->
                <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column text-capitalize" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="<?= ROOT . VIEWFOLDER ?>" class="cursor-pointer2 nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>dashboard <i class="right fas fa-angle-down"></i></p>
                            </a>
                        </li>
                        <?php if (file_exists(LIB_PATH . DS . 'app/views/common/menu/portal.menu.php')) {
                            include_once LIB_PATH . DS . 'app/views/common/menu/portal.menu.php';
                        } ?>
                    </ul>
                </nav>
                <!-- app download -->
            </div><!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <?php include_once incFile("alert"); ?>
            <?php include_once incFile("alert2"); ?>

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row text-capitalize">
                        <div class="col-12">
                            <?php if (!($name == "Dashboard")) : ?>
                                <h4><?= cleanHtml($name) ?></h4>
                                <hr class="dividerDiv1 m-0">
                            <?php endif; ?>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="alertbox alertContainer"></div>
                            <?php require $fileName; ?>
                        </div>
                    </div>
                </div>
                <!--/. container-fluid -->
            </section><!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Main Footer -->

        <?php if (isMobile()) { ?>
            <footer class="main-footer shadow border-0 p-0">
                <nav class="nav nav-pills d-flex justify-content-between p-0">
                    <a class="flex-fill text-center nav-link rounded-0" href="<?= ROOT . VIEWFOLDER ?>"><i class="fas fa-home"></i> <br> Home</a>
                    <a class="flex-fill text-center nav-link rounded-0" href="<?= ROOT . VIEWFOLDER ?>/student/search"><i class="fas fa-graduation-cap"></i> <br> Students</a>
                    <a class="flex-fill text-center nav-link rounded-0" href="<?= ROOT . VIEWFOLDER ?>/exam"><i class="fas fa-folder"></i> <br> Exams</a>
                    <a class="flex-fill text-center nav-link rounded-0" href="<?= ROOT . VIEWFOLDER ?>/library"><i class="fas fa-book"></i> <br> Library</a>
                    <a class="flex-fill text-center nav-link rounded-0" href="javascript.void:(0)" data-widget="pushmenu"><i class="fas fa-ellipsis"></i> <br> More</a>
                </nav>
            </footer>
        <?php } else { ?>
            <footer class="main-footer shadow border-0">
                <?php include_once incFile("copyright"); ?>
            </footer>
        <?php } ?>

        <!-- System modals -->
        <?php include_once incFile("modal"); ?>
    </div>

    <?php include_once incFile("footer"); ?>