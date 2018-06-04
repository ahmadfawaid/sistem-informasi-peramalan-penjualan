<template>
  <div aria-hidden="true" class="modal fade delete" id="deleteModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="icon icon-hapus"></i>
                    <span class="modal-title">Hapus Vendor</span>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan menghapus<br>
                    <span v-if="selected.length > 1">{{ selected.length }} vendor ini?</span>
                    <span v-if="selected.length == 1">vendor {{ selected[0].nama_vendor }}?</span>
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
                var count = 0
                for(var i = 0; i < this.selected.length; i++) {
                    count += this.selected[i].jumlah
                }
                if(count > 0) {
                    $("#deleteModal").modal('hide')
                    if(this.selected.length > 1) {
                        flash('gagal menghapus, <br> ' + this.selected.length + ' vendor ini memiliki transaksi pembelian', 'error')
                    }else{
                        flash('gagal menghapus, <br> ' + this.selected[0].nama_vendor + ' memiliki transaksi pembelian', 'error')
                    }
                }else{
                    this.$store.dispatch('vendor_store/destroy', {selected: this.selected, perPage: this.perPage})
                }
            }
        },
        computed: {
            ...mapState('vendor_store' ,{
                selected: state => state.selected,
                perPage: state => state.perPage,
            }),
        }
    }
</script>