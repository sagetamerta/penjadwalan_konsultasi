<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Psikolog_model');
        $this->load->model('Jadwal_model');
    }

    public function index()
    {
        $data['title'] = 'Daftar Jadwal';
        $data['user'] = $this->User_model->user();
        $data['jadwal'] = $this->pagination('jadwal', 7, 'join');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('jadwal/index', $data);
        $this->load->view('templates/footer');
    }

    public function addJadwal()
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
            $this->load->view('jadwal/add_jadwal', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Jadwal_model->addJadwal();
            redirect('jadwal');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New Jadwal has been added!</div>');
        }
    }

    public function deleteJadwal($kode_jadwal)
    {
        $this->Jadwal_model->deleteJadwal($kode_jadwal);
        redirect('jadwal');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Jadwal has been deleted!</div>');
    }

    public function hari()
    {
        $data['title'] = 'Daftar Hari';
        $data['user'] = $this->User_model->user();
        $data['hari'] = $this->pagination('hari', 7);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('jadwal/hari', $data);
        $this->load->view('templates/footer');
    }

    public function sesi()
    {
        $data['title'] = 'Daftar Sesi';
        $data['user'] = $this->User_model->user();
        $data['sesi'] = $this->pagination('sesi', 3);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('jadwal/sesi', $data);
        $this->load->view('templates/footer');
    }

    private function pagination($table, $per_page, $join = '')
    {
        $this->load->library('pagination');
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $config['base_url'] = base_url() . $table . '/index';
        $config['total_rows'] = $this->db->count_all($table);
        $config['per_page'] = $per_page;
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        if ($join != '') {
            return $this->Jadwal_model->dataJoin($table, $config['per_page'], $from);
        } else {
            return $this->Jadwal_model->data($table, $config['per_page'], $from);
        }
    }
}
