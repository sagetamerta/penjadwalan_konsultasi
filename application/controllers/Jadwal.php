<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends CI_Controller
{
    private $data = [];
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Psikolog_model');
    }

    public function index()
    {
    }

    public function add()
    {
        $data['title'] = 'Buat Jadwal Konsultasi';
        $data['user'] = $this->User_model->user();
        $data['maxPs'] = $this->Psikolog_model->jumlah_psikolog();

        $this->form_validation->set_rules('jadwalTerbaik', 'Jadwal Terbaik', 'required');
        $this->form_validation->set_rules('kode_jadwal', 'Kode Jadwal', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('jadwal/add', $data);
            $this->load->view('templates/footer');
        } else {

            $kode_jadwal = $this->input->post('kode_jadwal');
            $banyak_per_sesi = $this->input->post('banyak_per_sesi'); //harusnya nilainya 3 ya buat testing
            $jadwalterbaik = $this->input->post('jadwalTerbaik'); //string => ubah jadi array int

            $newjadwal = array_map('intval', explode(',', $jadwalterbaik)); //array int
            $id_hari = array_chunk($newjadwal, $banyak_per_sesi); //array dibagi seberapa banyak psikolog perhari yg akan dibagi menjadi 3 sesi

            for ($i = 0; $i < count($id_hari); $i++) {
                $id_sesi = array_chunk($id_hari[$i], 2);
                // echo "Hari ke-" . ($i + 1) . "  " . json_encode($id_hari[$i]) . "<br>";
                for ($j = 0; $j < count($id_sesi); $j++) {
                    $id_psikolog = array_chunk($id_sesi[$j], 1);
                    // echo "Sesi ke-" . ($j + 1) . " " . json_encode($id_sesi[$j]) . "<br>";
                    for ($k = 0; $k < count($id_psikolog); $k++) {
                        // ! DISINILAH KAMU INSERT TIAP ID PSIKOLOG
                        echo "Id psikolog-" . ($k + 1) . " " . json_encode($id_psikolog[$k]) . "<br>";

                        $data = array(
                            'kode_jadwal' => $kode_jadwal,
                            'id_hari' => ($i + 1),
                            'id_sesi' => ($j + 1),
                            'id_psikolog' => implode($id_psikolog[$k])
                        );
                        $this->db->insert('jadwal', $data);
                    }
                }
            }
            redirect('jadwal/add');
        }
    }

    public function hari()
    {
    }

    public function sesi()
    {
    }
}
