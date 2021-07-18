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
            console.log("Banyak Offspring Crossover = ", ofCrossover);
            let childCrossover = new Array(2); //Worked!
            childCrossover[0] = ofCrossover; //Worked!
            childCrossover[1] = maxData; //Worked!
            
            while (ofCrossover - getChildCO != 1) {
                let c = new Array(2); //Worked!
                c[0] = getRandomInt(1, popsize); //misal = 7
                c[1] = getRandomInt(1, popsize);

                let oneCut = getRandomInt(1, maxPs);
                console.log(c[0] + " | " +  c[1] + " | " + oneCut);

                let c1 = getChildCO; //misal = 0
                console.log(c1 + " " + getChildCO);

                //harus melakukan perulangan terlebih dahulu baru boleh bertambah
                if (ofCrossover - getChildCO == 1) {
                    for (let i = 0; i < maxData; i++) {
                        childCrossover[i] = [];
                        for (let j = 0; j < c1; j++) {
                            childCrossover[c1][i] = data[c[0]][i];
                        }
                    }
                    for (let i = oneCut, j = 0; j < maxData - oneCut; j++, i++) {
                        childCrossover[i] = [];
                        childCrossover[c1][i] = data[c[1]][i];
                    }
                    console.log("Child " + c1 + " = ");
                    let temp2 = new Array(maxData);
                    for (let i = 0; i < maxData; i++) {
                        temp2[i] = childCrossover[c1][i];
                    }
                    console.log(temp2);
                } else {
                    let c2 = getChildCO;
                    for (let i = 0; i < maxData; i++) {
                        childCrossover[i] = [];
                        for (let j = 0; j < c1; j++) {
                            childCrossover[j][i] = data[c[0]][i];
                        }
                        for (let j = 0; j < c2; j++) {
                            childCrossover[j][i] = data[c[1]][i];
                        }
                    }
                    for (let i = oneCut, j = 0; j < maxData - oneCut; j++, i++) {
                        childCrossover[i] = [];
                        for (let k = 0; k < c2; k++) {
                            childCrossover[k][i] = data[c[0]][i];
                        }
                        for (let k = 0; k < c1; k++) {
                            childCrossover[k][i] = data[c[1]][i];
                        }
                    }
                    for (let i = c1; i <= c2; i++) {
                        let temp2 = new Array(maxData);
                        childCrossover[i] = [];
                        for (let j = 0; j < maxData; j++) {
                            temp2[j] = childCrossover[i][j];
                        }
                        temp = temp2.toString();
                    }
                }
                ++getChildCO;
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