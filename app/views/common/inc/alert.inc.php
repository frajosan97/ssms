<?php if (BILLCHECK['type'] == "free") { ?>
    <section class="bg-warning">
        <div class="container py-2">
            <?= BILLCHECK['message'] ?>
        </div>
    </section>
<?php } ?>