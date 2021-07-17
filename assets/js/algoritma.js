        let popsize;
        let cr;
        let mr;
        let iterasi;
        let thresholdSaget;
        let maxPs;
        let maxData = 35;
        let data = [popsize][maxData];


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

            /*  [
                popsize = [
                    maxData
                ],
                popsize = [
                    maxData
                ],
                popsize = [
                    maxData
                ],
                popsize = [
                    maxData
                ],
            ]
            */
            data = [popsize][maxData];

            for (let i = 0; i < popsize; i++) {
                let arr = [maxData];
                // data = [i];
                for (let j = 0; j < maxData; j++) {
                    let n = getRandomInt(1, maxPs);
                    data[i][j] = n;
                    arr[j] = data[i][j];
                    // arr[j] = n;
                    console.log(arr);
                }
            }
        }

        function crossover() {
            let temp = '';
            let getChildCO = -1;
            let ofCrossover = Math.round(cr * popsize);
            let childCrossover = new Array(2); //Worked!
            childCrossover[0] = ofCrossover; //Worked!
            childCrossover[1] = maxData; //Worked!
            
            while (ofCrossover - getChildCO != 1) {
                let c = new Array(2); //Worked!
                c[1] = getRandomInt(1, popsize);
                c[2] = getRandomInt(1, popsize);

                let oneCut = getRandomInt(1, maxPs);
                let c1 = ++getChildCO;

                if (ofCrossover - getChildCO == 1) {   
                    for (let i = 0; i < maxData; i++) { //asli
                        childCrossover[c1][i] = data[c[1]][i];
                    }

                    // for (let i = oneCut, j = 0; j < maxData - oneCut; j++, i++) { //asli
                    //     childCrossover[c1][i] = data[c[2]][i];
                    // }

                }

            }
        }

        function run() {
            getData();
            population();
            // crossover();

        }

        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }