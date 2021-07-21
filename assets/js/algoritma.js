        let data = [];
        let childMutasi = [];
        let childCrossover = [];
        let gabungan = [];
        let newFitness = [];
        let fitness = [];
        let fitnessSaget = 0.0;
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
            popsize = document.getElementById("popsize").value  * 1;
            cr = document.getElementById("cr").value * 1;
            mr = document.getElementById("mr").value * 1;
            iterasi = document.getElementById("iterasi").value * 1;
            thresholdSaget = document.getElementById("thresholdSaget").value * 1;
            maxPs = document.getElementById("maxPs").value * 1;
            maxData = document.getElementById("maxData").value * 1;

            return [popsize, cr, mr, iterasi, thresholdSaget, maxPs,maxData];
        }

        function population() {
            for (let i = 0; i < popsize; i++) {
                data[i] = [];
                let arr = [];
                for (let j = 0; j < maxData; j++) {
                    let n = getRandomInt(1, maxPs);
                    data[i][j] = n;
                    arr[j] = data[i][j];
                }
                arr2 = arr.toString();
                console.log(i+1, arr2);
            }
        }

        function crossover() {
            let temp = '';
            getChildCO = -1;
            ofCrossover = Math.round(cr * popsize);
            console.log("Banyak Offspring Crossover = ", ofCrossover);
            
            while (ofCrossover - getChildCO != 1) {
                let c = [];
                c[0] = getRandomInt(1, popsize);
                c[1] = getRandomInt(1, popsize);

                let oneCut = getRandomInt(1, maxPs);
                console.log(c[0] , " | " ,  c[1] , " | " , oneCut);

                let c1 = ++getChildCO; 
                console.log(c1, getChildCO);

                
                if (ofCrossover - getChildCO == 1) {
                    childCrossover[c1] = [];
                    for (let i = 0; i < maxData; i++) {
                        childCrossover[c1][i] = data[c[0]-1][i];
                    }
                    for (let i = oneCut, j = 0; j < maxData - oneCut; j++, i++) {
                        childCrossover[c1][i] = data[c[1]-1][i];
                    }
                    let temp2 = [];
                    for (let i = 0; i < maxData; i++) {
                        temp2[i] = childCrossover[c1][i];
                    }
                    temp = temp2.toString();
                    console.log("Child CO" , c1+1 , " = ", c[0], " x " , c[1]," => " , temp);
                } else {
                    let c2 = getChildCO;
                    childCrossover[c1] = [];
                    childCrossover[c2] = [];
                    for (let i = 0; i < maxData; i++) {
                        childCrossover[c1][i] = data[c[0]-1][i];
                    }
                    for (let i = 0; i < maxData; i++) {
                        childCrossover[c2][i] = data[c[1]-1][i];
                    }
                    for (let i = oneCut, j = 0; j < maxData - oneCut; j++, i++) {
                        childCrossover[c2][i] = data[c[0]-1][i];
                    }
                    for (let i = oneCut, j = 0; j < maxData - oneCut; j++, i++) {
                        childCrossover[c1][i] = data[c[1]-1][i];
                    }
                    let temp2 = [];
                    for (let i = c1; i <= c2; i++) {
                        for (let j = 0; j < maxData; j++) {
                            temp2[j] = childCrossover[i][j];
                        }
                    }
                    temp = temp2.toString();
                    console.log("Child CO" , c1+1 , " = ", c[0], " x " , c[1]," => " , temp);
                }
            }
        }

        function getConstraint1(array = [], array2 = []) {
            for (let i = 0; i < array.length; i++) {
                for (let j = 0; j < array2.length; j++) {
                    if (array[i] == array2[j]) {
                        cons1 = cons1 + 10;
                        return cons1;
                    }
                }
            }
        }

        function ge2(array = [], array2 = []) {
            for (let i = 0; i < array.length; i++) {
                for (let j = 0; j < array2.length; j++) {
                    if (array[i] == array2[j]) {
                        cons2 = cons2 + 20;
                        return cons2;
                    }
                }
            }
        }

        function getConstraint3(array = [], array2 = []) {
            for (let i = 0; i < array.length; i++) {
                for (let j = 0; j < array2.length; j++) {
                    if (array[i] == array2[j]) {
                        cons3 = cons3 + 30;
                        return cons3;
                    }
                }
            }
        }

        function getConstraint4(array = []) {
            let s2remove =  [];
            s2remove = [array.length];
            for (let i = 0; i < array.length; i++) {
                for (let j = i + 1; j < array.length; j++) {
                    if (i != j) {
                        if (array[i] == array[j]) {
                            if (array[j] == s2remove[j]) {
                                continue;
                            } else{
                                cons4 = cons4 + 55;
                                s2remove[j] = array[j];
                                return cons4;
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
                    return cons5;
                }
            }
        }

        function mutation(){
            let temp = '';
            ofMutasi = Math.round(mr * popsize);
            console.log("Banyak Offspring Mutasi = ", ofMutasi);

            for (let j = 0; j < ofMutasi; j++) {
                let p = getRandomInt(1, popsize);
                let r1 = getRandomInt(1, maxData);
                let r2 = getRandomInt(1, maxData);
                console.log(p , " | " , r1 , " | " , r2);

                reciprocalExchangeMutation(p, r1, r2, j);
                
                let arr = [];
                for (let i = 0; i < maxData; i++) {
                    arr[i] = childMutasi[j][i];
                }
                temp = arr.toString();
                console.log("Child M" , j+1 , " = ", ofCrossover + j + 1, " x ", p, " => ", temp);
            }
        }

        function reciprocalExchangeMutation(p = 0, r1 = 0, r2 = 0, j = 0) {
            childMutasi[j] = [];
            for (let i = 0; i < maxData; i++) {
                childMutasi[j][i] = data[p-1][i];
                if (i == r1) {
                    childMutasi[j][i] = data[p-1][r2];
                }
                if (i == r2) {
                    childMutasi[j][i] = data[p-1][r1];
                }
            }
        }

        function getFitness(array = [], size = 0, nama = '') {
            try {
                for (let j = 0; j < size; j++) {
                    console.log(nama , (j+1));
                    let temp = [];
                    let a = 0;
                    cons1 = 0.0;
                    cons2 = 0.0;
                    cons3 = 0.0;
                    cons4 = 0.0;
                    cons5 = 0.0;

                    for (let k = 0; k < maxData; k++) {
                        temp[k] = array[j][k];
                        if (k == 11) {
                            a++;
                            console.log("Hari ke-", a, " : ");
                            fullJadwal = temp.slice(0,12);

                            jadwal1 = fullJadwal.slice(0, fullJadwal.length / 2);
                            printArray("Jadwal 1", jadwal1);
                            jadwal2 = fullJadwal.slice(fullJadwal.length / 2, fullJadwal.length);
                            printArray("Jadwal 2", jadwal2);

                            getConstraint4(jadwal1);
                            getConstraint4(jadwal2);
                            getConstraint3(jadwal1, jadwal2);
                            if(cHalangan != 0){
                                for (let i = 0; i < cHalangan; i++) {
                                    halangan[i] = [];
                                    if (halangan[i][1] == a) {
                                        getConstraint5(fullJadwal, halangan[i][0]);
                                    }                                    
                                }
                            }
                        } else if ((k + 1) % 12 == 0) {
                            a++;
                            console.log("Hari ke-" , a , " : ");
                            fullJadwal = temp.slice(k - 11, k + 1);
                            printArray("Jadwal Kemarin", fullJadwal);
                            
                            jadwal1 = fullJadwal.slice(0, fullJadwal.length / 2);
                            printArray("Jadwal 1", jadwal1);
                            jadwal2 = fullJadwal.slice(fullJadwal.length / 2, fullJadwal.length);
                            printArray("Jadwal 2", jadwal2);

                            getConstraint1(fullJadwal, jadwal1);
                            getConstraint1(fullJadwal, jadwal2);
                            getConstraint4(jadwal1);
                            getConstraint4(jadwal2);
                            getConstraint3(jadwal1, jadwal2);
                            if (cHalangan != 0) {
                                for (let i = 0; i < cHalangan; i++) {
                                    halangan[i] = [];
                                    if (halangan[i][1] == a) {
                                        getConstraint5(fullJadwal, halangan[i][0]);
                                    }
                                }
                            }
                        }
                    }
                    count = 0;
                    fitness[count] = [];
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
            }
            catch (error) {
                console.log(error.message);
            }
        }

        function hitungFitness(){
            try {
                count = 0;
                allPop = popsize + ofCrossover + ofMutasi;
                for (let i = 0; i < allPop; i++) {
                    gabungan[i] = [];
                    for (let j = 0; j < maxData; j++) {
                        if (i < popsize) {
                            gabungan[i][j] = data[i][j];
                        } else if (i < popsize + ofCrossover) {
                            gabungan[i][j] = childCrossover[i - popsize][j];
                        } else if (i < allPop) {
                            gabungan[i][j] = childMutasi[i - (popsize + ofCrossover)][j];
                        }
                    }
                }
                getFitness(data, popsize, "Parent");
                getFitness(childCrossover, ofCrossover, "Child Crossover");
                getFitness(childMutasi, ofMutasi, "Child Mutasi");
            } catch (error) {
                console.error(error);
            }
        }

        function seleksiElitism(){
            console.log("Gabungan Parent dan Child : ");
            console.log(fitness);

            for (let i = 0; i < allPop; i++) {
                newFitness[i] = [];
                for (let j = 0; j < 2; j++) {
                    newFitness[i][j] = fitness[i][j];
                }
                console.log(newFitness[i][0] + " || " + newFitness[i][1]);
                let temp = newFitness[i][1];
                let int_allpop = parseInt(temp) ;
                console.log(int_allpop, newFitness[i][0]);
            }
            for (let i = 0; i < allPop; i++) {
                newFitness[i] = []
                for (let j = 1; j < allPop; j++) {
                    if (newFitness[j - 1][0] <= newFitness[j][0]) {
                        let temp = newFitness[j - 1][0];
                        let temp2 = newFitness[j - 1][1];
                        newFitness[j - 1][0] = newFitness[j][0];
                        newFitness[j - 1][1] = newFitness[j][1];
                        newFitness[j][0] = temp;
                        newFitness[j][1] = temp2;
                    }
                }
                
            }
            console.log("Order Fitness : ");
            for (let i = 0; i < allPop; i++) {
                let temp = newFitness[i][1];
                let int_allpop = parseInt(temp);
                console.log(newFitness[i][0] + " | " + newFitness[i][1] + " | ");
                for (let j = 0; j < maxData; j++) {
                    console.log(gabungan[int_allpop][j] + ", ");
                }
            }
            fitnessSaget = newFitness[0][0];
            let indter = newFitness[0][1];
            individuTerbaik = parseInt(indter);
            let arr = [];
            let temp2 = "";
            for (let i = 0; i < 1; i++) {
                let temp = newFitness[i][1];
                let int_allpop = parseInt(temp);
                for (let j = 0; j < maxData; j++) {
                    arr[j] = gabungan[int_allpop][j];
                }
            }
            temp2 = Array.toString(arr);
            jadwalTerbaik = temp2;
        }

        function run() {
            getData();
            population();
            iteration();
        }

        function iteration(){
            let i = 0;
            setTimeout(function() {
                crossover();
                mutation();
                hitungFitness();
                // seleksiElitism();
                // console.log(i+1, individuTerbaik + 1, fitnessSaget, jadwalTerbaik);
                if (fitnessSaget >= thresholdSaget) {
                    console.log("Berhenti di iterasi ke : " + (i));
                    i = iterasi;
                }
            i++;                    
            if (i <= iterasi) {      
                iteration();             
            }                    
            }, 2000) //satuan ms, misal 1000ms = 1 detik
        }

        function getRandomInt(min = 0, max = 0) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
        
        function printArray(jadwal = '', jadwalarr = []){
            console.log(jadwal, " => ", jadwalarr.slice().toString());
        }