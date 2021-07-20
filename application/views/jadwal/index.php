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
                    <input type="number" class="form-control" name="popsize" id="popsize" placeholder="ex : 10" value="10">
                    <small>Banyak populasi yang akan dibuat (popsize)</small>
                </div>
                <div class="form-group">
                    <label for="cr">Crossover Rate</label>
                    <input type="number" class="form-control" name="cr" id="cr" step="0.01" placeholder="ex : 0.5" value="0.5">
                    <small>Nilai untuk persilangan (crossover)</small>
                </div>
                <div class="form-group">
                    <label for="mr">Mutation Rate</label>
                    <input type="number" class="form-control" name="mr" id="mr" step="0.01" placeholder="ex : 0.5" value="0.5">
                    <small>Nilai untuk mutasi (mutation)</small>

                </div>
                <div class="form-group">
                    <label for="iterasi">Iterasi</label>
                    <input type="number" class="form-control" name="iterasi" id="iterasi" placeholder="ex : 1000" value="1000">
                    <small>Seberapa banyak melakukan perulangan sebelum mencapai nilai fitness yang diinginkan</small>

                </div>
                <div class="form-group">
                    <label for="thresholdSaget"> Nilai Fitness Minimal</label>
                    <input type="number" class="form-control" name="thresholdSaget" id="thresholdSaget" placeholder="ex : 0.07" step="0.01" value="0.07">
                    <small>Batas untuk menentukan minimal kualitas dari individu</small>
                </div>
                <div class="form-group">
                    <label for="maxData"> Nilai Maksimal Data</label>
                    <input type="number" class="form-control" name="maxData" id="maxData" placeholder="ex : 35" value="35">
                    <small>Nilai maksimal untuk menentukan seberapa banyak psikolog yang akan tampil di jadwal</small>
                </div>
                <input type="hidden" value="<?= $maxPs; ?>" id="maxPs">
                <button type="button" onclick="run()" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>

    <script src="<?= base_url(); ?>assets/js/algoritma.js"></script>