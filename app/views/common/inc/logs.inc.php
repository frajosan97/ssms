<?php
if (VIEWFOLDER == "admin") {
    $displayLogs = $data['logs'];
} else {
    foreach ($data['logs'] as $key => $value) {
        if (($value[1] == APPINFO->sch_token) && ($value[2] == VIEWFOLDER)) {
            $displayLogs[] = $value;
        }
    }
}

if (isset($displayLogs)) {
    foreach ($displayLogs as $key => $value) {
?>
        <div class="tl-item <?php if ($key === array_key_first($displayLogs)) : ?>active<?php endif; ?>">
            <div class="tl-dot"></div>
            <div class="tl-content small">
                <div class=""><a href="<?= ROOT . VIEWFOLDER . "/" . $value[2] . "/" . "profile/" . $value[3] ?>" class="text-primary">@<?= $value[4] ?></a> <?= $value[5] ?></div>
                <i class="text-muted"><i class="fas fa-clock"></i> <?= timeDifference($value[0]) ?></i>
            </div>
        </div>
<?php
    }
} else {
}
?>