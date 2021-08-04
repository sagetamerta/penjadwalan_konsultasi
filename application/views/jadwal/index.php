    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-md-8">
            <a class="btn btn-primary" href="<?= base_url('jadwal/addjadwal'); ?>"><i class="fas fa-plus"></i> Tambah Jadwal</a>
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?php $this->session->flashdata('message'); ?>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            </nav>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID Jadwal</th>
                        <th scope="col">Keterangan</th>
                        <?php if ($user['role_id'] == 1) : ?>
                            <th scope="col">Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = $this->uri->segment('3') + 1; ?>
                    <?php foreach ($jadwal as $j) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $j->id_jadwal ?></td>
                            <?php if ($j->verifikasi == 1) : ?>
                                <td>Terverifikasi</td>
                            <?php else : ?>
                                <td>Belum Terverifikasi</td>
                            <?php endif; ?>
                            <td>
                                <a href="javascript:;" data-id_jadwal="<?php echo $j->id_jadwal ?>" class="badge badge-warning">jadwal</a>
                                <?php if ($user['role_id'] == 1) : ?>
                                    <a href="<?= base_url('jadwal/deleteJadwal/') . $j->id_jadwal ?>" class="badge badge-danger">delete</a>
                                <?php else : ?>
                                    <a href="javascript:;" data-id_jadwal="<?php echo $j->id_jadwal ?>" data-verifikasi="<?php echo $j->verifikasi ?>" data-toggle="modal" data-target="#editjadwalModal" class="badge badge-info">verify</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Edit jadwal -->
    <div class="modal fade" id="editjadwalModal" tabindex="-1" aria-labelledby="editjadwalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editjadwalModalLabel">Edit jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('jadwal/editjadwal'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="verifikasi">Verifikasi</label>
                            <input type="hidden" id="id_jadwal" name="id_jadwal">
                            <input type="text" class="form-control" id="verifikasi" name="verifikasi" placeholder="Nama jadwal">
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

    <script>
        $(document).ready(function() {
            // Untuk sunting
            $('#editjadwalModal').on('show.bs.modal', function(event) {
                var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
                var modal = $(this)

                // Isi nilai pada field
                modal.find('#id_jadwal').attr("value", div.data('id_jadwal'));
                modal.find('#verifikasi').attr("value", div.data('verifikasi'));
            });
        });
    </script>