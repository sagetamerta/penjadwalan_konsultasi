<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Psikolog extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Data Psikolog';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['psikolog'] = $this->db->get('psikolog')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('psikolog/index', $data);
        $this->load->view('templates/footer');
    }

    public function addPsikolog()
    {
        $nama_psikolog = htmlspecialchars($this->input->post('nama_psikolog'));
        $notelp_psikolog = htmlspecialchars($this->input->post('notelp_psikolog'));
        $alamat_psikolog = htmlspecialchars($this->input->post('alamat_psikolog'));

        $data = array(
            'nama_psikolog' => $nama_psikolog,
            'notelp_psikolog' => $notelp_psikolog,
            'alamat_psikolog' => $alamat_psikolog
        );

        $this->db->insert('psikolog', $data);

        redirect('psikolog');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        New Psikolog has been added!</div>');
    }

    public function deletePsikolog($id_psikolog)
    {
        $this->db->where('id_psikolog', $id_psikolog);
        $this->db->delete('psikolog');

        redirect('psikolog');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Psikolog has been deleted!</div>');
    }

    public function addJadwal()
    {
        // ambil jumlah psikolog dari database yang menjadi jumlah populasi
        $data['jumlah_psikolog'] = $this->db->count_all('psikolog');
        // ambil input crossover rate
        // ambil input mutation rate
        // ambil input jumlah iterasi

        // tampilkan view form untuk buat jadwal

        $data['title'] = 'Buat Jadwal Konsultasi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('jadwal/index', $data);
        $this->load->view('templates/footer');
    }

    private function inisialisasi()
    {
        $maxData = 21;
        $temp = '';
        $random = rand();
        $popsize = 5; //jumlah popoulasi diambil dari jumlah psikolog dalam db
        $cr = 0.1; //crossover rate diambil dari inputan form
        $mr = 0.5; //mutation rate diambil dari inputan form
        $iterasi = 50; //jumlah iterasi diambil dari inputan form
        $data = [$popsize][$maxData];

        for ($i = 0; $i < $popsize; $i++) {
            $maxData = [];
            for ($j = 0; $j < $maxData; $j++) {
            }
        }
    }
}
