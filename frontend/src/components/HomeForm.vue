<template>
    <div class="container">
        <div class="row">
            <div v-if="dataReady">
                <div class="row">
                    <div class="col-sm-6 py-2">
                        <select @change="onSelectChange()" class="form-select" size="5" v-model="symbolFrom"
                            id="symbolFrom">
                            <option disabled value="">From?</option>
                            <option v-for="symbol in symbols" :key="symbol" :value="symbol.short">
                                {{ symbol.long }}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-6 py-2">
                        <select @change="onSelectChange()" class="form-select" size="5" v-model="symbolTo"
                            id="symbolTo">
                            <option disabled value="">To?</option>
                            <option v-for="symbol in symbols" :key="symbol" :value="symbol.short">
                                {{ symbol.long }}
                            </option>
                        </select>
                    </div>
                </div>
                <div v-if="error != ''" class="pt-2 text-danger">
                    <p>{{ error }}</p>
                </div>
                <div v-else-if="symbolFrom == '' || symbolTo == ''" class="pt-2">
                    <p>Please choose currencies</p>
                </div>
                <div v-else-if="loadingRate" class="pt-2 text-center">
                    <div class="loading"></div>
                </div>
                <div v-else>
                    <div class="row pt-2 text-center">
                        <p>Rate: {{ currentRate }}</p>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 py-2">
                            <input v-model="inputData" @input="onInputChange($event)" class="form-control" type="number"
                                min="0">
                        </div>
                        <div class="col-sm-6 py-2 text-center">
                            <p>{{ result }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-center">
                <div class="loading"></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <form action="/logout" method="get">
                    <button class="btn btn-dark">Logout?</button>
                </form>
            </div>
            <div class="col-6 text-end">
                <p>Created by Yovan Mestre</p>
            </div>
        </div>
    </div>
</template>

<script>

import UserService from './../services/user.service';

import TomSelect from 'tom-select';

export default {
    name: 'HomeComponent',
    data() {
        return {
            dataReady: false,
            symbols: [],

            symbolFrom: '',
            symbolTo: '',

            savedRates: {},
            currentRate: 0,
            loadingRate: false,

            inputData: '',
            result: '...',

            error: '',
        };
    },
    async mounted() {
        await UserService.getCurrencySymbols().then(
            (response) => {
                this.error = '';
                this.dataReady = true;

                for (const symbol in response.data.symbols) {
                    this.symbols.push({
                        short: symbol,
                        long: response.data.symbols[symbol].description,
                    })
                }
            },
            (error) => {
                this.error = error.response.data.message;
            }
        );

        const settings = {
            hideSelected: true,
        };

        new TomSelect('#symbolFrom', settings);
        new TomSelect('#symbolTo', settings);
    },
    methods: {
        async onSelectChange() {
            this.error = '';
            this.result = '...';

            if (this.symbolFrom == this.symbolTo) {
                this.error = 'Choose different currency symbol!';
                return;
            }

            if (this.symbolFrom && this.symbolTo) {
                this.loadingRate = true;
                let savedFrom = this.savedRates[this.symbolFrom]

                if (!savedFrom) {
                    savedFrom = {};
                }

                if (!savedFrom[this.symbolTo]) {
                    const response = await UserService.getCurrencyRate(this.symbolFrom, this.symbolTo);

                    if (response.status != 200) {
                        this.error = response.data.message;
                        this.currentRate = 0;

                        return;
                    }

                    savedFrom[this.symbolTo] = response.data.info.rate;
                }

                this.savedRates[this.symbolFrom] = savedFrom;
                this.currentRate = savedFrom[this.symbolTo];
                this.loadingRate = false;
                this.onInputChange();
            }
        },
        onInputChange() {
            this.result = '...';

            if (!isNaN(this.inputData) && this.inputData > 0 && this.currentRate != 0) {
                this.result = Math.round((this.inputData * this.currentRate) * 1000) / 1000;
            } else {
                this.result = '...';
            }
        },
    }
}

</script>