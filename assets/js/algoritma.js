class algoritma {
    constructor(popsize, cr, mr, iterasi, thresholdSaget, maxPs)
    {
        this.popsize = popsize = 10;
        this.cr = cr;
        this.mr = mr;
        this.iterasi = iterasi;
        this.thresholdSaget = thresholdSaget;
        this.maxPs = maxPs;
    }

    createPopulation() {
        for (let i = 0; i < this.popsize; i++) {
            console.log(i);
        }
    }
}