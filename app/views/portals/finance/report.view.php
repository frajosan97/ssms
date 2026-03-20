<?php
$revenue = [
    "fees colection"
];
?>


<table class="table">
    <tr>
        <th>Revenue</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($revenue as $key => $value) { ?>
        <tr>
            <td><?= ucwords($value) ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    <?php } ?>








    <tr>
        <th>Expenses</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</table>