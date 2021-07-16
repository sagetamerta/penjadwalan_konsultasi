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
                console.log(arr); //Worked!
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