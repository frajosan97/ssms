<div class="container py-4">
    <div class="card rounded-0 border-0 mb-4">
        <iframe src="<?= APPINFO->sch_map ?>" class="rounded border-custom" frameborder="0" style="height: 450px"></iframe>
    </div>
    <form action="" method="post">
        <div class="card border-0 py-3 shadow">
            <div class="card-header bg-transparent border-0">
                <h4 class="slt">DIGITAL ENQUIRY ( Leave us a message )</h4>
            </div>
            <div class="card-body py-0">
                <div class="form-group mb-3">
                    <label for="">Your Name</label>
                    <input type="text" name="" placeholder="Your Name" class="form-control" required />
                </div>
                <div class="form-group mb-3">
                    <label for="">Phone Number</label>
                    <input type="tel" name="" placeholder="Phone Number" class="form-control" required />
                </div>
                <div class="form-group mb-3">
                    <label for="">Message</label>
                    <textarea name="" placeholder="Message" class="form-control" required></textarea>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <button type="submit" class="btn px-5"><i class="fas fa-envelope"></i> Submit</button>
            </div>
        </div>
    </form>
</div>