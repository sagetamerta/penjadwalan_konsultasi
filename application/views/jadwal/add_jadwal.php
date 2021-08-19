    <div class="row">
        <div class="col-lg-6">
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
            <input type="hidden" value="<?= $maxPs; ?>" id="maxPs">
            <button type="button" onclick="run()" class="btn btn-primary mb-5">Hitung Jadwal</button>
        </div>
        <div class="col-lg-6">
            <h1 class="h3 mb-4 text-gray-800">Tambah Jadwal</h1>
            <?php $this->session->flashdata('message'); ?>
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('jadwal/addjadwal'); ?>" method="post">
                <div class="form-group">
                    <label for="jadwalTerbaik">Jadwal Terbaik</label>
                    <textarea class="form-control" name="jadwalTerbaik" id="jadwalTerbaik" rows="3" readonly="readonly"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary">Tambah Jadwal</button>
                </div>
            </form>
        </div>
    </div>
    <script src="<?= base_url(); ?>assets/js/algoritma.js"></script>