<!-- HOME PAGE -->
<?php if (isMobile()) { ?>

    <section class="mobile-body mb-5 bg-light" style="margin-top: -50px; min-height: 100vh; border-radius: 50px 50px 0 0;">
        <div class="container py-5">
            <?php require incFile("home"); ?>
        </div>
    </section>

<?php } else { ?>

    <section class="">
        <div class="home-bg p-3">
            <div class="col-12 rounded border">
                <div class="container text-white" style="padding: 150px 0;">
                    <h1>Welcome to: <b><?= ucwords(APPINFO->sch_name) ?></b></h1>
                    <p><?= ucwords(APPINFO->sch_metadesc) ?></p>
                </div>
            </div>
        </div>
        <div class="container py-5">
            <?php require incFile("home"); ?>
        </div>
        <div class="col-12 sch_advert pg-theme">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#fefefe" fill-opacity="1" d="M0,160L48,154.7C96,149,192,139,288,138.7C384,139,480,149,576,160C672,171,768,181,864,176C960,171,1056,149,1152,149.3C1248,149,1344,171,1392,181.3L1440,192L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
            </svg>
            <a href="<?= ROOT ?>library" class="text-white">
                <div class="col-12 py-3 text-center" style="margin-top: -50px;">
                    <h1><i class="fas fa-angle-double-right"></i> Click to access our Electronic Library</h1>
                </div>
            </a>
        </div>
    </section>

<?php } ?>
<!-- HOME PAGE END -->