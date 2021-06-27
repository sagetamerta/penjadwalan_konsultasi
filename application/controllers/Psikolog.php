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
$maxData = 20;
$maxKapal = 32;
$getChildCO;
$ofCrossover;
$ofMutasi;
$cHalangan;
$popsize = 10;
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
            $fitnessSaget = 0.0;
            $thresholdSaget = 0.0;
            $popsize = 10; //$this->input->post('popsize');
            $maxData = 42;
            $maxPs = 28; //$this->db->count('psikolog');
            $cr = 0.5; //$this->input->post('cr');
            $mr = 0.5; //$this->input->post('mr');

            $this->inisialisasi($popsize, $maxData);
            $iterasi = 1;
            for ($i = 0; $i < $iterasi; $i++) {
                $this->hitungCrossover($cr, $popsize, $maxData, $maxPs);
                $this->hitungMutasi($mr, $popsize, $maxData, $maxPs);
                $this->hitungFitness();
                $this->seleksiElitism();
                if ($fitnessSaget >= $thresholdSaget) {
                    echo '<br>';
                    echo 'Berhenti di iterasi ke : ' . ($i + 1);
                    break;
                }
            }
        }
    }

    public function inisialisasi($popsize, $maxData)
    {
        $randArray = [];
        for ($i = 0; $i < $popsize; $i++) { //for loop populasi = 10 kebawah
            echo '<br>';
            for ($j = 0; $j < $maxData; $j++) { //for loop kromosom dari tiap populasi = 20 kesamping
                $value = rand(1, $maxData);
                $randArray[] = $value;
                echo $value . ' | ';
            }
        }
    }

    public function getConstraint1($array = [], $array2 = [])
    {
        $cons1 = 0.0;
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $cons1 = $cons1 + 10;
                }
            }
        }
    }

    public function ge2($array = [], $array2 = [])
    {
        $cons2 = 0.0;
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $cons2 = $cons2 + 20;
                }
            }
        }
    }

    public function getConstraint3($array = [], $array2 = [])
    {
        $cons3 = 0.0;
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $cons3 = $cons3 + 50;
                }
            }
        }
    }

    public function getConstraint4($array = [])
    {
        $cons4 = 0.0;
        $s2remove = [count($array)];
        for ($i = 0; $i < count($array); $i++) {
            for ($j = $i + 1; $j < count($array); $j++) {
                if ($i != $j) {
                    if ($array[$i] == $array[$j]) {
                        if ($array[$j] == $s2remove[$j]) {
                            continue;
                        } else {
                            $cons4 = $cons4 + 55;
                            $s2remove[$j] = $array[$j];
                        }
                    }
                }
            }
        }
    }

    public function getConstraint5($array = [], $value = [])
    {
        $cons5 = 0.0;
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] == $value) {
                $cons5 = $cons5 + 60;
            }
        }
    }

    public function hitungCrossover($cr, $popsize, $maxData)
    {
        $temp2 = '';
        $getChildCO = -1;
        $ofCrossover = intval($cr * $popsize);
        echo '<br>Banyak Offspring Crossover = ' . $ofCrossover;
        $childCrossover[][] = [$ofCrossover][$maxData];

        while ($ofCrossover - $getChildCO != 1) {
            $c[] = [2];
            $data = array();

            $c[0] = rand(0, $popsize);
            $c[1] = rand(0, $popsize);

            $oneCut = rand(0, $maxData);
            echo '<br>' . $c[0] . ' | ' . $c[1] . ' | ' . $oneCut;

            $c1 = ++$getChildCO;
            echo $c1 . ' c1 child' . $getChildCO;

            if ($ofCrossover - $getChildCO == 1) {
                for ($i = 0; $i < $maxData; $i++) {
                    $childCrossover[$c1][$i] = $data[$c[0]][$i];
                }
                for ($i = $oneCut, $j = 0; $j < $maxData - $oneCut; $j++, $i++) {
                    $childCrossover[$c1][$i] = $data[$c[1][$i]];
                }
                echo 'Child ' . $c1 . " = ";
                $temp2 = [$maxData];
                for ($i = 0; $i < $maxData; $i++) {
                    echo $childCrossover[$c1][$i] . " ";
                    $temp2[$i] = $childCrossover[$c1][$i];
                }
            } else {
                $c2 = ++$getChildCO;
                echo $c2 . '  ' . $getChildCO;

                // error 1
                for ($i = 0; $i < $maxData; $i++) {
                    $childCrossover[$c1][$i] = $data[$c[0]][$i];
                    $childCrossover[$c2][$i] = $data[$c[1]][$i];
                }
                for ($i = $oneCut, $j = 0; $j < $maxData - $oneCut; $j++, $i++) {
                    $childCrossover[$c2][$i] = $data[$c[0]][$i];
                    $childCrossover[$c2][$i] = $data[$c[1]][$i];
                }
                // error 2
                for ($i = $c1; $i <= $c2; $i++) {
                    // echo '<br>Child ' . $i . '=';
                    $temp2 = array($maxData);
                    for ($j = 0; $j < $maxData; $j++) {
                        // echo $childCrossover[$i][$j] . '';
                        $temp2[$j] = $childCrossover[$i][$j];
                    }
                }
            }
        }
    }

    public function hitungMutasi($mr, $popsize, $maxData)
    {
        $temp = '';
        $ofMutasi = intval($mr * $popsize);
        echo '<br>Banyak Offspring Mutasi = ' . $ofMutasi;

        $childMutasi =  [[$ofMutasi][$maxData]];
        for ($j = 0; $j < $ofMutasi; $j++) {
            $p = rand(0, $popsize);
            $r1 = rand(0, $maxData);
            $r2 = rand(0, $maxData);
            // $c = array(2);
            // $data = array();
            // $c[0] = rand($popsize, $maxData);
            // $c[1] = rand($popsize, $maxData);
        }
    }

    public function reciprocalExchangeMutation($p, $r1, $r2, $j, $maxData)
    {
        $data = array();
        for ($i = 0; $i < $maxData; $i++) {
            $childMutasi[$j][$i] = $data[$p][$i];
            if ($i == $r1) {
                $childMutasi[$j][$i] = $data[$p][$r2];
            }
            if ($i == $r2) {
                $childMutasi[$j][$i] = $data[$p][$r1];
            }
        }
    }

    public function getFitness()
    {
    }

    public function hitungFitness()
    {
    }

    public function seleksiElitism()
    {
    }
}
