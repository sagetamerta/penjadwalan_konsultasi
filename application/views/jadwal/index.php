<?php

echo 'Isi form untuk ambil popsize | max data diambil dari jumlah psikolog <br>';
// INISIALISASI
// random arrays
$randArray = [];
$popsize = 10;
$maxData = 20;


for ($i = 0; $i < $popsize; $i++) { //for loop populasi = 10 kebawah
    echo '<br>';
    for ($j = 0; $j < $maxData; $j++) { //fpr loop kromosom dari tiap populasi = 20 kesamping
        $value = rand(1, $maxData);
        $randArray[] = $value;
        echo $value . '|';
    }
}


// hasil yang diharapkan semua beda angkanya
// *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|
// *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|
// *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|
// *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|
// *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|
// *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|
// *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|
// *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|
// *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|
// *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|
// *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|