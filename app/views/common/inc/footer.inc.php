<!-- Page scripts -->
<?php if (in_array(VIEWFOLDER, PORTALKEYS)) { ?>
    <script src="<?= ROOT ?>public/assets/js/adminlte.js"></script>
    <script src="<?= ROOT ?>public/assets/js/sweetalert.js"></script>
    <?php if (isset($_SESSION['status'])) : ?>
        <script>
            Swal.fire(
                '<?= $_SESSION['status_code'] ?>',
                '<?= ucfirst(str_replace('_', ' ', $_SESSION['status'])) ?>',
                '<?= $_SESSION['status_code'] ?>',
            ).then(function() {
                location.href = window.location;
            });
        </script>
        <?php unset($_SESSION['status']); ?>
    <?php endif; ?>
<?php } else { ?>
    <?php if (!(isMobile())) : ?>
        <script src="<?= ROOT ?>public/assets/js/menukit.js"></script>
    <?php endif; ?>
<?php } ?>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: '<?= APPINFO->sch_lag ?>',
            autoDisplay: true,
        }, 'google_translate_element');
    }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<!-- ckeditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/super-build/ckeditor.js"></script>
<script src="<?= ROOT ?>public/assets/js/ckcustom.js"></script>
<!-- jquery -->
<script src="<?= ROOT ?>public/assets/js/jquery.js"></script>
<!-- bootstrap js -->
<script src="<?= ROOT ?>public/assets/js/bootstrap.js"></script>
<!-- Bootstrap Select JS -->
<script src="<?= ROOT ?>public/assets/plugins/select2/select2.min.js"></script>
<!-- Data Table JS -->
<script src='<?= ROOT ?>public/assets/plugins/dataTables/js/jquery.dataTables.min.js'></script>
<script src='<?= ROOT ?>public/assets/plugins/dataTables/js/dataTables.responsive.min.js'></script>
<script src='<?= ROOT ?>public/assets/plugins/dataTables/js/dataTables.bootstrap5.min.js'></script>
<!-- customized app css -->
<script src="<?= ROOT ?>public/assets/js/app.js"></script>
<script src="<?= ROOT ?>public/assets/js/functions.js"></script>
<script src="<?= ROOT ?>public/assets/js/forms.js"></script>
<script src="<?= ROOT ?>public/assets/js/arithmetics.js"></script>
</body>

</html>