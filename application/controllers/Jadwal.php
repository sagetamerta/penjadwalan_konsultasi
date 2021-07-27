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

        $this->form_validation->set_rules('popsize', 'Population size', 'required');
        $this->form_validation->set_rules('cr', 'Crossover rate', 'required|decimal');
        $this->form_validation->set_rules('mr', 'Mutation rate', 'required|decimal');
        $this->form_validation->set_rules('iterasi', 'Iterasi', 'required',);
        $this->form_validation->set_rules('thresholdSaget', 'Threshold', 'required|decimal');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('jadwal/index', $data);
            $this->load->view('templates/footer');
        } else {
            $jadwal = $this->input->post('jadwal'); //string
            // var_dump($jadwal);
            $arrjadwal = explode(",", $jadwal);
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
