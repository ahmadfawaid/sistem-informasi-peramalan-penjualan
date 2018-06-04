<template>
    <div aria-hidden="true" class="modal fade forecast" id="detailModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <span class="modal-title">Detail Hasil Peramalan</span>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col col-8">
                                <div class="group">
                                    <label>Produk yang diramal</label>
                                    <span>{{ selectedProduk.nama_produk }}</span>
                                </div>
                            </div>
                            <div class="col col-4">
                                <div class="group">
                                    <label>Beta terpilih</label>
                                    <span class="success">{{ peramalan.beta }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-6">
                                <div class="group">
                                    <label>Keakuratan peramalan</label>
                                    <span class="success">{{ keakuratan }}%</span>
                                </div>
                            </div>
                            <div class="col col-6">
                                <div class="group">
                                    <label>Kesalahan peramalan (MAPE)</label>
                                    <span class="error">{{ kesalahan }}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="group" style="margin-bottom: 0px;">
                            <label>Peramalan penjualan periode berikutnya</label>
                            <span v-if="selectedProduk.satuan_pembelian.satuan == 'Box'">{{ ramalan }} {{ selectedProduk.satuan_penjualan.satuan.toLowerCase() }} atau sekitar {{ ramalanFixed }} {{ selectedProduk.satuan_pembelian.satuan.toLowerCase() }}</span>
                            <span v-else>{{ ramalan }} {{ selectedProduk.satuan_pembelian.satuan.toLowerCase() }}</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        computed: {
            ...mapState('peramalan_store', {
                peramalan: state => state.peramalan,
                selectedProduk: state => state.selectedProduk
            }),
            keakuratan() {
                return 100 - this.peramalan.mape.toFixed(5)
            },
            kesalahan() {
                return this.peramalan.mape.toFixed(5)
            },
            ramalan() {
                return this.peramalan.hasil[this.peramalan.hasil.length - 1].peramalan.toFixed(0)
            },
            ramalanFixed() {
                let value = this.peramalan.hasil[this.peramalan.hasil.length - 1].peramalan / this.selectedProduk.isi
                return value.toFixed(0)
            }
        },
    }
</script>