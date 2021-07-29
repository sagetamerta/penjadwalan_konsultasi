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

            <div class="row">
                <?php if ($user['role_id'] == 1) : ?>
                    <div class="col">
                        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newPsikologModal">Add New Psikolog</a>
                    </div>
                <?php endif; ?>
                <div class="col">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php echo $this->pagination->create_links(); ?>
                        </ul>
                    </nav>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Hari</th>
                        <?php if ($user['role_id'] == 1) : ?>
                            <a href="javascript:;" data-id_psikolog="<?php echo $p->id_psikolog ?>" data-nama_psikolog="<?= $p->nama_psikolog; ?>" data-notelp_psikolog="<?= $p->notelp_psikolog; ?>" data-alamat_psikolog="<?= $p->alamat_psikolog; ?>" data-toggle="modal" data-target="#editPsikologModal" class="badge badge-info">edit</a>
                            <th scope="col">Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = $this->uri->segment('3') + 1; ?>
                    <?php foreach ($hari as $h) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $h->nama_hari ?></td>
                            <?php if ($user['role_id'] == 1) : ?>
                                <td>
                                    <a href="<?= base_url('jadwal/deleteHari/') . $h->id_hari ?>" class="badge badge-danger">delete</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>

        </div>
    </div>