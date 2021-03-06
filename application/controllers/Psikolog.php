<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Psikolog extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Psikolog_model');
    }

    public function index()
    {
        $data['title'] = 'Kelola Data Psikolog';
        $data['user'] = $this->User_model->user();

        $data['psikolog'] = $this->pagination();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('psikolog/index', $data);
        $this->load->view('templates/footer');
    }


    public function addPsikolog()
    {
        $this->Psikolog_model->addPsikolog();
        redirect('psikolog');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Psikolog baru telah ditambahkan!</div>');
    }

    public function editPsikolog()
    {
        $this->Psikolog_model->editPsikolog();
        redirect('psikolog');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Psikolog telah diperbarui!</div>');
    }

    public function deletePsikolog($id_psikolog)
    {
        $this->Psikolog_model->deletePsikolog($id_psikolog);
        redirect('psikolog');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Psikolog telah dihapus!</div>');
    }


    private function pagination()
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
        $config['base_url'] = base_url() . 'psikolog/index';
        $config['total_rows'] = $this->db->count_all('psikolog');
        $config['per_page'] = 5;
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        return $this->Psikolog_model->data($config['per_page'], $from);
    }
}
