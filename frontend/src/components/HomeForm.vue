<template>
    <div class="container">
        <div class="row">
            <div v-if="dataReady">
                <div class="row">
                    <div class="col-sm-6 py-2">
                        <select ref="symbolFrom" @change="onSelectChange()" class="form-select" size="5"
                            v-model="symbolFrom">
                            <option disabled value="">From?</option>
                            <option v-for="symbol in symbols" :key="symbol" :value="symbol.short">
                                {{ symbol.short }} {{ symbol.long }}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-6 py-2">
                        <select ref="symbolTo" @change="onSelectChange()" class="form-select" size="5"
                            v-model="symbolTo">
                            <option disabled value="">To?</option>
                            <option v-for="symbol in symbols" :key="symbol" :value="symbol.short">
                                {{ symbol.short }} {{ symbol.long }}
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
                            <input @input="onInputChange($event)" class="form-control" type="number" min="0">
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
            result: 0,

            error: '',
        };
    },
    mounted() {
        UserService.getCurrencySymbols().then(
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
    },
    methods: {
        async onSelectChange() {
            this.error = '';
            this.result = 0;

            const symbolFrom = this.$refs.symbolFrom.value;
            const symbolTo = this.$refs.symbolTo.value;

            if (symbolFrom == symbolTo) {
                this.error = 'Choose different currency symbol!';
                return;
            }

            if (symbolFrom && symbolTo) {
                this.loadingRate = true;
                let savedFrom = this.savedRates[symbolFrom]

                if (!savedFrom) {
                    savedFrom = {};
                }

                if (!savedFrom[symbolTo]) {
                    const response = await UserService.getCurrencyRate(symbolFrom, symbolTo);

                    if (response.status != 200) {
                        this.error = response.data.message;
                        this.currentRate = 0;

                        return;
                    }

                    savedFrom[symbolTo] = response.data.info.rate;
                }

                this.savedRates[symbolFrom] = savedFrom;
                this.currentRate = savedFrom[symbolTo];
                this.loadingRate = false;
            }
        },
        onInputChange(event) {
            const value = event.target.value;

            if (!isNaN(value) && value > 0 && this.currentRate != 0) {
                this.result = Math.round((value * this.currentRate) * 1000) / 1000;
            }
        }
    }
}

</script>