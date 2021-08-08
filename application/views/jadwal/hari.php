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
                        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newhariModal"><i class="fas fa-plus"></i> Add New hari</a>
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
                        <th scope="col">Nama hari</th>
                        <?php if ($user['role_id'] == 1) : ?>
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
                                    <a href="javascript:;" data-id_hari="<?php echo $h->id_hari ?>" data-nama_hari="<?= $h->nama_hari; ?>" data-toggle="modal" data-target="#edithariModal" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url('jadwal/deletehari/') . $h->id_hari ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
        </div>
    </div>

    <!-- Modal Add hari -->
    <div class="modal fade" id="newhariModal" tabindex="-1" aria-labelledby="newhariModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newhariModalLabel">Add New hari</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('jadwal/hari'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nama_hari" name="nama_hari" placeholder="Nama hari">
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

    <!-- Modal Edit hari -->
    <div class="modal fade" id="edithariModal" tabindex="-1" aria-labelledby="edithariModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edithariModalLabel">Edit hari</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('jadwal/edithari'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_hari">Nama hari</label>
                            <input type="hidden" id="id_hari" name="id_hari">
                            <input type="text" class="form-control" id="nama_hari" name="nama_hari" placeholder="Nama hari">
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
            $('#edithariModal').on('show.bs.modal', function(event) {
                var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
                var modal = $(this)

                // Isi nilai pada field
                modal.find('#id_hari').attr("value", div.data('id_hari'));
                modal.find('#nama_hari').attr("value", div.data('nama_hari'));
            });
        });
    </script>