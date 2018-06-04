<template>
    <div class="content penjualan">
        <div class="container">
            <topbar :title="title"></topbar>
            <loading v-if="loading"></loading>
            <div v-else class="row">
                <div class="col col-12">
                    <div class="main-content row">
                        <div class="col" style="width: 70%;padding-right: 10px">
                            <div class="card row header" style="padding:0px; margin-bottom: 20px">
                                <div class="col col-4" style="padding: 20px">
                                    <span class="label">Nomor Faktur</span>
                                    <span class="value">{{ penjualan.nomor_faktur }}</span>
                                </div>
                                <div class="col col-4" style="padding: 20px; border-left: 1px solid #eaeaea">
                                    <span class="label">Tanggal</span>
                                    <span class="value">{{ penjualan.tanggal | tanggal }}</span>
                                </div>
                                <div class="col col-4" style="padding: 20px; border-left: 1px solid #eaeaea">
                                    <span class="label">Petugas</span>
                                    <span class="value">{{ penjualan.nama_user }}</span>
                                </div>
                            </div>
                            <div class="card">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="nomor">No</th>
                                            <th style="width: 200px;">Produk</th>
                                            <th style="width: 50px;text-align: center;">Kuantitas</th>
                                            <th style="width: 100px">Harga</th>
                                            <th style="width: 120px">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in detailPenjualan" :key="index">
                                            <td class="nomor">{{ 1 + index }}</td>
                                            <td style="min-width: 150px;"><a style="font-weight: 500">{{ item.nama_produk }}</a><span>{{ item.kode_produk}}</span></td>
                                            <td style="width: 50px;text-align: center;">{{ item.kuantitas }}</td>
                                            <td>{{ item.harga_satuan | rupiah }}</td>
                                            <td>{{ item.kuantitas * item.harga_satuan | rupiah }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col col-4" style="width: 30%;padding-left: 10px">
                            <div class="card right">
                                <div class="total">
                                    <span class="label">Total</span>
                                    <span class="value">{{ penjualan.total | rupiah }}</span>
                                </div>
                                <div class="bayar detail">
                                    <span class="label">Bayar</span>
                                    <span class="value">{{ penjualan.jumlah_bayar | rupiah }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <flash></flash>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        data() {
            return {
                title: 'Transaksi Penjualan'
            }
        },
        mounted() {
            this.$store.dispatch('penjualan_store/fetchDetailPenjualan', this.$route.params.nomor_faktur)
        },
        computed: {
            ...mapState('penjualan_store', {
                penjualan: state => state.penjualan,
                detailPenjualan: state => state.detailPenjualan,
                loading: state => state.loading
            })
        }
    }
</script>

<style lang="scss" scoped>
    input.has-error, input.has-error:focus {
        border-color:#ff4949;
    }
    .content.penjualan {
        margin-left: 280px;
        padding: 0 70px;
    }
</style>
