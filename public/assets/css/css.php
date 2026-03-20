<style>
    :root {
        --primary: <?= APPINFO->sch_prim_theme ?>;
        --secondary: <?= APPINFO->sch_sec_theme ?>;
        --hoverColor: red;
    }

    .bg-logo {
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.900), rgba(255, 255, 255, 0.900)), url('<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>');
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
    }

    .bg-img {
        background: linear-gradient(to left, var(--secondary), var(--secondary)), url('<?= imageCheck("bg", APPINFO->sch_bg, "default.png") ?>');
        background-position: top;
        background-size: cover;
        background-attachment: fixed;
        background-repeat: no-repeat
    }

    .home-bg {
        background: linear-gradient(to left, var(--secondary), var(--secondary)), url('<?= imageCheck("bg", APPINFO->sch_bg, "default.png") ?>');
        background-position: top;
        background-size: cover;
        background-repeat: no-repeat;
    }

    <?php
    for ($i = 1; $i <= 100; $i++) {
        echo ".pw-" . $i . "{ width: " . $i . "%!important; }";
        echo ".ph-" . $i . "{ height: " . $i . "%!important; }";
        echo ".piw-" . $i . "{ width: " . $i . "px!important; }";
        echo ".pih-" . $i . "{ height: " . $i . "px!important; }";
    }
    ?>
</style>