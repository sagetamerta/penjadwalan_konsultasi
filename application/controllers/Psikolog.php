<?php
defined('BASEPATH') or exit('No direct script access allowed');





class Psikolog extends CI_Controller
{
    private $data = [[]];
    private $childMutasi = [[]];
    private $childCrossover = [[]];
    private $gabungan = [[]];
    private $newFitness = [[]];
    private $fitness = [[]];
    // nilai fitness individu terbaik setiap iterasi
    private $individuTerbaik = 0;
    // nomor individu terbaik setiap iterasi
    // treshold yang akan diuji
    private $maxData = 42;
    private $getChildCO, $ofCrossover, $ofMutasi, $count, $allPop = 0;
    private $iterasi = 10;
    private $cons1 = 0.0, $cons2 = 0.0, $cons3 = 0.0, $cons4 = 0.0, $cons5 = 0.0;
    private $psikolog = [];
    private $fullJadwal = [];
    private $jadwal1 = [];
    private $jadwal2 = [];
    private $jadwalTerbaik = '';
    private $fitnessSaget = 0.0;
    private $thresholdSaget = 0.0007;
    private $popsize = 10; //$this->input->post('popsize');
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

    public function phpinfo()
    {
        echo phpinfo();
        exit;
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
            $maxPs = $this->db->count_all('psikolog');
            $this->inisialisasi($maxPs);
            $this->iterasi($maxPs);
        }
    }

    public function inisialisasi($maxPs)
    {
        // $data[][] = [$this->popsize][$this->maxData];
        echo 'Populasi Awal : <br>';
        for ($i = 0; $i < $this->popsize; $i++) { //for loop populasi = 10 kebawah
            $arr = [$this->maxData];
            for ($j = 0; $j < $this->maxData; $j++) { //for loop kromosom dari tiap populasi = 20 kesamping
                $n = intval(rand(1, $maxPs));
                $data[$i][$j] = $n;
                $arr[$j] = $data[$i][$j];
            }
            // echo '<pre>';
            // echo var_dump($arr);
            // echo '</pre>';

            // implode("|", $arr);
            echo json_encode($arr);
        }
    }

    public function iterasi($maxPs)
    {
        for ($i = 0; $i < $this->iterasi; $i++) {
            $this->hitungCrossover($maxPs);
            $this->hitungMutasi();
            $this->hitungFitness();
            $this->seleksiElitism();
            if ($this->fitnessSaget >= $this->thresholdSaget) {
                echo '<br>';
                echo 'Berhenti di iterasi ke : ' . ($i + 1);
                break;
            }
        }
    }

    public function getConstraint1($array = [], $array2 = [])
    {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $cons1 = $this->cons1 + 10;
                    return $cons1;
                }
            }
        }
    }

    public function ge2($array = [], $array2 = [])
    {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $cons2 = $this->cons2 + 20;
                    return  $cons2;
                }
            }
        }
    }

    public function getConstraint3($array = [], $array2 = [])
    {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $cons3 = $this->cons3 + 50;
                    return $cons3;
                }
            }
        }
    }

    public function getConstraint4($array = [])
    {
        $s2remove = [count($array)];
        for ($i = 0; $i < count($array); $i++) {
            for ($j = $i + 1; $j < count($array); $j++) {
                if ($i != $j) {
                    if ($array[$i] == $array[$j]) {
                        if ($array[$j] == $s2remove[$j]) {
                            continue;
                        } else {
                            $cons4 = $this->cons4 + 55;
                            return $cons4;
                            $s2remove[$j] = $array[$j];
                        }
                    }
                }
            }
        }
    }

    public function getConstraint5($array = [], $value = 0)
    {
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] == $value) {
                $cons5 = $this->cons5 + 60;
                return  $cons5;
            }
        }
    }

    public function hitungCrossover($maxPs)
    {
        $temp = '';
        $this->getChildCO = -1;
        $this->ofCrossover = intval(round($this->cr * $this->popsize));
        echo '<br>Banyak Offspring Crossover = ' . $this->ofCrossover; //BISA
        $childCrossover = [$this->ofCrossover[[$this->maxData]]]; //diganti
        // $this->console_log($childCrossover);

        while ($this->ofCrossover - $this->getChildCO != 1) {
            $c = [2];
            $c[0] = intval(rand(0, $this->popsize));
            $c[1] = intval(rand(0, $this->popsize));

            $oneCut = intval(rand(0, $maxPs));
            echo '<br>' . $c[0] . ' | ' . $c[1] . ' | ' . $oneCut; //BISA

            $c1 = intval(++$this->getChildCO);
            echo $c1 . ' || ' . $this->getChildCO; //BISA

            if ($this->ofCrossover - $this->getChildCO == 1) {
                for ($i = 0; $i < $this->maxData; $i++) {
                    $childCrossover[$c1][$i] = $this->data[$c[0]][$i];
                    // echo json_encode($childCrossover[$c1][$i]); //masih null
                }
                for ($i = $oneCut, $j = 0; $j < $this->maxData - $oneCut; $j++, $i++) {
                    $childCrossover[$c1][$i] = $this->data[$c[1][$i]];
                    // echo json_encode($childCrossover); //masih null
                }
                echo 'Child ' . $c1 . " = ";
                // $temp2[] = array();
                // $temp2[] = array(intval([$this->maxData]));
                $temp2 = [$this->maxData];
                // echo json_encode($temp2);
                // echo ' aselole ';
                for ($i = 0; $i < $this->maxData; $i++) {
                    // echo $childCrossover[$c1][$i] . " ";
                    $temp2[] = $childCrossover[$c1][$i]; //kromosom child
                    echo json_encode($temp2); //masih null
                    echo '<br> aselole ';
                }
                $temp = is_string($temp2);
                echo '<br>';
                echo $c1 + 1, $c[0] . '|x|' . $c[1], $temp;
            } else {
                $c2 = ++$this->getChildCO;
                echo $c2 . '  ' . $this->getChildCO;
                for ($i = 0; $i < $this->maxData; $i++) {
                    $childCrossover[$c1][$i] = $this->data[$c[0]][$i];
                    $childCrossover[$c2][$i] = $this->data[$c[1]][$i];
                    echo json_encode($childCrossover[$c1]);
                }
                for ($i = $oneCut, $j = 0; $j < $this->maxData - $oneCut; $j++, $i++) {
                    $childCrossover[$c2][$i] = $this->data[$c[0]][$i];
                    $childCrossover[$c2][$i] = $this->data[$c[1]][$i];
                    echo json_encode($childCrossover[$c2]);
                }
                for ($i = $c1; $i <= $c2; $i++) {
                    echo '<br>Child ' . $i . ' = ';
                    $temp2 = $this->maxData;
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
        $this->ofMutasi = intval($this->mr * $this->popsize);
        return $this->ofMutasi;
        echo '<br>Banyak Offspring Mutasi = ' . $this->ofMutasi;

        $this->childMutasi =  [[$this->ofMutasi][$this->maxData]];
        for ($j = 0; $j < $this->ofMutasi; $j++) {
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
        for ($i = 0; $i < $maxData; $i++) {
            $childMutasi[$j][$i] = $this->data[$p][$i];
            if ($i == $r1) {
                $childMutasi[$j][$i] = $this->data[$p][$r2];
            }
            if ($i == $r2) {
                $childMutasi[$j][$i] = $this->data[$p][$r1];
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
                $this->console_log($cons1);
                $this->console_log($cons2);
                $this->console_log($cons3);
                $this->console_log($cons4);
                $this->console_log($cons5);
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
            $allPop = $this->popsize + $this->ofCrossover + $this->ofMutasi;
            $gabungan[] = [$allPop][$this->maxData];

            for ($i = 0; $i < $allPop; $i++) {
                for ($j = 0; $j < $this->maxData; $j++) {
                    if ($i < $this->popsize) {
                        $gabungan[$i][$j] = $data[$i][$j];
                    } elseif ($i < $this->popsize + $this->ofCrossover) {
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
        $this->newFitness = [$this->allPop][2];
        echo '<br> Gabungan Parent dan Child' . ' : ';

        for ($i = 0; $i < $this->allPop; $i++) {
            for ($j = 0; $j < 2; $j++) {
                $this->newFitness[$i][$j] = $this->fitness[$i][$j];
            }
            echo $this->newFitness[$i][0] . ' || ' . $this->newFitness[$i][1];
            $temp2 = $this->newFitness[$i][1];
            $int_allpop = intval($temp2);
            echo '<br>' . $int_allpop;
        }
        for ($i = 0; $i < $this->allPop; $i++) {
            for ($j = 1; $j < $this->allPop; $j++) {
                if ($this->newFitness[$j - 1][0] <= $this->newFitness[$j][0]) {
                    $temp = $this->newFitness[$j - 1][0];
                    $temp2 = $this->newFitness[$j - 1][1];
                    $this->newFitness[$j - 1][0] = $this->newFitness[$j][0];
                    $this->newFitness[$j - 1][1] = $this->newFitness[$j][1];
                    $this->newFitness[$j][0] = $temp;
                    $this->newFitness[$j][1] = $temp2;
                }
            }
        }
        echo 'Order Fitness : ';
        for ($i = 0; $i < $this->allPop; $i++) {
            $temp = $this->newFitness[$i][1];
            $int_allpop = intval($temp);
            echo $this->newFitness[$i][0] . ' | ' . $this->newFitness[$i][1] . ' | ';
            for ($j = 0; $j < $this->maxData; $j++) {
                echo $this->gabungan[$int_allpop][$j] . ', ';
            }
            echo ' ';
        }
        $this->fitnessSaget = $this->newFitness[0][0];
        $indter = floatval($this->newFitness[0][1]);
        $this->individuTerbaik = intval($indter);
        $arr = intval([$this->maxData]);
        $temp2 = '';
        for ($i = 0; $i < 1; $i++) {
            $temp = floatval($this->newFitness[$i][1]);
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
