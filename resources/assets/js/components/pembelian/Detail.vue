<template>
    <div class="content pembelian">
        <div class="container">
            <topbar :title="title"></topbar>
            <loading v-if="loading"></loading>
            <div v-else class="row">
                <div class="col col-11">
                    <div class="card custom detail">
                        <div style="display:flex; justify-content: space-between">
                            <span class="title" style="margin-bottom: 20px;display: block;">Nomor Faktur: {{ pembelian.nomor_faktur }} ({{ pembelian.detail_pembelian_count }})</span>
                            <i class="icon-cetak success"></i>
                        </div>
                        <div class="row">
                            <div class="col col-5" style="padding-right: 10px">
                                <span>Nama Vendor</span>
                                <span class="value">{{ pembelian.nama_vendor }}</span>
                            </div>
                            <div class="col col-4" style="padding: 0px 10px">
                                <span>Tanggal Pembelian</span>
                                <span class="value">{{ pembelian.tanggal }}</span>
                            </div>
                            <div class="col col-3" style="padding-left: 10px">
                                <span>Petugas</span>
                                <span class="value">{{ pembelian.nama_user }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="padding: 25px 40px 40px">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="">Produk</th>
                                    <th style="width: 70px">Kuantitas</th>
                                    <th style="width: 175px">Harga</th>
                                    <th style="width: 175px">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in detailPembelian" :key="item.id">
                                    <td class="nomor" style="text-align:center">{{ 1 + index }}</td>
                                    <td style="min-width: 150px;"><a>{{ item.nama_produk }}</a><span>{{ item.kode_produk }}</span></td>
                                    <td>{{ item.kuantitas }}</td>
                                    <td>{{ item.harga_satuan | rupiah }}</td>
                                    <td>{{ item.kuantitas * item.harga_satuan | rupiah }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="footer">
                            <div class="left">
                                <span>Total</span>
                                <div class="total">{{ getTotal | rupiah }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                title: 'Transaksi Pembelian',
            }
        },
        mounted() {
            this.$store.dispatch('pembelian_store/fetchDetailPembelian', this.$route.params.nomor_faktur)
        },
        computed: {
            ...mapState('pembelian_store', {
                pembelian: state => state.pembelian,
                detailPembelian: state => state.detailPembelian,
                loading: state => state.loading
            }),
            ...mapGetters('pembelian_store', [
                'getTotal'
            ])
        }
    }
</script>

<style lang="scss" scoped>
    .input.disabled {
        background: #ddd;
    }

    .footer {
        padding-top:10px;

        button[type="submit"] {
            margin: 0px 12px;
        }

        .button-icon {
            background: #13ce66;
            color: #fff;
            box-shadow: 0px 5px 5px 0 rgba(0, 0, 0, 0.15)
        }

        .cancel {
            color: #465368;
            font-weight: 500;
            opacity: 0.7;
        }

        .left {
            margin-right: 10px;

            span {
                opacity: 0.7;
                font-weight: 500 !important;
                font-size: 14px !important;
            }

            .total {
                font-weight: 500;
                font-size: 28px;
                color: #13ce66;
                margin-top: 5px;
            }
        }
    }
    .pembelian {
        .detail {
            .value {
                display: block;
                font-size: 18px;
                font-weight: 500;
                margin-top: 13px;
            }
        }
    }
</style>