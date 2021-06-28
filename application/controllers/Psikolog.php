<?php
defined('BASEPATH') or exit('No direct script access allowed');





class Psikolog extends CI_Controller
{
    private $data = [[]];
    private $childMutasi = [[]];
    private $childCrossover = [[]];
    private $halangan = [[]];
    private $gabungan = [[]];
    private $newFitness = [[]];
    private $fitness = [[]];
    // nilai fitness individu terbaik setiap iterasi
    private $individuTerbaik = 0;
    // nomor individu terbaik setiap iterasi
    // treshold yang akan diuji
    private $indexTerbaik = 0;
    private $maxData = 42;
    private $getChildCO, $ofCrossover, $ofMutasi, $iterasi = 1000, $count, $allPop = 0;
    private $cons1, $cons2, $cons3, $cons4, $cons5 = 0.0;
    private $psikolog = [];
    private $fullJadwal = [];
    private $jadwal1 = [];
    private $jadwal2 = [];
    private $jadwalTerbaik = '';
    private $fitnessSaget = 0.0;
    private $thresholdSaget = 0.0007;
    private $popsize = 10; //$this->input->post('popsize');
    // private $maxPs = $this->db->count_all('psikolog'); //$this->db->count('psikolog');
    private $cr = 0.5; //$this->input->post('cr');
    private $mr = 0.5; //$this->input->post('mr');

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
            $this->iterasi();
        }
    }

    public function inisialisasi()
    {
        $randArray = [];
        for ($i = 0; $i < $this->popsize; $i++) { //for loop populasi = 10 kebawah
            echo '<br>';
            for ($j = 0; $j < $this->maxData; $j++) { //for loop kromosom dari tiap populasi = 20 kesamping
                $value = rand(1, $this->maxData);
                $randArray[] = $value;
                echo $value . ' | ';
            }
        }
    }

    public function iterasi()
    {
        for ($i = 0; $i < $this->iterasi; $i++) {
            $this->hitungCrossover();
            // $this->hitungMutasi();
            // $this->hitungFitness();
            // $this->seleksiElitism();
            if ($this->fitnessSaget >= $this->thresholdSaget) {
                echo '<br>';
                echo 'Berhenti di iterasi ke : ' . ($i + 1);
                break;
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

    public function getConstraint5($array = [], $value = 0)
    {
        $cons5 = 0.0;
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] == $value) {
                $cons5 = $cons5 + 60;
            }
        }
    }

    public function hitungCrossover()
    {
        $temp2 = '';
        $getChildCO = -1;
        $this->ofCrossover = intval($this->cr * $this->popsize);
        return $this->ofCrossover;
        echo '<br>Banyak Offspring Crossover = ' . $this->ofCrossover;
        $childCrossover[[]] = [$this->ofCrossover][$this->maxData];

        while ($this->ofCrossover - $getChildCO != 1) {
            $data = [];
            $c[] = [2];
            $c[0] = rand(0, $this->popsize);
            $c[1] = rand(0, $this->popsize);

            $oneCut = rand(0, $this->maxPs);
            echo '<br>' . $c[0] . ' | ' . $c[1] . ' | ' . $oneCut;

            $c1 = ++$getChildCO;
            echo $c1 . ' || ' . $getChildCO;

            if ($this->ofCrossover - $getChildCO == 1) {
                for ($i = 0; $i < $this->maxData; $i++) {
                    $childCrossover[$c1][$i] = $data[$c[0]][$i];
                }
                for ($i = $oneCut, $j = 0; $j < $this->maxData - $oneCut; $j++, $i++) {
                    $childCrossover[$c1][$i] = $data[$c[1][$i]];
                }
                echo 'Child ' . $c1 . " = ";
                $temp2 = [$this->maxData];
                for ($i = 0; $i < $this->maxData; $i++) {
                    echo $childCrossover[$c1][$i] . " ";
                    $temp2[$i] = $childCrossover[$c1][$i];
                }
                echo $c1 + 1, $c[0] . 'x' . $c[1];
            } else {
                $c2 = ++$getChildCO;
                echo $c2 . '  ' . $getChildCO;
                for ($i = 0; $i < $this->maxData; $i++) {
                    $childCrossover[$c1][$i] = $data[$c[0]][$i];
                    $childCrossover[$c2][$i] = $data[$c[1]][$i];
                }
                for ($i = $oneCut, $j = 0; $j < $this->maxData - $oneCut; $j++, $i++) {
                    $childCrossover[$c2][$i] = $data[$c[0]][$i];
                    $childCrossover[$c2][$i] = $data[$c[1]][$i];
                }
                for ($i = $c1; $i <= $c2; $i++) {
                    echo '<br>Child ' . $i . ' = ';
                    $temp2[] = $this->maxData;
                    for ($j = 0; $j < $this->maxData; $j++) {
                        echo $childCrossover[$i][$j] . ' ';
                        $temp2[$j] = $childCrossover[$i][$j];
                    }
                }
            }
        }
    }

    public function hitungMutasi()
    {
        $ofMutasi = intval($this->mr * $this->popsize);
        return $ofMutasi;
        echo '<br>Banyak Offspring Mutasi = ' . $ofMutasi;

        $this->childMutasi =  [[$ofMutasi][$this->maxData]];
        for ($j = 0; $j < $ofMutasi; $j++) {
            $p = rand(0, $this->popsize);
            $r1 = rand(0, $this->maxData);
            $r2 = rand(0, $this->maxData);
            echo '<br>' . $p . ' | ' . $r1 . ' | ' . $r2 . ' | ';

            $this->reciprocalExchangeMutation($p, $r1, $r2, $j, $this->maxData);
            echo 'Child' . $j . ' = ';

            $arr[] = [$this->maxData];
            for ($i = 0; $i < $this->maxData; $i++) {
                echo $this->childMutasi[$j][$i] . ' ';
                $arr[$i] = $this->childMutasi[$j][$i];
            }
        }
    }

    public function reciprocalExchangeMutation($p, $r1, $r2, $j, $maxData)
    {
        $data = [[]];
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

    public function getFitness($array = [[]], $size = 0, $nama_psikolog = '')
    {
        try {
            for ($j = 0; $j < $size; $j++) {
                echo '<br>' . $nama_psikolog . ($j + 1) . ' ';
                $temp[] = [$this->maxData];
                $a = 0;
                $cons1 = 0.0;
                $cons2 = 0.0;
                $cons3 = 0.0;
                $cons4 = 0.0;
                $cons5 = 0.0;

                for ($k = 0; $k < $this->maxData; $k++) {
                    $temp[$k] = $array[$j][$k];
                    if ($k == 11) {
                        $a++;
                        echo 'Hari ke-' . $a . ' : ';
                    } elseif (($k + 1) % 12 == 0) {
                        $a++;
                        echo 'Hari ke-' . $a . ' : ';
                    }
                }
                $fitness[$this->count][0] = 1. / (1 + $cons1 + $cons2 + $cons3 + $cons4 + $cons5);
                $fitness[$this->count][0] = $cons1;
                $fitness[$this->count][0] = $cons2;
                $fitness[$this->count][0] = $cons3;
                $fitness[$this->count][0] = $cons4;
                $fitness[$this->count][0] = $cons5;
                echo '<br>';
                echo 'Cons1 : ' . $cons1;
                echo 'Cons1 : ' . $cons2;
                echo 'Cons1 : ' . $cons3;
                echo 'Cons1 : ' . $cons4;
                echo 'Cons1 : ' . $cons5;
                echo 'Nilai Fitness : ' . $fitness[$this->count][0];
                $this->count++;
            }
        } catch (Exception $ex) {
            echo 'Message: ' . $ex->getMessage();
        }
    }

    public function hitungFitness()
    {
        $data = array();
        try {
            $count = 0;
            return $count;
            $ofCrossover = $this->hitungCrossover();
            $ofMutasi = $this->hitungMutasi();
            $this->console_log($ofMutasi);
            $allPop = $this->popsize + $ofCrossover + $ofMutasi;
            $gabungan[] = [$allPop][$this->maxData];
            $this->console_log($allPop);

            for ($i = 0; $i < $allPop; $i++) {
                for ($j = 0; $j < $this->maxData; $j++) {
                    if ($i < $this->popsize) {
                        $gabungan[$i][$j] = $data[$i][$j];
                    } elseif ($i < $this->popsize + $ofCrossover) {
                        $gabungan[$i][$j] = $this->childCrossover[$i - $this->popsize][$j];
                    }
                }
            }
        } catch (Exception $ex) {
            echo 'Message: ' . $ex->getMessage();
        }
    }

    public function seleksiElitism()
    {
        $newFitness = [$this->allPop][2];
        echo '<br> Gabungan Parent dan Child' . ' : ';

        for ($i = 0; $i < $this->allPop; $i++) {
            for ($j = 0; $j < 2; $j++) {
                $newFitness[$i][$j] = $this->fitness[$i][$j];
            }
            echo $newFitness[$i][0] . ' || ' . $newFitness[$i][1];
            $temp2 = $newFitness[$i][1];
            $int_allpop = intval($temp2);
            echo '<br>' . $int_allpop;
        }
        for ($i = 0; $i < $this->allPop; $i++) {
            for ($j = 1; $j < $this->allPop; $j++) {
                if ($newFitness[$j - 1][0] <= $newFitness[$j][0]) {
                    $temp = $newFitness[$j - 1][0];
                    $temp2 = $newFitness[$j - 1][1];
                    $newFitness[$j - 1][0] = $newFitness[$j][0];
                    $newFitness[$j - 1][1] = $newFitness[$j][1];
                    $newFitness[$j][0] = $temp;
                    $newFitness[$j][1] = $temp2;
                }
            }
        }
        echo 'Order Fitness : ';
        for ($i = 0; $i < $this->allPop; $i++) {
            $temp = $newFitness[$i][1];
            $int_allpop = intval($temp);
            echo $newFitness[$i][0] . ' | ' . $newFitness[$i][1] . ' | ';
            for ($j = 0; $j < $this->maxData; $j++) {
                echo $this->gabungan[$int_allpop][$j] . ', ';
            }
            echo ' ';
        }
        $this->fitnessSaget = $newFitness[0][0];
        $indter = floatval($newFitness[0][1]);
        $this->individuTerbaik = intval($indter);
        $arr = intval([$this->maxData]);
        $temp2 = '';
        for ($i = 0; $i < 1; $i++) {
            $temp = floatval($newFitness[$i][1]);
            $int_allpop = intval($temp);
            for ($j = 0; $j < $this->maxData; $j++) {
                $arr[$j] = $this->gabungan[$int_allpop][$j];
            }
        }
        $this->jadwalTerbaik = $temp2;
    }

    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

    // INGET PERBAIKI VARIABELNYA BOSS
}
