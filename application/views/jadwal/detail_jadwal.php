    <!-- Page Heading -->
    <h1 class="mb-4 text-gray-800"><?= $title; ?></h1>

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
            $sesi = $this->db->get('sesi')->result_array();


            for ($i = 0; $i < count($id_hari); $i++) {
                $id_sesi = array_chunk($id_hari[$i], $banyak_per_sesi);
                echo '<div class="col-lg-3 mt-3">';
                echo '<h2 class="font-weight-bold">' . $hari[$i] . '</h2>';
                for ($j = 0; $j < count($id_sesi); $j++) {
                    $id_psikolog = array_chunk($id_sesi[$j], 1);
                    echo '<br/><p class="font font-weight-bolder">Sesi ' . implode(" | ", $sesi[$j]) . '</p>';
                    for ($k = 0; $k < count($id_psikolog); $k++) {
                        $psikolog = $this->db->get_where('psikolog', array('id_psikolog' => implode(" ", $id_psikolog[$k])))->row_array();
                        echo $psikolog['nama_psikolog'] . "<br>";
                    }
                }
                echo '</div>';
            }
            ?>
        </table>
    </div>