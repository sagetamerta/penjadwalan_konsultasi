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
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = $this->uri->segment('3') + 1; ?>
                    <?php foreach ($jadwal as $j) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $j->id_jadwal ?></td>
                            <?php if ($j->verifikasi == 1) : ?>
                                <td class=" btn btn-success">Terverifikasi</td>
                            <?php else : ?>
                                <td class=" btn btn-danger">Belum Terverifikasi</td>
                            <?php endif; ?>
                            <td>
                                <a href="javascript:;" data-id_jadwal="<?php echo $j->id_jadwal ?>" class="btn btn-info"><i class="fa fa-calendar-alt"></i></a>
                                <?php if ($user['role_id'] == 1) : ?>
                                    <a href="<?= base_url('jadwal/deleteJadwal/') . $j->id_jadwal ?>" class="btn btn-danger"><i class="fa fa-trash-alt"></i></a>
                                <?php else : ?>
                                    <a href="javascript:;" data-id_jadwal="<?php echo $j->id_jadwal ?>" data-verifikasi="<?php echo $j->verifikasi ?>" data-toggle="modal" data-target="#editjadwalModal" class="btn btn-success"><i class="fas fa-check"></i></a>
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
                    <h5 class="modal-title" id="editjadwalModalLabel">Verifikasi jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('jadwal/editjadwal'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="verifikasi">Status</label>
                            <input type="hidden" id="id_jadwal" name="id_jadwal">
                            <select class="form-control" name="verifikasi" id="verifikasi">
                                <option value="0">Belum Terverifikasi</option>
                                <option value="1">Terverifikasi</option>
                            </select>
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
                modal.find('#verifikasi').val(div.data('verifikasi'));
                // modal.find("#menu_id").val(div.data('menu_id'));
            });
        });
    </script>