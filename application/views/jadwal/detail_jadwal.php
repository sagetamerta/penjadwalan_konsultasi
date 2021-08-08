    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row" style="overflow-x:auto;">
        <div class="col-md-8">
            <?php if ($user['role_id'] == 1) : ?>
                <a class="btn btn-primary" href="<?= base_url('jadwal/addjadwal'); ?>"><i class="fas fa-plus"></i> Tambah Jadwal</a>
            <?php endif; ?>
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?php $this->session->flashdata('message'); ?>


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Hari</th>
                        <th scope="col">Sesi</th>
                        <th scope="col">Psikolog</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($detail_jadwal as $d) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $d->nama_hari ?></td>
                            <td><?= $d->nama_sesi ?></td>
                            <td><?= $d->nama_psikolog ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>