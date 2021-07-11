
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Algoritma
{
    public $data = [];
    public $fullJadwal = [];
    public $jadwal1 = [];
    public $jadwal2 = [];
    public $fitness = [];
    public $newFitness = [];
    public $gabungan = [];
    public $childCrossover = [];
    public $childMutasi = [];
    public $maxData = 35;
    public $fitnessSaget = 0.0;
    public $individuTerbaik = 0;
    public $getChildCO = 0;
    public $ofCrossover = 0;
    public $ofMutasi = 0;
    public $count = 0;
    public $allPop = 0;
    public $cons1 = 0.0;
    public $cons2 = 0.0;
    public $cons3 = 0.0;
    public $cons4 = 0.0;
    public $cons5 = 0.0;
    public $jadwalTerbaik = '';

    public function run($popsize, $cr, $mr, $iterasi, $thresholdSaget, $maxPs)
    {
        $this->createPopulation($popsize, $maxPs);
        for ($i = 0; $i < $iterasi; $i++) {
            $this->hitungCrossover($cr, $popsize, $maxPs);
            // $this->hitungFitness($popsize);
            // $this->seleksiElitism();
            // $this->hitungMutasi($mr);
            if ($this->fitnessSaget >= $thresholdSaget) {
                echo '<br>';
                echo 'Berhenti di iterasi ke : ', ($i + 1);
                break;
            }
        }
    }

    public function createPopulation($popsize, $maxPs)
    {
        try {
            echo 'Populasi Awal sebanyak ', $popsize, ' individu';
            for ($i = 0; $i < $popsize; $i++) { //banyak individu
                $gen = $this->gen($maxPs); //disini kita mengambil nilai tiap individu
                echo '<br />';
                echo implode(' | ', $gen);
            }
            return $gen; //mengembalikan populasi berupa array
            // masalahnya hanya return value paling akhir dari for loop
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function gen($maxPs) //menghasilkan individu
    {
        $arr = [];
        for ($j = 0; $j < $this->maxData; $j++) { //banyak kromosom
            $n = (int) rand(1, $maxPs); //generate random number
            $arr[$j] = $n;
        }
        return $arr; //mengembalikan nilai kromosom untuk tiap gen
    }
    

    public function hitungCrossover($cr, $popsize, $maxPs)
    {
        try {
            $getChildCO = -1;
            $ofCrossover = (int)round($cr * $popsize);
            echo '<br><br>Banyak Offspring Crossover = ', $ofCrossover; //BISA
            echo '<br><br>Kromosom Crossover : ';


            while ($ofCrossover - $getChildCO != 1) {
                $c = [2];
                $c[0] = (int)rand(0, $popsize);
                $c[1] = (int)rand(0, $popsize);

                $oneCut = (int)rand(1, $maxPs);
                echo '<br>', $c[0], ' | ', $c[1], ' | ', $oneCut; //BISA

                $c1 = ++$getChildCO;
                echo '<br>', $c1, '  ', $getChildCO, '<br>'; //BISA

                if ($ofCrossover - $getChildCO == 1) {
                    for ($i = 0; $i < $this->maxData; $i++) {
                        $this->childCrossover[$c1] = [$i];
                        $this->data[$c[0]] = [$i];
                        $this->childCrossover = $this->data;
                    }
                    for ($i = $oneCut; $j = 0; $j < $this->maxData - $oneCut, $j++, $i++) {
                        $this->childCrossover[$c1] = [$i];
                        $this->data[$c[1]] = [$i];
                        $this->childCrossover = $this->data;
                    }
                    echo '<br>Child ', $c1, " = ";
                    $temp2[] = [$this->maxData];
                    for ($i = 0; $i < $this->maxData; $i++) {
                        $this->childCrossover[$c1] = [$i];
                        // $this->console_log($temp2);
                    }
                    $temp2[] = $this->childCrossover[$c1]; //kromosom child
                    // $temp = implode(" ", $temp2);
                    // $this->console_log($temp);
                    // echo $c1 + 1, $c[0], ' x ', $c[1], $temp;
                    // echo json_encode($temp2);
                } else {
                    // $c2 = ++$this->getChildCO;
                    // echo $c2 . '  ' . $this->getChildCO;
                    // for ($i = 0; $i < $this->maxData; $i++) {
                    //     $this->childCrossover[$c1][$i] = $this->data[$c[0][$i]];
                    //     $this->childCrossover[$c2][$i] = $this->data[$c[1][$i]];
                    // }
                    // for ($i = $oneCut, $j = 0; $j < $this->maxData - $oneCut; $j++, $i++) {
                    //     $this->childCrossover[$c2][$i] = $data[$c[0]][$i];
                    //     $this->childCrossover[$c1][$i] = $data[$c[1]][$i];
                    // }
                    // for ($i = $c1; $i <= $c2; $i++) {
                    //     echo '<br>Childlast ' . $i . ' = ';
                    //     $temp2 = [$this->maxData];
                    //     for ($j = 0; $j < $this->maxData; $j++) {
                    //         echo json_encode($this->childCrossover) . ' ';
                    //         $temp2[$j] = $this->childCrossover[$i][$j];
                    //     }
                    //     echo "<br>";
                    //     echo $i + 1, $c[0] . '|x|' . $c[1], $temp;
                    // }
                }
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function hitungFitness($popsize)
    {
        $data = [];
        try {
            $this->count = 0;
            $allPop = $this->popsize + $this->ofCrossover + $this->ofMutasi;
            // $gabungan[] = [$allPop][$this->maxData];
            // $gabungan = new $gabungan();

            for ($i = 0; $i < $allPop; $i++) {
                $gabungan = [$this->maxData];
                for ($j = 0; $j < $this->maxData; $j++) {
                    if ($i < $popsize) {
                        $gabungan[$j] = $data[$i][$j];
                    } elseif ($i < $popsize + $this->ofCrossover) {
                        $gabungan[$j] = $this->childCrossover[$i - $popsize[$j]];
                    } elseif ($i < $allPop) {
                        $gabungan[$j] = $this->childMutasi[$i - ($popsize + $this->ofCrossover)[$j]];
                    }
                }
            }
            $this->fitness[] = [$allPop][7];
            $this->getFitness($data, $popsize, "Parent");
            $this->getFitness($this->childCrossover, $this->ofCrossover, "Child Crossover");
            $this->getFitness($this->childMutasi, $this->ofMutasi, "Child Mutasi");
        } catch (Exception $ex) {
            echo 'Message: ' . $ex->getMessage();
        }
    }

    public function getConstraint1($array = [], $array2 = [])
    {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $this->cons1 = $this->cons1 + 10;
                }
            }
        }
    }

    public function ge2($array = [], $array2 = [])
    {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $this->cons2 = $this->cons2 + 20;
                }
            }
        }
    }

    public function getConstraint3($array = [], $array2 = [])
    {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                if ($array[$i] == $array2[$j]) {
                    $this->cons3 = $this->cons3 + 50;
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
                            $this->cons4 = $this->cons4 + 55;
                            echo $this->cons4;
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
                $this->cons5 = $this->cons5 + 60;
            }
        }
    }



    public function hitungMutasi()
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

    public function reciprocalExchangeMutation($p, $r1, $r2, $j)
    {
        for ($i = 0; $i < $this->maxData; $i++) {
            // $childMutasi[$j[$i]] = $data[$p[$i]];
            if ($i == $r1) {
                // $childMutasi[$j[$i]] = $data[$p[$r2]];
            }
            if ($i == $r2) {
                // $childMutasi[$j[$i]] = $data[$p[$r1]];
            }
        }
    }

    public function getFitness($array = [], $size = 0, $nama = '')
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



    // Mulai fungsi mengurutkan nilai fitness dari terbesar ke terkecil
    public function seleksiElitism()
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

    public function printArray($jadwal = '', $jadwal12 = [])
    {
        echo $jadwal . '<br>';
        echo strval($jadwal12);
    }

    public function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }
}
