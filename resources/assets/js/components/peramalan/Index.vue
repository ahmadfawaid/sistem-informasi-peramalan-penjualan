<template>
    <div class="content forecast">
        <div class="container">
            <topbar :title="title"></topbar>
            <div class="row" style="margin-top: 10px;">
                <div class="col col-11">
                    <div class="card">
                        <div class="row">
                            <div class="col col-4" style="padding-right: 12px">
                                <div class="form-group">
                                    <div class="label">Pilih Produk</div>
                                    <search-select v-model="form.produk_id" :options="produk" placeholder="Pilih Produk"></search-select>
                                    <span v-if="errors.produk_id" class="help error">{{ errors.produk_id }}</span>
                                </div>
                            </div>
                            <div class="col col-4" style="padding: 0px 12px">
                                <div class="form-group">
                                    <div class="label">Periode Awal</div>
                                    <input v-model="form.from" type="month" class="input">
                                </div>
                            </div>
                            <div class="col col-4" style="padding-left: 12px">
                                <div class="form-group">
                                    <div class="label">Periode Akhir</div>
                                    <input v-model="form.to" type="month" class="input" readonly>
                                </div>
                            </div>
                            <button type="button" class="button" @click="forecast()">Hitung Peramalan</button>
                        </div>
                    </div>
                    <loading v-if="loading"></loading>
                    <div v-else class="forecast-content">
                        <div v-if="peramalan.length != 0" class="card">
                            <div class="title">
                                <h3>Grafik Perhitungan Peramalan <span>beta: {{ peramalan.beta }}</span></h3>
                                <div class="label">
                                    <div class="aktual"><i class="bg-primary"></i>Aktual</div>
                                    <div class="peramalan"><i class="bg-success"></i>Peramalan</div>
                                </div>
                            </div>
                            <line-chart 
                                :chart-actual="chart.aktual" 
                                :chart-forecast="chart.peramalan"
                                :chart-labels="chart.periode">
                            </line-chart>
                        </div>
                        <div v-if="peramalan.length != 0" class="card">
                            <div class="title" style="margin-bottom: 10px">
                                <h3>Detail Perhitungan Peramalan <span>beta: {{ peramalan.beta }}</span></h3>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Periode</th>
                                        <th>Penjualan</th>
                                        <th>Peramalan</th>
                                        <th>e</th>
                                        <th>E</th>
                                        <th>AE</th>
                                        <th>alpha</th>
                                        <th>PE(%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in peramalan.hasil" :key="index">
                                        <td class="text-center">{{ 1 + index }}</td>
                                        <td>{{ item.periode | tanggal }}</td>
                                        <td>{{ item.aktual }}</td>
                                        <td v-if="(index + 1) == peramalan.hasil.length" class="success" style="font-weight: 500; cursor: pointer;" @click="openModal('detail')">{{ item.peramalan | toFixed }}</td>
                                        <td v-else>{{ item.peramalan | toFixed }}</td>
                                        <td>{{ item.galat | toFixed  }}</td>
                                        <td>{{ item.galat_pemulusan | toFixed  }}</td>
                                        <td>{{ item.galat_pemulusan_absolut | toFixed  }}</td>
                                        <td>{{ item.alpha | toFixed }}</td>
                                        <td v-if="(index > 0 && index < peramalan.hasil.length - 1) && item.percentage_error <= 10" class="success">{{ item.percentage_error | toFixed }}%</td>
                                        <td v-else-if="(index > 0 && index < peramalan.hasil.length - 1) && item.percentage_error > 10 && item.percentage_error <= 20" class="primary">{{ item.percentage_error | toFixed }}%</td>
                                        <td v-else-if="(index > 0 && index < peramalan.hasil.length - 1) && item.percentage_error > 20 && item.percentage_error <= 30" class="warning">{{ item.percentage_error | toFixed }}%</td>
                                        <td v-else-if="item.percentage_error > 30" class="error">{{ item.percentage_error | toFixed }}%</td>
                                        <td v-else>{{ item.percentage_error | toFixed }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                            <span style="display: block;font-size: 13px;margin: 20px 15px 0px;opacity: 0.7">Klik hasil peramalan pada bulan {{ peramalan.hasil[peramalan.hasil.length - 1].periode | tanggal}} untuk detail informasi</span>
                        </div>
                        <div v-if="peramalan.length != 0" class="card">
                            <div class="progress">
                                <div>
                                    <vue-circle
                                        :progress="keakuratan"
                                        :size="80"
                                        :reverse="false"
                                        :fill="successColor"
                                        empty-fill="rgba(0, 0, 0, .1)"
                                        :animation-start-value="0.0"
                                        :start-angle="0"
                                        insert-mode="append"
                                        :thickness="7"
                                        :show-percent="true">
                                    </vue-circle>
                                    <div class="text">
                                        <span>Persentase</span>
                                        <h5>Keakuratan Peramalan</h5>
                                    </div>
                                </div>
                                <div>
                                    <vue-circle
                                        :progress="kesalahan"
                                        :size="80"
                                        :reverse="false"
                                        :fill="errorColor"
                                        empty-fill="rgba(0, 0, 0, .1)"
                                        :animation-start-value="0.0"
                                        :start-angle="0"
                                        insert-mode="append"
                                        :thickness="7"
                                        :show-percent="true">
                                    </vue-circle>
                                    <div class="text">
                                        <span>Persentase</span>
                                        <h5>Kesalahan Peramalan</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <detail v-if="peramalan.length != 0"></detail>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import { ModelSelect } from 'vue-search-select'
    import LineChart from './Chart.js'
    import VueCircle from 'vue2-circle-progress'
    import DetailModal from './Detail'

    export default {
        data() {
            return {
                title: 'Perhitungan Peramalan',
                form: {
                    produk_id: '',
                    from: '',
                    to: ''
                },
                errors: {
                    produk_id: ''
                },
                successColor: { color: '#13ce66' },
                errorColor: { color: '#ff4949' },
            }
        },
        mounted() {
            this.$store.dispatch('peramalan_store/fetchProduk')
            this.getDate()
        },
        methods: {
            forecast() {
                if(this.form.produk_id == ''){
                    this.errors.produk_id = 'pilih produk yang akan dilakukan peramalan'
                } else {
                    this.$store.dispatch('peramalan_store/forecast', this.form)
                }
            },
            getDate() {
                // var date = new Date()
                // var month = date.getMonth() - 1
                // var year = date.getFullYear()

                // if (month < 10) month = "0" + month
                // this.form.to = year + '-' + month

                this.form.from = '2017-01'
                this.form.to = '2018-02'
            },
            openModal(modal) {
                $("#" + modal + "Modal").modal('show')
            }
        },
        computed: {
            ...mapState('peramalan_store', {
                peramalan: state => state.peramalan,
                chart: state => state.chart,
                produk: state => state.produk,
                loading: state => state.loading,
            }),
            keakuratan() {
                return 100 - parseInt(this.peramalan.mape)
            },
            kesalahan() {
                return parseInt(this.peramalan.mape)
            }
        },
        watch: {
            'form.produk_id': function(oldVal) {
                if(oldVal !== '') {
                    this.errors.produk_id = ''
                }else if(oldVal == '') {
                    this.errors.produk_id = 'pilih produk yang akan dilakukan peramalan'
                }
            },
        },
        components: {
            'search-select': ModelSelect,
            'line-chart': LineChart,
            'vue-circle': VueCircle,
            'detail': DetailModal
        }
    }
</script>

<style lang="scss">
    .content.forecast{
        .lds-ellipsis {
            margin-top:100px; 
        }

        .card {
            margin-bottom: 20px;
        }

        .forecast-content .title {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;

            h3 {
                margin: 0px;
                font-size: 20px;
                line-height: 28px;
                display: flex;
            }

            span {
                background: #13ce66;
                color: #fff;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 500;
                height: 28px;
                line-height: 28px;
                padding: 0px 14px;
                margin-left: 10px;
            }

            .label {
                display: flex;
            }

            .label > div {
                line-height: 24px;
                display: flex;
                margin-left: 20px;
            }

            .label i {
                width: 12px;
                height: 12px;
                margin: 8px 6px 8px 0px;
                border-radius: 4px;
            }
        }
    }

    .progress {
        display: flex;
        flex-direction: row;
        justify-content: space-around;

        .text {
            float: right;
            display: flex;
            flex-direction: column;
            height: 46px;
            padding: 19px 0px 19px 20px;

            h5 {
                font-size: 18px;
                margin: 6px 0px 0px;
            }
        }
    }
    .circle {
        transform: rotate(-90deg);

        .percent-text {
            transform: rotate(90deg);
        }
    }
</style>
