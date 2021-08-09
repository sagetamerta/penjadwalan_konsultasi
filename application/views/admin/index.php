<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css">

<div class="grey-bg container-fluid">
    <section id="stats-subtitle">
        <div class="row">
            <div class="col-12 mt-3 mb-1">
                <h1 class="font-weight-bold">Dashboard</h1>
                <p>Aplikasi Penjadwalan Konsultasi Psikologi Online di Ikatan Psikolog Klinis Bali</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-md-12">
                <div class="card overflow-hidden">
                    <div class="card-content">
                        <div class="card-body cleartfix">
                            <div class="media align-items-stretch">
                                <div class="align-self-center">
                                    <i class="icon-calendar primary font-large-2 mr-2"></i>
                                </div>
                                <div class="media-body">
                                    <h4>Jumlah Jadwal</h4>
                                    <span>Terverifikasi</span>
                                </div>
                                <div class="align-self-center">
                                    <h4><?= $this->db->get_where('jadwal', ['verifikasi' => '1'])->num_rows(); ?> dari <?= $this->db->get('jadwal')->num_rows(); ?> Jadwal</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body cleartfix">
                            <div class="media align-items-stretch">
                                <div class="align-self-center">
                                    <i class="icon-users warning font-large-2 mr-2"></i>
                                </div>
                                <div class="media-body">
                                    <h4>Jumlah Psikolog</h4>
                                    <span>Terdaftar</span>
                                </div>
                                <div class="align-self-center">
                                    <h4><?= $jumlah_psikolog; ?> Orang</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>