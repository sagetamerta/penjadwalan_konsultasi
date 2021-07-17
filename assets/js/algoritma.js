        let popsize;
        let cr;
        let mr;
        let iterasi;
        let thresholdSaget;
        let maxPs;
        let maxData = 35;
        let data = [];

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
            for (let i = 0; i < popsize; i++) {
                data[i] = [];
                let arr = [maxData];
                for (let j = 0; j < maxData; j++) {
                    let n = getRandomInt(1, maxPs);
                    data[i][j] = n;
                    arr[j] = data[i][j];
                }
                console.log(arr); //FIXED!!!!!
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
                c[0] = getRandomInt(1, popsize); //misal = 7
                c[1] = getRandomInt(1, popsize);

                let oneCut = getRandomInt(1, maxPs);
                let c1 = ++getChildCO; //misal = 0

                if (ofCrossover - getChildCO == 1) { 
                    for (let i = 0; i < c1; i++) { //lakukan perulangan sebanyak maxData
                        // childCrossover[c1][i] = data[c[0]][i]; //dan hasilkan sebuah array multi
                        childCrossover[i] = [];
                        let dataC = [c[0]];
                        for (let j = 0; j < c[0]; j++) {
                            data[c[0]] = [c[0]];
                        }
                        //childCrossover[c1][i]
                        /*
                        childCrossover = 
                        [
                            [1],
                            [2],
                            [3],
                            [4],
                            [5],
                            [6],
                            ...sampe 35
                        ]
                        =
                        data[c[0]][i]
                        data = 
                        [
                            [1],
                            [2],
                            [3],
                            [4],
                            [5],
                            [6],
                            ...sampe 35
                        ],
                        [
                            [1],
                            [2],
                            [3],
                            [4],
                            [5],
                            [6],
                            ...sampe 35
                        ],
                        [
                            [1],
                            [2],
                            [3],
                            [4],
                            [5],
                            [6],
                            ...sampe 35
                        ],
                        [
                            [1],
                            [2],
                            [3],
                            [4],
                            [5],
                            [6],
                            ...sampe 35
                        ],
                        ... sampe 7
                        */
                    }
                    // for (let i = 0; i < maxData; i++) { //asli
                    //     childCrossover[c1][i] = data[c[1]][i];
                    // }

                    // for (let i = oneCut, j = 0; j < maxData - oneCut; j++, i++) { //asli
                    //     childCrossover[c1][i] = data[c[2]][i];
                    // }

                }

            }
        }

        function run() {
            getData();
            population();
            crossover();

        }

        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }