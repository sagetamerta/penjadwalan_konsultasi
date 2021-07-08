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

            <?php if ($user['role_id'] == 1) : ?>
                <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newPsikologModal">Add New Psikolog</a>
            <?php endif; ?>


            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            </nav>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">No Telp</th>
                        <th scope="col">Alamat</th>
                        <?php if ($user['role_id'] == 1) : ?>
                            <th scope="col">Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = $this->uri->segment('3') + 1; ?>
                    <?php foreach ($psikolog as $p) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $p->nama_psikolog ?></td>
                            <td><?= $p->notelp_psikolog ?></td>
                            <td><?= $p->alamat_psikolog ?></td>
                            <?php if ($user['role_id'] == 1) : ?>
                                <td>
                                    <a href="<?= base_url('psikolog/edit/') . $p->id_psikolog ?>" class="badge badge-warning">edit</a>
                                    <a href="<?= base_url('psikolog/deletepsikolog/') . $p->id_psikolog ?>" class="badge badge-danger">delete</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newPsikologModal" tabindex="-1" aria-labelledby="newPsikologModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newPsikologModalLabel">Add New Psikolog</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('psikolog/addpsikolog'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nama_psikolog" name="nama_psikolog" placeholder="Nama Psikolog">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" id="notelp_psikolog" name="notelp_psikolog" placeholder="Nomor Telepon Psikolog">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="alamat_psikolog" name="alamat_psikolog" placeholder="Alamat Psikolog">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>