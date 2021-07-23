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
            <br>
            <form action="<?= base_url('psikolog/addjadwal'); ?>" method="post">
                <div class="form-group">
                    <label for="popsize">Population Size</label>
                    <input type="text" class="form-control" name="popsize" id="popsize" placeholder="ex : 10" aria-required="true">
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
                <button type="button" onclick="run()" class="btn btn-primary">Hitung Jadwal</button>
            </form>
        </div>
    </div>

    <div class="card mt-3" style="width: 600px;">
        <div class="card-body">
            <h5 class="card-title">Jadwal Terbaik</h5>
            <p id="jadwalTerbaik"></p>
        </div>
    </div>
    <script src="<?= base_url(); ?>assets/js/algoritma.js"></script>