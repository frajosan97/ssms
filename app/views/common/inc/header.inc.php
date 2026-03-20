<!-- 
    Author : Francis Kioko - <?= date("Y", time()) ?>
    Author Email: frajosan97@gmail.com
    Author Phone: (254) 796-594-366
    License : Frajosan Technologies
    License Url : https://www.frajosantech.co.ke
    Address : 222 - 90200 Kitui
 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= APPINFO->sch_metadesc ?>">
    <meta name="keywords" content="<?= implode(",", explode(" ", APPINFO->sch_name)) ?>,secondary schools in kenya,secondary school management system,school management system,management system,school, schools,secondary,frajosan IT consultancies,Consultancies,IT,best schools in kenya,kenya,catholic schools in kenya,ministry of education,education,catholic sponsored,AIC sponsered">
    <meta name="viewFolder" content="<?= VIEWFOLDER ?>">
    <title>
        <?= strtoupper(APPINFO->sch_name . " :: " . VIEWFOLDER) ?>
    </title>
    <link rel="shortcut icon" href="<?= imageCheck("logos", APPINFO->sch_logo, "default.png") ?>" type="image/x-icon">
    <!-- bootstrap framework css link -->
    <link rel="stylesheet" href="<?= ROOT ?>public/assets/css/bootstrap.css">
    <!-- Data Table CSS -->
    <link rel='stylesheet' href='<?= ROOT ?>public/assets/plugins/dataTables/css/dataTables.bootstrap5.min.css'>
    <!-- Font awesome css link -->
    <link rel="stylesheet" href="<?= ROOT ?>public/assets/fa/css/all.min.css">
    <!-- Bootstrap Select CSS -->
    <link href="<?= ROOT ?>public/assets/plugins/select2/select2.min.css" rel="stylesheet" />
    <!-- Timeline css -->
    <link rel="stylesheet" href="<?= ROOT ?>public/assets/css/timeline.css">
    <!-- Conditional css start -->
    <?php if (in_array(VIEWFOLDER, PORTALKEYS)) { ?>
        <!-- admin lte css -->
        <link rel="stylesheet" href="<?= ROOT ?>public/assets/css/adminlte.css">
    <?php } else { ?>
        <?php if (!(isMobile())): ?>
            <!-- menu kit css -->
            <link rel="stylesheet" href="<?= ROOT ?>public/assets/css/menu.kit.css">
        <?php endif; ?>
    <?php } ?>
    <?php if (file_exists(LIB_PATH . "public/assets/css/css.php")): ?>
        <!-- Inline css -->
        <?php require LIB_PATH . "public/assets/css/css.php"; ?>
    <?php endif; ?>
    <!-- Conditional css end -->
    <link rel="stylesheet" href="<?= ROOT ?>public/assets/css/app.css">
    <!-- customized app css -->
    <link rel="stylesheet" href="<?= ROOT ?>public/assets/css/app.css">
    <!-- required top js links -->
    <script src="<?= ROOT ?>public/assets/js/jquery.min.js"></script>
    <!-- chats js -->
    <script src="<?= ROOT ?>public/assets/js/charts.js"></script>

    <style>
        /* Language change */
        .skiptranslate span {
            display: none !important;
        }

        .VIpgJd-suEOdc {
            display: none !important;
        }

        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }

        .skiptranslate {
            font-size: 0 !important;
        }

        .skiptranslate>span,
        .skiptranslate>div {
            font-size: unset !important;
        }

        select option {
            margin: 40px;
            background: var(--primary);
            color: #fff;
            cursor: pointer !important;
            padding: 40px !important;
        }

        .goog-te-combo {
            padding: 5px 10px !important;
            border: 0 !important;
            border-radius: 3px !important;
            cursor: pointer !important;
        }

        /* VIpgJd-ZVi9od-ORHb-OEVmcd skiptranslate */
    </style>

</head>