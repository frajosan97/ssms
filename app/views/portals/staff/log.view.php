<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent text-uppercase">Activity Logs</div>
    <div class="card-body">
        <?php if (!(empty($data['logs']))) { ?>
            <div class="timeline">
                <?php include_once incFile("logs"); ?>
            </div>
        <?php } else { ?>
            <div class="border border-custom p-4 text-center rounded text-muted">No activity logs available for display</div>
        <?php } ?>
    </div>
</div>