
<?php
defined('BASEPATH') or exit('No direct script access allowed');



class algoritma
{

    // private $data = [[]];
    // private $childMutasi = [[]];
    // private $childCrossover = [[]];
    // private $gabungan = [[]];
    // private $newFitness = [[]];
    // private $fitness = [[]];
    // private $halangan = [[]];
    // nilai fitness individu terbaik setiap iterasi
    private $individuTerbaik;
    // nomor individu terbaik setiap iterasi
    // treshold yang akan diuji
    private $maxData = 42;
    private $getChildCO = 0, $ofCrossover = 0, $ofMutasi = 0, $count = 0, $allPop = 0;
    private $iterasi = 100;
    private $cHalangan = 0;
    private $cons1 = 0.0, $cons2 = 0.0, $cons3 = 0.0, $cons4 = 0.0, $cons5 = 0.0;
    // private $fullJadwal = [];
    // private $jadwal1 = [];
    // private $jadwal2 = [];
    private $fitnessSaget = 0.0;
    private $thresholdSaget = 0.0007;
    private $popsize = 10; //$this->input->post('popsize');
    private $cr = 0.5; //$this->input->post('cr');
    private $mr = 0.5; //$this->input->post('mr');

    function inisialisasi()
    {
        $temp = '';
        echo 'Populasi Awal : <br>';
        for ($i = 0; $i < $this->popsize; $i++) { //banyak individu
            $arr = [$this->maxData];
            for ($j = 0; $j < $this->maxData; $j++) { //banyak kromosom
                $n = (int) rand(1, $this->maxPs); //generate random number
                $data[$i][$j] = $n;
                $arr[$j] = $data[$i][$j];
            }
            $temp =  strval(json_encode($arr));
            // var_dump($temp);
            // var_dump($temp);
            // $temp = substr($temp), 10);
            echo substr($temp, 100) . ',...<br>';
        }
    }

    function iterasi()
    {
        for ($i = 0; $i < $this->iterasi; $i++) {
            $this->hitungCrossover();
            // $this->hitungMutasi();
            // $this->seleksiElitism();
            // $this->hitungFitness();
            // if ($this->fitnessSaget >= $this->thresholdSaget) {
            //     echo '<br>';
            //     echo 'Berhenti di iterasi ke : ' . ($i + 1);
            //     break;
            // }
        }
    }

