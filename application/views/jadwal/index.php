    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?php $this->session->flashdata('message'); ?>
            <br>
            <form action="<?= base_url('psikolog/addjadwal'); ?>" method="post">
                <div class="form-group">
                    <label for="popsize">Population Size</label>
                    <input type="number" class="form-control" name="popsize" id="popsize" placeholder="ex : 10" value="10">
                    <small>Banyak populasi yang akan dibuat (popsize)</small>
                </div>
                <div class="form-group">
                    <label for="cr">Crossover Rate</label>
                    <input type="number" class="form-control" name="cr" id="cr" step="0.01" placeholder="ex : 0.5" value="0.5">
                    <small>Nilai untuk persilangan (crossover)</small>
                </div>
                <div class="form-group">
                    <label for="mr">Mutation Rate</label>
                    <input type="number" class="form-control" name="mr" id="mr" step="0.01" placeholder="ex : 0.5" value="0.5">
                    <small>Nilai untuk mutasi (mutation)</small>

                </div>
                <div class="form-group">
                    <label for="iterasi">Iterasi</label>
                    <input type="number" class="form-control" name="iterasi" id="iterasi" placeholder="ex : 1000" value="1000">
                    <small>Seberapa banyak melakukan perulangan sebelum mencapai nilai fitness yang diinginkan</small>

                </div>
                <div class="form-group">
                    <label for="thresholdSaget"> Nilai Fitness Minimal</label>
                    <input type="number" class="form-control" name="thresholdSaget" id="thresholdSaget" placeholder="ex : 0.07" step="0.01" value="0.07">
                    <small>Batas untuk menentukan minimal kualitas dari individu</small>

                </div>
                <input type="hidden" value="<?= $maxPs; ?>" id="maxPs">
                <button type="button" onclick="run()" class="btn btn-primary">Submit</button>
                <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
            </form>

        </div>
    </div>

    <script src="<?= base_url(); ?>assets/js/algoritma.js"></script>
    <!-- <script type="text/javascript">
        var popsize;
        var cr;
        var mr;
        var iterasi;
        var thresholdSaget;
        var maxPs;
        var maxData = 35;


        function getData() {
            popsize = document.getElementById("popsize").value;
            cr = document.getElementById("cr").value;
            mr = document.getElementById("mr").value;
            iterasi = document.getElementById("iterasi").value;
            thresholdSaget = document.getElementById("thresholdSaget").value;
            maxPs = document.getElementById("maxPs").value;

            return [popsize, cr, mr, iterasi, thresholdSaget, maxPs];
        }

        function population() {
            let data = getData();

            for (let i = 0; i < popsize; i++) {
                let arr = [];
                for (let j = 0; j < window.maxData; j++) {

                    var n = getRandomInt(1, maxPs);
                    arr[j] = n;
                }
                // console.log(arr); //Worked!
            }
        }

        function crossover() {
            temp = '';
            getChildCO = -1;
            ofCrossover = Math.round(cr * popsize);
            childCrossover = new Array(2); //Worked!
            childCrossover[0] = ofCrossover; //Worked!
            childCrossover[1] = maxData; //Worked!

            while (ofCrossover - getChildCO != 1) {
                c = new Array(2); //Worked!
                c[0] = getRandomInt(1, popsize);
                c[1] = getRandomInt(1, popsize);

                oneCut = getRandomInt(1, maxPs);
                c1 = ++getChildCO;

                if (ofCrossover - getChildCO == 1) {
                    for (let i = 0; i < maxData; i++) {
                        data = new Array(2);
                        // childCrossover[c1][i] = data[c[0]][i];
                    }
                    // for (let i = oneCut, j = 0; j < maxData - oneCut; j++, i++) {
                    //     childCrossover[c1][i] = data[c[1]][i];
                    //     console.log(data);
                    // }
                }

            }
        }

        function run() {
            population();
            crossover();

        }

        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    </script> -->