<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends CI_Controller
{
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

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('jadwal/add', $data);
            $this->load->view('templates/footer');
        } else {
            $jadwalTerbaik = $this->input->post('jadwalTerbaik'); //string
            // var_dump($jadwal);
            $arrjadwal = explode(",", $jadwalTerbaik);
            echo json_encode($arrjadwal);

            $arrtest = [1, 4, 5, 2, 1];
            echo json_encode($arrtest);
            die;
        }
    }

    public function hari()
    {
    }

    public function sesi()
    {
    }
}
