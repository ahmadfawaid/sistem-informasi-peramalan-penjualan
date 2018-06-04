<template>
    <div class="content dashboard">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="top-content">
                        <div class="row">
                            <div class="col col-4" style="padding: 20px 10px;">
                                <span class="title">{{ time }}</span>
                                <span class="name">{{ nama }}</span>
                            </div>
                            <div class="col col-4">
                                <div class="card">
                                    <div class="subtitle">Penjualan bulan ini</div>
                                    <div class="total"><i class="icon-grafik sales"></i><div class="text"><strong>Rp.</strong> {{ chart.penjualan[chart.penjualan.length - 1] | rupiahDash }}</div></div>
                                </div>
                            </div>
                            <div class="col col-4">
                                <div class="card">
                                    <div class="subtitle">Persediaan saat ini</div>
                                    <div class="total"><i class="icon-persediaan stock"></i><div class="text"><strong>{{ persediaan.produk }}</strong> item <strong>{{ persediaan.total | thousandSuffix }}</strong> pcs</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <loading v-if="loading"></loading>
                    <div v-if="loading" style="display:block;width:100%;height:100px;margin: 100px 0"></div>
                    <div v-if="loaded" class="graph">
                        <h3 class="title">Grafik Penjualan</h3>
                        <span class="subtitle">Periode Maret 2017 - Februari 2018</span>
                        <line-chart 
                            :chart-data="chart.penjualan" 
                            :chart-labels="chart.periode">
                        </line-chart>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import LineChart from './Chart.js'

    export default {
        data() {
            return {
                title: 'Dashboard',
                nama: $('meta[name="user-nama"]').attr('content')
            }
        },
        mounted() {
            this.$store.commit('dashboard_store/setLoaded', false)
            this.$store.dispatch('dashboard_store/fetchTotalPersediaan')
            this.$store.dispatch('dashboard_store/fetchPenjualan')
        },
        methods: {
        },
        computed: {
            ...mapState('dashboard_store', {
                chart: state => state.chart,
                persediaan: state => state.persediaan,
                loaded: state => state.loaded,
                loading: state => state.loading
            }),
            time() {
                let hour = new Date().getHours()
                if (hour >= 0 && hour <= 11) {
                    return "Selamat Pagi,"
                } else if (hour > 11 && hour <= 14) {
                    return "Selamat Siang,"
                } else if (hour > 14 && hour <= 17) {
                    return "Selamat Sore,"
                } else if (hour > 17 && hour <= 23) {
                    return "Selamat Malam,"
                }
            }
        },
        components: {
            'line-chart': LineChart,
        }
    }
</script>
