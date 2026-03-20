<form class="reportGetForm">
    <div class="card rounded-0 border-0 shadow-sm">
        <div class="card-body">
            <div class="row clearfix">
                <input type="hidden" name="reportType" id="reportType" value="<?= $fileView ?>">
                <div class="col-md-3 form-group">
                    <label for="">From:</label>
                    <input type="date" name="reportFrom" value="<?= date("Y-m-d") ?>" class="form-control form-control-sm rounded-0">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">To:</label>
                    <input type="date" name="reportTo" value="<?= date("Y-m-d") ?>" class="form-control form-control-sm rounded-0">
                </div>
                <div class="col-md-2 form-group">
                    <label for="" class="w-100"></label>
                    <button class="btn btn-sm btn-custom rounded-0 text-nowrap"><i class="fas fa-eye"></i> <?= ucwords(cleanHtml("view " . $fileView)) ?></button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="card rounded-0 border-0 shadow-sm">
    <div class="card-body financeReportData"></div>
</div>

<script>
    $(document).ready(function() {
        $('.reportGetForm').submit();
    });
</script>