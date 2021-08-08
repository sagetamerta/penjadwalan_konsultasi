    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row" style="overflow-x:auto;">
        <table class="table table-hover">
            <?php

            $newjadwal = array(); //basic array
            foreach ($detail_jadwal as $d) {
                $newjadwal[] = intval($d['id_psikolog']);
            }

            $banyak_per_hari = ceil(count($newjadwal) / 7);
            $banyak_per_sesi = ceil($banyak_per_hari / 3);
            $id_hari = array_chunk($newjadwal, $banyak_per_hari);
            $hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
            $sesi = ["Sesi 1", "Sesi 2", "Sesi 3"];


            for ($i = 0; $i < count($id_hari); $i++) {
                $id_sesi = array_chunk($id_hari[$i], $banyak_per_sesi);
                echo '<div class="col">';
                echo '<h2 class="text-danger text-lg">' . $hari[$i] . '</h2>';
                for ($j = 0; $j < count($id_sesi); $j++) {
                    $id_psikolog = array_chunk($id_sesi[$j], 1);
                    echo $sesi[$j] . "<br>";
                    for ($k = 0; $k < count($id_psikolog); $k++) {
                        echo "" .  json_encode($id_psikolog[$k]) . "<br>";
                    }
                }
                echo '</div>';
            }
            ?>
        </table>
    </div>