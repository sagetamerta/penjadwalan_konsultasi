    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row" style="overflow-x:auto;">
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
                                <a href="javascript:;" data-id_psikolog="<?php echo $p->id_psikolog ?>" data-nama_psikolog="<?= $p->nama_psikolog; ?>" data-notelp_psikolog="<?= $p->notelp_psikolog; ?>" data-alamat_psikolog="<?= $p->alamat_psikolog; ?>" data-toggle="modal" data-target="#editPsikologModal" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('psikolog/deletePsikolog/') . $p->id_psikolog ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
    </div>

    <!-- Modal Add Psikolog -->
    <div class="modal fade" id="newPsikologModal" tabindex="-1" aria-labelledby="newPsikologModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newPsikologModalLabel">Add New Psikolog</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addPsikologForm" action="<?= base_url('psikolog/addpsikolog'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_psikolog">Nama Psikolog</label>
                            <input type="text" class="form-control" id="nama_psikolog" name="nama_psikolog" placeholder="Nama Psikolog" required>
                            <?=
                            form_error('nama_psikolog', '<small class="text-danger pl-3">', '</small>');
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="notelp_psikolog">Nomor Telepon Psikolog</label>
                            <input type="number" class="form-control" id="notelp_psikolog" name="notelp_psikolog" placeholder="Nomor Telepon Psikolog" required>
                            <?=
                            form_error('notelp_psikolog', '<small class="text-danger pl-3">', '</small>');
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="alamat_psikolog">Alamat Psikolog</label>
                            <input type="text" class="form-control" id="alamat_psikolog" name="alamat_psikolog" placeholder="Alamat Psikolog" required>
                            <?=
                            form_error('alamat_psikolog', '<small class="text-danger pl-3">', '</small>');
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Psikolog -->
    <div class="modal fade" id="editPsikologModal" tabindex="-1" aria-labelledby="editPsikologModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPsikologModalLabel">Edit Psikolog</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('psikolog/editpsikolog'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_psikolog">Nama Psikolog</label>
                            <input type="hidden" id="id_psikolog" name="id_psikolog">
                            <input type="text" class="form-control" id="nama_psikolog" name="nama_psikolog" placeholder="Nama Psikolog" required>
                        </div>
                        <div class="form-group">
                            <label for="notelp_psikolog">Nomor Telepon Psikolog</label>
                            <input type="number" class="form-control" id="notelp_psikolog" name="notelp_psikolog" placeholder="Nomor Telepon Psikolog" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat_psikolog">Alamat Psikolog</label>
                            <input type="text" class="form-control" id="alamat_psikolog" name="alamat_psikolog" placeholder="Alamat Psikolog" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Untuk sunting
            $('#editPsikologModal').on('show.bs.modal', function(event) {
                var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
                var modal = $(this)

                // Isi nilai pada field
                modal.find('#id_psikolog').attr("value", div.data('id_psikolog'));
                modal.find('#nama_psikolog').attr("value", div.data('nama_psikolog'));
                modal.find('#notelp_psikolog').attr("value", div.data('notelp_psikolog'));
                modal.find('#alamat_psikolog').attr("value", div.data('alamat_psikolog'));
            });
        });
    </script>