    function getConstraint1($array = [], $array2 = [])
    {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $this->cons1 = $this->cons1 + 10;
                }
            }
        }
    }

    function ge2($array = [], $array2 = [])
    {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $this->cons2 = $this->cons2 + 20;
                }
            }
        }
    }

    function getConstraint3($array = [], $array2 = [])
    {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $this->cons3 = $this->cons3 + 50;
                }
            }
        }
    }

    function getConstraint4($array = [])
    {
        $s2remove = [count($array)];
        for ($i = 0; $i < count($array); $i++) {
            for ($j = $i + 1; $j < count($array); $j++) {
                if ($i != $j) {
                    if ($array[$i] == $array[$j]) {
                        if ($array[$j] == $s2remove[$j]) {
                            continue;
                        } else {
                            $this->cons4 = $this->cons4 + 55;
                            $s2remove[$j] = $array[$j];
                        }
                    }
                }
            }
        }
    }

    function getConstraint5($array = [], $value = 0)
    {
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] == $value) {
                $this->cons5 = $this->cons5 + 60;
            }
        }
    }

    function hitungCrossover()
    {
        $temp = '';
        $this->getChildCO = -1;
        $this->ofCrossover = (int)round($this->cr * $this->popsize);
        echo '<br>Banyak Offspring Crossover = ' . $this->ofCrossover; //BISA

        echo '<br> Kromosom Crossover : <br>';
        for ($i = 0; $i < $this->ofCrossover; $i++) {
            $this->childCrossover = [$this->maxData];
            for ($j = 0; $j < $this->maxData; $j++) {
                $n = (int)rand(1, $this->maxPs);
                $data[$i][$j] = $n;
                $this->childCrossover[$j] = $data[$i][$j];
            }
            echo json_encode($this->childCrossover);
            echo '<br>';
        }

        while ($this->ofCrossover - $this->getChildCO != 1) {
            $c = [2];
            $c[0] = (int)rand(0, $this->popsize);
            $c[1] = (int)rand(0, $this->popsize);

            $oneCut = (int)rand(1, $this->maxPs);
            echo '<br>' . $c[0] . ' | ' . $c[1] . ' | ' . $oneCut; //BISA

            $c1 = ++$this->getChildCO;
            echo $c1 . ' || ' . $this->getChildCO; //BISA

            if ($this->ofCrossover - $this->getChildCO == 1) {
                for ($c1 = 0; $c1 < $this->maxData; $c1++) {
                    $this->childCrossover = [$this->maxData];
                    for ($i = 0; $i < $this->maxData; $i++) {
                        $n = (int)rand(1, $this->maxPs);
                        $data[$i][$j] = $n;
                        $this->childCrossover[$c1] = $data[$c[0]][$i];
                    }
                    echo json_encode($this->childCrossover);
                    echo '<br>';
                }

                for ($i = $oneCut, $j = 0; $j < $this->maxData - $oneCut; $j++, $i++) {
                    $this->childCrossover[$c1][$i] = $this->data[$c[1][$i]];
                }

                echo 'Child ' . $c1 . " = ";
                $temp2 = [$this->maxData];
                for ($i = 0; $i < $this->maxData; $i++) {
                    $temp2[$i] = $this->childCrossover[$c1[$i]]; //kromosom child
                    echo json_encode($this->childCrossover) . " ";
                }
                // $temp = strval($temp2);
                echo "<br>";
                echo $c1 + 1, $c[0] . '|x|' . $c[1], $temp2;
            } else {
                $c2 = ++$this->getChildCO;
                echo $c2 . '  ' . $this->getChildCO;
                for ($i = 0; $i < $this->maxData; $i++) {
                    $this->childCrossover = [$this->maxData];
                    for ($c1 = 0; $c1 < $this->maxData; $c1++) {
                        $n = (int)rand(1, $this->maxPs);
                        $data[$i][$c1] = $n;
                        $this->childCrossover[$c1] = $data[$i][$c1];
                    }
                    echo '<br> c1: ';
                    echo json_encode($this->childCrossover);
                    echo '<br>';
                    for ($c2 = 0; $c2 < $this->maxData; $c2++) {
                        $n = (int)rand(1, $this->maxPs);
                        $data[$i][$c2] = $n;
                        $this->childCrossover[$c2] = $data[$i][$c2];
                    }
                    echo '<br> c2: ';
                    echo json_encode($this->childCrossover);
                    echo '<br>';
                }
                for ($i = $oneCut, $j = 0; $j < $this->maxData - $oneCut; $j++, $i++) {
                    $this->childCrossover[$c2][$i] = $data[$c[0]][$i];
                    $this->childCrossover[$c1][$i] = $data[$c[1]][$i];
                }
                for ($i = $c1; $i <= $c2; $i++) {
                    echo '<br>Childlast ' . $i . ' = ';
                    $temp2 = [$this->maxData];
                    for ($j = 0; $j < $this->maxData; $j++) {
                        $n = (int)rand(1, $this->maxPs);
                        $data[$i][$j] = $n;
                        $temp2[$j] = $data[$i][$j];
                    }
                    echo json_encode($temp2) . ' ';
                    // $temp = strval($temp2);
                    echo "<br>";
                    echo $i + 1, $c[0] . '|x|' . $c[1], $temp;
                }
            }
        }
    }

    function hitungMutasi()
    {
        $temp = '';
        $this->ofMutasi = (int)round($this->mr * $this->popsize);
        echo '<br>Banyak Offspring Mutasi = ' . $this->ofMutasi;

        $this->childMutasi =  [$this->ofMutasi[$this->maxData]];
        for ($j = 0; $j < $this->ofMutasi; $j++) {
            $p = (int)rand(0, $this->popsize);
            $r1 = (int)rand(0, $this->maxData);
            $r2 = (int)rand(0, $this->maxData);
            echo '<br>' . $p . ' | ' . $r1 . ' | ' . $r2;

            $this->reciprocalExchangeMutation($p, $r1, $r2, $j);
            echo 'ChildM ' . $j . ' = ';

            $arr = [$this->maxData];
            for ($i = 0; $i < $this->maxData; $i++) {
                echo $this->childMutasi[$j][$i] . ' ';
                $arr[$j] = $this->childMutasi[$j][$i];
            }
            // foreach ($arr as $ar) {
            //     echo $ar[$i];
            // }
            echo 'CRX<br>';
            echo $this->ofCrossover . ' ' . ($j + 1);
            echo '<br>';
            echo 'MUTATE ARR : ';
            echo  json_encode($arr);
            // $temp = strval($arr[$i]); //masih null
        }
    }

    function reciprocalExchangeMutation($p, $r1, $r2, $j)
    {
        for ($i = 0; $i < $this->maxData; $i++) {
            $childMutasi[$j[$i]] = $this->data[$p[$i]];
            if ($i == $r1) {
                $childMutasi[$j[$i]] = $this->data[$p[$r2]];
            }
            if ($i == $r2) {
                $childMutasi[$j[$i]] = $this->data[$p[$r1]];
            }
        }
    }

    function getFitness($array = [], $size = 0, $nama = '')
    {
        try {
            for ($j = 0; $j < $size; $j++) {
                echo '<br> ' . $nama . ($j + 1) . '  ';
                $temp = [$this->maxData];
                $a = 0;
                $cons1 = 0.0;
                $cons2 = 0.0;
                $cons3 = 0.0;
                $cons4 = 0.0;
                $cons5 = 0.0;

                for ($k = 0; $k < $this->maxData; $k++) {
                    $temp[] = $array[$j[$k]];
                    if ($k == 11) {
                        $a++;
                        echo 'Hari ke-' . $a . ' : ';
                        $this->fullJadwal = array_slice($temp, 0, 12);

                        $this->jadwal1 = array_slice($this->fullJadwal, 0, count($this->fullJadwal) / 2);
                        echo '<br>Jadwal 1 : <br>';
                        print_r($this->jadwal1);
                        $this->jadwal2 = array_slice($this->fullJadwal, count($this->fullJadwal) / 2, count($this->fullJadwal));
                        echo '<br>Jadwal 2 : <br>';
                        print_r($this->jadwal2);

                        $this->getConstraint4($this->jadwal1);
                        $this->getConstraint4($this->jadwal2);
                        $this->getConstraint3($this->jadwal1, $this->jadwal2);
                        if ($this->cHalangan != 0) {
                            for ($i = 0; $i < $this->cHalangan; $i++) {
                                if ($this->halangan[$i[1]] == $a) {
                                    $this->getConstraint5($this->fullJadwal, $this->halangan[$i[0]]);
                                }
                            }
                        }
                    } elseif (($k + 1) % 12 == 0) {
                        $a++;
                        echo 'Hari ke-' . $a . ' : ';
                        echo '<br>Jadwal Kemarin : <br>';
                        $this->fullJadwal = array_slice($temp, $k - 11, $k + 1);

                        $this->getConstraint1($this->fullJadwal, $this->jadwal1);
                        $this->getConstraint1($this->fullJadwal, $this->jadwal2);
                        $this->jadwal1 = array_slice($this->fullJadwal, 0, count($this->fullJadwal) / 2);
                        echo '<br>Jadwal 1 : <br>';
                        $this->jadwal2 = array_slice($this->fullJadwal, count($this->fullJadwal) / 2, count($this->fullJadwal));
                        echo '<br>Jadwal 2 : <br>';

                        $this->getConstraint4($this->jadwal1);
                        $this->getConstraint4($this->jadwal2);
                        $this->getConstraint3($this->jadwal1, $this->jadwal2);
                        if ($this->cHalangan != 0) {
                            for ($i = 0; $i < $this->cHalangan; $i++) {
                                if ($this->halangan[$i[1]] == $a) {
                                    $this->getConstraint5($this->fullJadwal, $this->halangan[$i[0]]);
                                }
                            }
                        }
                    }
                }
                $this->fitness[$this->count[0]] = 1. / (1 + $cons1 + $cons2 + $cons3 + $cons4 + $cons5);
                $this->fitness[$this->count[1]] = $this->count;
                $this->fitness[$this->count[2]] = $cons1;
                $this->fitness[$this->count[3]] = $cons2;
                $this->fitness[$this->count[4]] = $cons3;
                $this->fitness[$this->count[5]] = $cons4;
                $this->fitness[$this->count[6]] = $cons5;
                echo '<br>';
                echo 'Cons1 : ' . $cons1;
                echo 'Cons1 : ' . $cons2;
                echo 'Cons1 : ' . $cons3;
                echo 'Cons1 : ' . $cons4;
                echo 'Cons1 : ' . $cons5;
                echo 'Nilai Fitness : ' . $this->fitness[$this->count[0]];
                $this->count++;
            }
        } catch (Exception $ex) {
            echo 'Message: ' . $ex->getMessage();
        }
    }

    function hitungFitness()
    {
        try {
            $this->count = 0;
            // $allPop = $this->popsize + $this->ofCrossover + $this->ofMutasi;
            $allPop = $this->popsize;
            $gabungan[] = [$allPop][$this->maxData];

            for ($i = 0; $i < $allPop; $i++) {
                for ($j = 0; $j < $this->maxData; $j++) {
                    if ($i < $this->popsize) {
                        $gabungan[$j] = $this->data[$i[$j]];
                    } elseif ($i < $this->popsize + $this->ofCrossover) {
                        $gabungan[$j] = $this->childCrossover[$i - $this->popsize[$j]];
                    } elseif ($i < $allPop) {
                        $gabungan[$j] = $this->childMutasi[$i - ($this->popsize + $this->ofCrossover)[$j]];
                    }
                }
            }
            $this->fitness[] = [$allPop][7];
            $this->getFitness($this->data, $this->popsize, "Parent");
            $this->getFitness($this->childCrossover, $this->ofCrossover, "Child Crossover");
            $this->getFitness($this->childMutasi, $this->ofMutasi, "Child Mutasi");
        } catch (Exception $ex) {
            echo 'Message: ' . $ex->getMessage();
        }
    }

    // Mulai fungsi mengurutkan nilai fitness dari terbesar ke terkecil
    function seleksiElitism()
    {
        $this->newFitness = floatval([$this->allPop[2]]);
        echo '<br> Gabungan Parent dan Child' . ' : ';

        for ($i = 0; $i < $this->allPop; $i++) {
            for ($j = 0; $j < 2; $j++) {
                $this->newFitness[$i[$j]] = floatval($this->fitness[$i[$j]]);
            }
            echo $this->newFitness[$i[0]] . ' || ' . $this->newFitness[$i[1]];
            $temp = floatval($this->newFitness[$i[1]]);
            $int_allpop = (int)$temp;
            echo '<br>' . $int_allpop . '||' . $this->newFitness[$i[0]];
        }
        for ($i = 0; $i < $this->allPop; $i++) {
            for ($j = 1; $j < $this->allPop; $j++) {
                if ($this->newFitness[$j - 1][0] <= $this->newFitness[$j][0]) {
                    $temp = floatval($this->newFitness[$j - 1][0]);
                    $temp2 = floatval($this->newFitness[$j - 1][1]);
                    $this->newFitness[$j - 1][0] = $this->newFitness[$j][0];
                    $this->newFitness[$j - 1][1] = $this->newFitness[$j][1];
                    $this->newFitness[$j[0]] = $temp;
                    $this->newFitness[$j[1]] = $temp2;
                }
            }
        }
        echo 'Order Fitness : ';
        for ($i = 0; $i < $this->allPop; $i++) {
            $temp = floatval($this->newFitness[$i[1]]);
            $int_allpop = (int)$temp;
            echo $this->newFitness[$i][0] . ' | ' . $this->newFitness[$i][1] . ' | ';
            for ($j = 0; $j < $this->maxData; $j++) {
                echo $this->gabungan[$int_allpop[$j]] . ', ';
            }
            echo ' ';
        }
        $this->fitnessSaget = $this->newFitness[0][0];
        $indter = floatval($this->newFitness[0][1]);
        $this->individuTerbaik = (int)$indter;
        $arr = [$this->maxData];
        $temp2 = '';
        for ($i = 0; $i < 1; $i++) {
            $temp = floatval($this->newFitness[$i][1]);
            $int_allpop = (int)$temp;
            for ($j = 0; $j < $this->maxData; $j++) {
                $arr[$j] = $this->gabungan[$int_allpop][$j];
            }
        }
        $temp2 = strval($arr);
        $this->jadwalTerbaik = $temp2;
        echo 'JADWAL TERBAIK : <br>';
        echo json_encode($arr[$j]);
    }

    function printArray($jadwal = '', $jadwal12 = [])
    {
        echo $jadwal . '<br>';
        echo strval($jadwal12);
    }

    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }
}
