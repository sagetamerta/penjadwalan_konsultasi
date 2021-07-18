        let data = [];
        let childMutasi = [];
        let childCrossover = [];
        let gabungan = [];
        let newFitness = [];
        let fitness = [];
        let individuTerbaik = 0;
        let thresholdSaget = 0.0;
        let indexTerbaik = 0;
        let maxData = 0;
        let maxPs = 0;
        let getChildCO = 0;
        let ofCrossover = 0;
        let ofMutasi = 0;
        let popsize = 0;
        let iterasi = 0;
        let count = 0;
        let allPop = 0;
        let cons1 = 0.0;
        let cons2 = 0.0;
        let cons3 = 0.0;
        let cons4 = 0.0;
        let cons5 = 0.0;
        let fullJadwal = [];
        let jadwal1 = [];
        let jadwal2 = [];
        let cr = 0.0;
        let mr = 0.0;
        let jadwalTerbaik = "";
        let cHalangan = 0;
        let halangan = [];

        function getData() {
            popsize = document.getElementById("popsize").value;
            cr = document.getElementById("cr").value;
            mr = document.getElementById("mr").value;
            iterasi = document.getElementById("iterasi").value;
            thresholdSaget = document.getElementById("thresholdSaget").value;
            maxPs = document.getElementById("maxPs").value;
            maxData = document.getElementById("maxData").value;

            return [popsize, cr, mr, iterasi, thresholdSaget, maxPs,maxData];
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
            getChildCO = -1;
            ofCrossover = Math.round(cr * popsize);
            console.log("Banyak Offspring Crossover = ", ofCrossover);
            childCrossover = new Array(2); //Worked!
            childCrossover[0] = ofCrossover; //Worked!
            childCrossover[1] = maxData; //Worked!
            
            while (ofCrossover - getChildCO != 1) {
                let c = new Array(2); //Worked!
                c[0] = getRandomInt(1, popsize); //misal = 7
                c[1] = getRandomInt(1, popsize);

                let oneCut = getRandomInt(1, maxPs);
                console.log(c[0] + " | " +  c[1] + " | " + oneCut);

                let c1 = ++getChildCO; //misal = 0
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
                    let c2 = ++getChildCO;
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
                    }
                }
            }
        }

        function getConstraint1(array = [], array2 = []) {
            for (let i = 0; i < array.length; i++) {
                array[i] = [];
                for (let j = 0; j < array2.length; j++) {
                    array2[j] = [];
                    if (array[i] == array2[j]) {
                        cons1 = cons1 + 10;
                        // return cons1;
                    }
                }
            }
        }

        function ge2(array = [], array2 = []) {
            for (let i = 0; i < array.length; i++) {
                array[i] = [];
                for (let j = 0; j < array2.length; j++) {
                    array2[j] = [];
                    if (array[i] == array2[j]) {
                        cons2 = cons2 + 20;
                        // return cons2;
                    }
                }
            }
        }

        function getConstraint3(array = [], array2 = []) {
            for (let i = 0; i < array.length; i++) {
                array[i] = [];
                for (let j = 0; j < array2.length; j++) {
                    array2[j] = [];
                    if (array[i] == array2[j]) {
                        cons3 = cons3 + 30;
                        // return cons3;
                    }
                }
            }
        }

        function getConstraint4(array = []) {
            let s2remove =  new Array(array.length);
            for (let i = 0; i < array.length; i++) {
                for (let j = i + 1; j < array.length; j++) {
                    array[i] = [];
                    if (i != j) {
                        if (array[i] == array[j]) {
                            if (array[j] == s2remove[j]) {
                                continue;
                            } else{
                                cons4 = cons4 + 55;
                                s2remove[j] = array[j];
                            }
                        }
                    }
                }
            }
        }

        function getConstraint5(array = [], value = 0) {
            for (let i = 0; i < array.length; i++) {
                if (array[i] == value) {
                    cons5 = cons5 + 60;
                }
            }
        }

        function mutation(){
            let temp = '';
            ofMutasi = Math.round(mr * popsize);
            console.log("Banyak Offspring Mutasi = " + ofMutasi);

            childMutasi = new Array(2);
            childMutasi[0] = ofMutasi;
            childMutasi[1] = maxData;
            
            for (let j = 0; j < ofMutasi; j++) {
                let p = getRandomInt(1, popsize);
                let r1 = getRandomInt(1, maxData);
                let r2 = getRandomInt(1, maxData);
                console.log(p + " | " + r1 + " | " + r2);

                reciprocalExchangeMutation(p, r1, r2, j);
                console.log("Child " + j + " = ");

                let arr = new Array(maxData);
                for (let i = 0; i < maxData; i++) {
                    console.log(childMutasi[j][i] + " ");
                    arr[i] = childMutasi[j][i];
                }
                console.log(arr);
            }
        }

        function reciprocalExchangeMutation(p, r1, r2, j) {
            for (let i = 0; i < maxData; i++) {
                childMutasi[j][i] = data[p][i];
                if (i == r1) {
                    childMutasi[j][i] = data[p][r2];
                    return childMutasi[j][i];
                }
                if (i = r2) {
                    childMutasi[j][i] = data[p][r1];
                    return childMutasi[j][i];
                }
            }
        }

        function getFitness(array = [], size = 0, nama = '') {
            try {
                for (let j = 0; j < size; j++) {
                    console.log(nama + (j+1) + " ");
                    let temp = new Array(maxData);
                    let a = 0;
                    cons1 = 0.0;
                    cons2 = 0.0;
                    cons3 = 0.0;
                    cons4 = 0.0;
                    cons5 = 0.0;

                    array = [j];
                    for (let k = 0; k < maxData; k++) {
                        temp[k] = array[j][k];
                        if (k == 1) {
                            a++;
                            console.log("Hari ke-" + a + " : ");
                            fullJadwal = temp.slice(0,12);

                            jadwal1 = fullJadwal.slice(0,fullJadwal.length / 2);
                            printArray("Jadwal 1", jadwal1);
                            jadwal2 = fullJadwal.slice(fullJadwal.length / 2, fullJadwal.length);
                            printArray("Jadwal 2", jadwal2);

                            getConstraint4(jadwal1);
                            getConstraint4(jadwal2);
                            getConstraint3(jadwal1, jadwal2);
                            if(cHalangan != 0){
                                for (let i = 0; i < cHalangan; i++) {
                                    if (halangan[i][1] == a) {
                                        getConstraint5(fullJadwal, halangan[i][0]);
                                    }                                    
                                }
                            }
                        } else if((k + 1) % 12 == 0){
                            a++;
                            console.log("Hari ke-" + a + " : ");
                            printArray("Jadwal Kemarin", fullJadwal);
                            fullJadwal = temp.slice(k - 11, k + 1);
                            
                            getConstraint1(fullJadwal, jadwal1);
                            getConstraint1(fullJadwal, jadwal2);
                            jadwal1 = fullJadwal.slice(0, fullJadwal.length / 2);
                            printArray("Jadwal 1", jadwal1);
                            jadwal2 = fullJadwal.slice(fullJadwal.length / 2, fullJadwal.length);
                            printArray("Jadwal 2", jadwal2);
                            
                            getConstraint4(jadwal1);
                            getConstraint4(jadwal2);
                            getConstraint3(jadwal1, jadwal2);
                            if (cHalangan != 0) {
                                for (let i = 0; i < cHalangan; i++) {
                                    getConstraint5(fullJadwal, halangan[i][0]);
                                }
                            }
                        }
                    }
                    fitness[count][0] = 1. / (1 + cons1 + cons2 + cons3 + cons4 + cons5);
                    fitness[count][1] = count;
                    fitness[count][2] = cons1;
                    fitness[count][3] = cons2;
                    fitness[count][4] = cons3;
                    fitness[count][5] = cons4;
                    fitness[count][6] = cons5;
                    console.log("Cons1 : " + cons1);
                    console.log("Cons2 : " + cons2);
                    console.log("Cons3 : " + cons3);
                    console.log("Cons4 : " + cons4);
                    console.log("Cons5 : " + cons5);
                    console.log("Nilai fitness : " + fitness[count][0]);
                    count++;
                }
            } catch (error) {
                console.log(error.message);
            }
        }

        function hitungFitness(){
            try {
                count = 0;
                allPop = popsize + ofCrossover + ofMutasi;
                gabungan = new Array(2);
                gabungan[0] = [allPop];
                gabungan[1] = [maxData];
                for (let i = 0; i < allPop; i++) {
                    gabungan = [i];
                    for (let j = 0; j < maxData; j++) {
                        if (i < popsize) {
                            gabungan[i][j] = data[i][j];
                        } else if (i < popsize + ofCrossover){
                            gabungan[i][j] = childCrossover[i - popsize][j];
                        } else if (i < allPop){
                            gabungan[i][j] = childMutasi[i - (popsize + ofCrossover)][j];
                        }
                    }
                }
                fitness = new Array(2);
                fitness[0] = [allPop];
                fitness[1]=  7;

                getFitness(data, popsize, "Parent");
                getFitness(childCrossover, ofCrossover, "Child Crossover");
                getFitness(childMutasi, ofMutasi, "Child Mutasi");
            } catch (error) {
                console.log(error.message);
            }
        }

        function run() {
            getData();
            population();
            crossover();
            mutation();
        }

        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
        
        function printArray(jadwal = '', jadwal12 = []){
            console.log(jadwal);
            console.log(jadwal12.slice);
        }