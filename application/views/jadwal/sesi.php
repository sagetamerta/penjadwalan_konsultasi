    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row" style="overflow-x:auto;">
        <div class="col-lg-4">
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?php $this->session->flashdata('message'); ?>

            <div class="row">
                <?php if ($user['role_id'] == 1) : ?>
                    <div class="col">
                        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSesiModal">Add New Sesi</a>
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
                        <th scope="col">Nama Sesi</th>
                        <?php if ($user['role_id'] == 1) : ?>
                            <th scope="col">Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = $this->uri->segment('3') + 1; ?>
                    <?php foreach ($sesi as $h) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $h->nama_sesi ?></td>
                            <?php if ($user['role_id'] == 1) : ?>
                                <td>
                                    <a href="javascript:;" data-id_sesi="<?php echo $h->id_sesi ?>" data-nama_sesi="<?= $h->nama_sesi; ?>" data-toggle="modal" data-target="#editSesiModal" class="badge badge-info">edit</a>
                                    <a href="<?= base_url('jadwal/deleteSesi/') . $h->id_sesi ?>" class="badge badge-danger">delete</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
        </div>
    </div>

    <!-- Modal Add Sesi -->
    <div class="modal fade" id="newSesiModal" tabindex="-1" aria-labelledby="newSesiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newSesiModalLabel">Add New Sesi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('jadwal/sesi'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nama_sesi" name="nama_sesi" placeholder="Nama Sesi">
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

    <!-- Modal Edit Sesi -->
    <div class="modal fade" id="editSesiModal" tabindex="-1" aria-labelledby="editSesiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSesiModalLabel">Edit Sesi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('jadwal/editsesi'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_sesi">Nama Sesi</label>
                            <input type="hidden" id="id_sesi" name="id_sesi">
                            <input type="text" class="form-control" id="nama_sesi" name="nama_sesi" placeholder="Nama Sesi">
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
            $('#editSesiModal').on('show.bs.modal', function(event) {
                var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
                var modal = $(this)

                // Isi nilai pada field
                modal.find('#id_sesi').attr("value", div.data('id_sesi'));
                modal.find('#nama_sesi').attr("value", div.data('nama_sesi'));
            });
        });
    </script>