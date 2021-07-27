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
            //ambil value dari inputan
            $jadwalTerbaik = $this->input->post('jadwalTerbaik'); //string
            $kode_jadwal = $this->input->post('kode_jadwal'); //string
            $banyak_per_sesi = $this->input->post('banyak_per_sesi'); //string

            //convert to array int
            $jadwal = array_map('intval', explode(',', $jadwalTerbaik));

            //ambil hari
            $hari = $this->db->select('id_hari')->get('hari')->result_array();
            $data_hari = [];
            foreach ($hari as $h) {
                $data_hari[] = $h['id_hari'];
            }
            $str_hari = implode(',', $data_hari);
            //new hari
            $new_hari = array_map('intval', explode(',', $str_hari));

            //ambil sesi
            $sesi = $this->db->select('id_sesi')->get('sesi')->result_array();
            $data_sesi = [];
            foreach ($sesi as $s) {
                $data_sesi[] = $s['id_sesi'];
            }
            $str_sesi = implode(',', $data_sesi);
            //new sesi
            $new_sesi = array_map('intval', explode(',', $str_sesi));

            echo count($jadwal) . "| JADWAL | " . json_encode($jadwal) . "<br>";
            echo count($hari) . "| HARI | " . json_encode($new_hari) . "<br>";
            echo count($sesi) . "| SESI | " . json_encode($new_sesi) . "<br>";


            //buat for untuk insert ke table jadwal dengan urutan
            // kode_jadwal | id_hari | id_sesi | id_psikolog

            // kode_jadwal | id_hari | id_sesi | id_psikolog
            // J01          | 1     | 1        | 6
            // J01          | 1     | 1        | 13
            // J01          | 1     | 1        | 15
            // J01          | 1     | 1        | 1
            // J01          | 1     | 1        | 7
            // J01          | 1     | 2        | 18
            // J01          | 1     | 2        | 20
            // J01          | 1     | 2        | 4
            // J01          | 1     | 2        | 29
            // J01          | 1     | 2        | 35


            die;
            //insert data ke table db sebanyak jadwal (id_psikolog)
            $data = array(
                'kode_jadwal' => $kode_jadwal,
                'id_hari' => $hari,
                'id_sesi' => $sesi,
                // 'id_psikolog' => $id_psikolog
            );
            $this->db->insert('psikolog', $data);
        }
    }

    public function hari()
    {
    }

    public function sesi()
    {
    }
}
