<template>
  <div aria-hidden="true" class="modal fade delete" id="deleteModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="icon icon-hapus"></i>
                    <span class="modal-title">Hapus Produk</span>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan menghapus<br>
                    <span v-if="selected.length > 1">{{ selected.length }} produk ini?</span>
                    <span v-if="selected.length == 1">{{ selected[0].nama_produk }}?</span>
                </div>
                <div class="modal-footer">
                    <button class="button" type="submit" @click="destroy">Hapus</button>
                    <span class="cancel" data-dismiss="modal">Batal</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        methods: {
            destroy() {
                let countPersediaan = 0, countPenjualan = 0, countPembelian = 0
                for(var i = 0; i < this.selected.length; i++) {
                    countPersediaan += this.selected[i].jumlah_persediaan
                    countPenjualan += this.selected[i].jumlah_penjualan
                    countPembelian += this.selected[i].jumlah_pembelian
                }
                if(countPersediaan > 0 || countPenjualan > 0 || countPembelian > 0) {
                    $("#deleteModal").modal('hide')
                    flash('gagal menghapus produk', 'error')
                    if(countPersediaan > 0) {
                        flash('produk yang akan anda hapus memiliki persediaan', 'error')
                    }
                    if(countPenjualan > 0) {
                        flash('produk yang akan anda hapus memiliki transaksi penjualan', 'error')
                    }
                    if(countPembelian > 0) {
                        flash('produk yang akan anda hapus memiliki transaksi pembelian', 'error')
                    }
                }else{
                    this.$store.dispatch('jenis_produk_store/destroy', {selected: this.selected, perPage: this.perPage})
                }
            }
        },
        computed: {
            ...mapState('produk_store' ,{
                selected: state => state.selected,
                perPage: state => state.perPage,
            }),
        }
    }
</script>