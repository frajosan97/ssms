<form action="" class="feesBalanceForm">
    <div class="card border-0 shadow-sm">
        <div class="card-header text-uppercase">send fees balances to parents</div>
        <div class="card-body">
            <ul class="list-group list-group-horizontal-md mb-2 pb-2 rounded-0 border-bottom">
                <li class="list-group-item p-0 rounded-0 border-0">
                    <select name="" class="btn btn-sm border border-custom text-start" id="selectfield">
                        <option value="" selected>-- Select field to add --</option>
                        <?php foreach (MESSVAR as $key => $value) { ?>
                            <option value="<?= $key ?>"><?= ucwords($value) ?></option>
                        <?php } ?>
                    </select>
                </li>
                <li class="list-group-item p-0 rounded-0 border-0"><button class="btn btn-sm btn-outline-custom mx-2"><i class="fas fa-paper-plane"></i> Send selected</button></li>
            </ul>

            <textarea name="message" rows="2" placeholder="Write message here..." class="form-control form-control-sm messageTextArea mb-2" id="info"></textarea>

            <div class="table-responsive">
                <table class="table table-bordered table-sm table-condensed text-uppercase text-nowrap table-striped table-hover">
                    <thead class="maincolor">
                        <tr>
                            <th><input type="checkbox" onclick="$('input[name*=\'studKey\']').prop('checked', this.checked);" /></th>
                            <th>Adm No</th>
                            <th>Class</th>
                            <th>Student Name</th>
                            <th>Phone</th>
                            <th>Total Billed</th>
                            <th>Total Paid</th>
                            <th>Total Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($data['studsData']) > 0) {
                            foreach ($data['studsData'] as $key => $value) {
                        ?>

                                <tr>
                                    <td><input type="checkbox" name="studKey[]" value="<?= $key ?>"></td>
                                    <td><?= $value['stud_adm'] ?></td>
                                    <td><?= $value['stud_class'] ?></td>
                                    <td><?= $value['stud_name'] ?></td>
                                    <td><?= $value['stud_phone'] ?></td>
                                    <td class="text-end"><?= number_format($value['stud_billed'], 2) ?></td>
                                    <td class="text-end"><?= number_format($value['stud_paid'], 2) ?></td>
                                    <td class="text-end"><?= number_format($value['stud_balance'], 2) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-custom w-100"><i class="fas fa-paper-plane"></i> Send Balance</button>
                                    </td>
                                </tr>

                            <?php
                            }
                        } else { ?>
                            <tr>
                                <td colspan="10" class="text-center">No student found with fees balance!</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<script>
    $("#selectfield").on("change", function() {
        var $select = $(this);
        $("#info").val(function(i, val) {
            return val += $select.val();
        })
    });
</script>