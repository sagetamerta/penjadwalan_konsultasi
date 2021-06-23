<?php
defined('BASEPATH') or exit('No direct script access allowed');

$data;
$childMutasi;
$childCrossover;
$halangan;
$gabungan;
$newFitness;
$fitness;
$fitnessJipi;
// nilai fitness individu terbaik setiap iterasi
$individuTerbaik;
// nomor individu terbaik setiap iterasi
$thresholdJipi;
// treshold yang akan diuji
$indexTerbaik;
$maxData = 160;
$maxKapal = 32;
$getChildCO;
$ofCrossover;
$ofMutasi;
$cHalangan;
$popsize;
$iterasi;
$count;
$allPop;
$cons1;
$cons2;
$cons3;
$cons4;
$cons5;
// int[] array;
// int[] array2;
$kapal;
$fullJadwal;
$jadwal1;
$jadwal2;
$cr;
$mr;
$jadwalTerbaik;

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

        if ($this->form_validation->run() == true) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('jadwal/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->inisialisasi();
        }
    }

    private function inisialisasi()
    {
        $temp = '';
        $random = rand(1, 10);
        $rand = (object) $random;
        print_r($random);

        // for ($i = 0; $i < 32; $i++) {
        //     $arr = array_fill(0, 160, 0);
        //     for ($j = 0; $j < 160; $j++) {
        //     }
        // }
        $this->popsize = intval("10");
        $this->data = array_fill(0, 32, array_fill(0, 160, 0));
        for ($i = 0; $i < 32; $i++) {
            $arr = array_fill(0, 160, 0);
            for ($j = 0; $j < 160; $j++) {
                $n = $rand(32) + 1;
                $this->data[$i][$j] = $n;
                $arr[$j] = $this->data[$i][$j];
            }
            $temp = $arr;
            print_r($temp);
        }
    }
}
