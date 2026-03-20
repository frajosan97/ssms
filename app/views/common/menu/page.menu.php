<?php if (isMobile()) { ?>

    <div id="myNav" class="overlay">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <ul class="list-group rounded-0 overlay-content">
            <li class="list-group-item bg-transparent border-0 p-0 rounded-0"><a href="<?= ROOT ?>"><i class="fas fa-house"></i> Home</a></li>
            <li class="list-group-item bg-transparent border-0 p-0 rounded-0"><a href="<?= ROOT ?>about"><i class="fas fa-list-alt"></i> About</a></li>
            <li class="list-group-item bg-transparent border-0 p-0 rounded-0"><a href="<?= ROOT ?>auth/account"><i class="far fa-user"></i> Portals</a></li>
            <li class="list-group-item bg-transparent border-0 p-0 rounded-0"><a href="<?= ROOT ?>library"><i class="fas fa-book"></i> E-Library</a></li>
            <li class="list-group-item bg-transparent border-0 p-0 rounded-0"><a href="<?= ROOT ?>contact"><i class="fas fa-address-book"></i> Contact</a></li>
        </ul>
    </div>

<?php } else { ?>

    <nav class="navbar navbar-expand-lg shadow-sm navbar-light pg-theme fixed-onscroll text-capitalize">
        <div class="container">
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="main_nav">
                <ul class="navbar-nav">
                    <li class="nav-item hover active"> <a class="nav-link" href="<?= ROOT ?>"><i class="fas fa-house"></i> home </a> </li>
                    <li class="nav-item hover"> <a class="nav-link" href="<?= ROOT . 'about' ?>"><i class="fas fa-list-alt"></i> about us </a> </li>
                    <li class="nav-item hover dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"><i class="far fa-user"></i> portals </a>
                        <ul class="dropdown-menu animate fade-down border-0 rounded-0 py-0">
                            <?php foreach (PORTALS as $portal => $values) { ?>
                                <?php if (!($portal == "admin")) { ?>
                                    <li><a class="dropdown-item" href="<?= ROOT . $portal ?>"> <?= ucwords($portal) ?></a></li>
                                <?php  } elseif (APPINFO->sch_token == "sch") { ?>
                                    <li><a class="dropdown-item" href="<?= ROOT . $portal ?>"> <?= ucwords($portal) ?></a></li>
                                <?php  } ?>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item hover dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"><i class="fas fa-book"></i> library </a>
                        <ul class="dropdown-menu animate fade-down border-0 rounded-0 py-0">
                            <?php for ($classNum = 1; $classNum <= APPINFO->sch_cl_num; $classNum++) { ?>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fas fa-university"></i>
                                        <?= ucwords("form " . toWords($classNum)) ?> <i class="fas fa-angle-right float-end"></i>
                                    </a>
                                    <ul class="submenu dropdown-menu animate fade-down border-0 rounded-0 py-0">
                                        <?php foreach (LIBRARY as $key => $value) { ?>
                                            <li><a class="dropdown-item" href="<?= ROOT . "library/list/" . $classNum . "/" . $key ?>"><i class="fas fa-book"></i>
                                                    <?= ucwords($value) ?>
                                                </a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item hover"> <a class="nav-link" href="<?= ROOT . 'alumni' ?>"><i class="fas fa-user-graduate"></i> alumni </a> </li>
                    <li class="nav-item hover"> <a class="nav-link" href="<?= ROOT . 'blog' ?>"><i class="fas fa-newspaper"></i> blog </a> </li>
                    <li class="nav-item hover"> <a class="nav-link" href="<?= ROOT . 'download' ?>"><i class="fas fa-download"></i> downloads </a> </li>
                    <li class="nav-item hover"> <a class="nav-link" href="<?= ROOT . 'contact' ?>"><i class="fas fa-address-book"></i> contacts </a> </li>
                </ul>
            </div>
        </div>
    </nav>

<?php } ?>