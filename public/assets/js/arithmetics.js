// EXPENSES
var rowIndex = 0;

function addRow() {
    rowIndex++;
    var row = "<tr id='row_" + rowIndex + "'>";
    row += "<td><input type='text' name='exp_item[]' placeholder='Item' class='form-control form-control-sm'></td>";
    row += "<td><input type='number' name='exp_amnt[]' placeholder='Amount (Ksh)' class='form-control form-control-sm' oninput='postAmountExp()'></td>";
    row += "<td><span class='btn btn-sm w-100 text-nowrap btn-danger' onclick='removeRow(" + rowIndex + ")'><i class='fas fa-minus-circle'></i> Remove Row</span></td>";
    row += "</tr>";
    $(".expenseRows").append(row);
}

function removeRow(index) {
    $('#row_' + index).remove();
}

function postAmountExp() {
    $('input[name="fi_amnt"]').val(calcExpSum());
    $('input[name="exp_amnt[]"]').keyup(function () {
        $('input[name="fi_amnt"]').val(calcExpSum());
    });
}

function calcExpSum() {
    var tamount = 0;
    $('input[name="exp_amnt[]"]').each(function () {
        tamount += parseInt(($(this).val() ? $(this).val() : 0));
    });
    return tamount;
}

// FEES PAYMENT
function postAmountFees(maxValue, voteKey) {
    var target = $("#" + voteKey);
    if (target.val() > maxValue) {
        alert("Value for this vote head MUST not exceed " + maxValue);
        target.val("");
    }
    $('input[name="fi_amnt"]').val(calcPaySum());
    $('input[name="amount[]"]').keyup(function () {
        $('input[name="fi_amnt"]').val(calcPaySum());
    });
}

function calcPaySum() {
    var tamount = 0;
    $('input[name="amount[]"]').each(function () {
        tamount += parseInt(($(this).val() ? $(this).val() : 0));
    });
    return tamount;
}