    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?php $this->session->flashdata('message'); ?>
            <div class="form-group">
                <label for="popsize">Population Size</label>
                <input type="text" class="form-control" name="popsize" id="popsize" placeholder="ex : 10" required>
                <small>Banyak populasi yang akan dibuat (popsize)</small>
            </div>
            <div class="form-group">
                <label for="cr">Crossover Rate</label>
                <input type="text" class="form-control" name="cr" id="cr" placeholder="ex : 0.5" required>
                <small>Nilai untuk persilangan (crossover)</small>
            </div>
            <div class="form-group">
                <label for="mr">Mutation Rate</label>
                <input type="text" class="form-control" name="mr" id="mr" placeholder="ex : 0.5" required>
                <small>Nilai untuk mutasi (mutation)</small>

            </div>
            <div class="form-group">
                <label for="iterasi">Iterasi</label>
                <input type="text" class="form-control" name="iterasi" id="iterasi" placeholder="ex : 1000" required>
                <small>Seberapa banyak melakukan perulangan sebelum mencapai nilai fitness yang diinginkan</small>

            </div>
            <div class="form-group">
                <label for="thresholdSaget"> Nilai Fitness Minimal</label>
                <input type="text" class="form-control" name="thresholdSaget" id="thresholdSaget" placeholder="ex : 0.07" required>
                <small>Batas untuk menentukan minimal kualitas dari individu</small>
            </div>
            <div class="form-group">
                <label for="maxData"> Nilai Maksimal Data</label>
                <input type="text" class="form-control" name="maxData" id="maxData" placeholder="ex : 35" required>
                <small>Nilai maksimal untuk menentukan seberapa banyak psikolog yang akan tampil di jadwal</small>
            </div>
            <input type="hidden" value="<?= $maxPs; ?>" id="maxPs">
            <button type="button" onclick="run()" class="btn btn-primary mb-2">Hitung Jadwal</button>

            <form action="<?= base_url('jadwal/add'); ?>" method="post">
                <div class="form-group">
                    <label for="jadwalTerbaik">Jadwal Terbaik</label>
                    <textarea class="form-control" name="jadwalTerbaik" id="jadwalTerbaik" rows="3" readonly></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary">Tambah Jadwal</button>
                </div>
            </form>
        </div>
    </div>
    <script src="<?= base_url(); ?>assets/js/algoritma.js"></script>