
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Algoritma
{
    private $data = [];
    private $fullJadwal = [];
    private $jadwal1 = [];
    private $jadwal2 = [];
    private $fitness = [];
    private $newFitness = [];
    private $gabungan = [];
    private $childCrossover = [];
    private $childMutasi = [];
    private $maxData = 35;
    private $fitnessSaget = 0.0;
    private $individuTerbaik = 0;
    private $getChildCO = 0;
    private $ofCrossover = 0;
    private $ofMutasi = 0;
    private $count = 0;
    private $allPop = 0;
    private $cons1 = 0.0;
    private $cons2 = 0.0;
    private $cons3 = 0.0;
    private $cons4 = 0.0;
    private $cons5 = 0.0;
    private $jadwalTerbaik = '';


    function run($popsize, $cr, $mr, $iterasi, $thresholdSaget, $maxPs)
    {
        $this->population($popsize, $maxPs);
        for ($i = 0; $i < 10; $i++) {
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

    function population($popsize, $maxPs) //menghasilkan populasi
    {
        try {
            echo 'Populasi Awal sebanyak ', $popsize, ' individu <br>';
            for ($i = 0; $i < $popsize; $i++) { //banyak individu
                $gen = $this->gen($maxPs); //disini kita mengambil nilai tiap individu
                echo json_encode($gen);
            }
            return $gen; //mengembalikan populasi berupa array
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    function gen($maxPs) //menghasilkan individu
    {
        $arr = [];
        for ($j = 0; $j < $this->maxData; $j++) { //banyak kromosom
            $n = (int) rand(1, $maxPs); //generate random number
            $arr[$j] = $n;
        }
        return $arr; //mengembalikan nilai kromosom untuk tiap gen
    }

    function hitungCrossover($cr, $popsize, $maxPs)
    {
        try {
            $getChildCO = -1;
            $ofCrossover = (int)round($cr * $popsize);
            echo '<br><br>Banyak Offspring Crossover = ', $ofCrossover; //BISA
            // echo json_encode(array_slice($arr, 0, 21));
            // echo ' || ';
            // echo json_encode(array_splice($arr, -21));

            // $child1[$i] = [(array_slice($arr, 0, 21))][array_splice($arr, -21)];
            // $child2[$i + 1] = [(array_splice($arr, 0, 21))][array_slice($arr, -21)];

            // $parent2 = array_splice($arr, -21);
            // $parent1 = array_slice($arr, 0, 21);

            // echo json_encode($population);
            echo '<br><br> Kromosom Crossover : ';


            while ($ofCrossover - $getChildCO != 1) {
                $c = [2];
                $c[0] = (int)rand(0, $popsize);
                $c[1] = (int)rand(0, $popsize);

                $oneCut = (int)rand(1, $maxPs);
                echo '<br>', $c[0], ' | ', $c[1], ' | ', $oneCut; //BISA

                $c1 = ++$getChildCO;
                echo $c1, ' || ', $getChildCO; //BISA

                if ($ofCrossover - $getChildCO == 1) {
                    for ($i = 0; $i < $this->maxData; $i++) {
                        // $this->childCrossover[$c1] = $c1;
                        // $this->childCrossover[$i] = $i;
                        // $this->data[$c[0]] = $c[0];
                        // $this->data[$i] = $i;
                        $this->childCrossover[$c1] = [$i];
                        $this->data[$c[0]] = [$i];
                        $this->childCrossover = $this->data;
                        // $this->childCrossover[$c1][$i] = $this->data[$c[0]][$i];
                    }
                    for ($i = $oneCut; $j = 0; $j < $this->maxData - $oneCut, $j++, $i++) {
                        // $this->childCrossover[$c1] = $c1;
                        // $this->childCrossover[$i] = $i;
                        // $this->data[$c[1]] = $c[1];
                        // $this->data[$i] = $i;
                        $this->childCrossover[$c1] = [$i];
                        $this->data[$c[1]] = [$i];
                        $this->childCrossover = $this->data;
                        // $this->childCrossover[$c1][$i] = $this->data[$c[1]][$i];
                    }
                    echo '<br>Child ', $c1, " = ";
                    $temp2[] = [$this->maxData];
                    for ($i = 0; $i < $this->maxData; $i++) {
                        // $this->childCrossover[$c1] = $c1;
                        // $this->childCrossover[$i] = $i;
                        $this->childCrossover[$c1] = [$i];
                        $this->console_log($temp2);
                    }
                    $temp2[] = $this->childCrossover[$c1]; //kromosom child
                    $temp = implode(" ", $temp2);
                    // $this->console_log($temp);
                    echo $c1 + 1, $c[0], ' x ', $c[1], $temp;
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

    function hitungFitness($popsize)
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
                            echo $this->cons4;
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
            // $childMutasi[$j[$i]] = $data[$p[$i]];
            if ($i == $r1) {
                // $childMutasi[$j[$i]] = $data[$p[$r2]];
            }
            if ($i == $r2) {
                // $childMutasi[$j[$i]] = $data[$p[$r1]];
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
