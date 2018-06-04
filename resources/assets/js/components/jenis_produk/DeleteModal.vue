<template>
  <div aria-hidden="true" class="modal fade delete" id="deleteModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="icon icon-hapus"></i>
                    <span class="modal-title">Hapus Jenis Produk</span>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan menghapus<br>
                    <span v-if="selected.length > 1">{{ selected.length }} jenis ini?</span>
                    <span v-if="selected.length == 1">{{ selected[0].jenis }}?</span>
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
                        flash('gagal menghapus, <br> terdapat produk yang menggunakan ' + this.selected.length + ' jenis produk ini', 'error')
                    }else{
                        flash('gagal menghapus, <br> terdapat '+ this.selected[0].jumlah +' produk yang menggunakan jenis ' + this.selected[0].jenis, 'error')
                    }
                }else{
                    this.$store.dispatch('jenis_produk_store/destroy', {selected: this.selected, perPage: this.perPage})
                }
            }
        },
        computed: {
            ...mapState('jenis_produk_store' ,{
                selected: state => state.selected,
                perPage: state => state.perPage,
            }),
        }
    }
</script>