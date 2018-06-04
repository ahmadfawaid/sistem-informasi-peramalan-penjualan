<template>
  <div aria-hidden="true" class="modal fade delete" id="deleteRakModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="icon icon-hapus"></i>
                    <span class="modal-title">Hapus Persediaan</span>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan menghapus rak {{ nomorRak }}
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
                this.$store.dispatch('rak_store/destroy', this.nomorRak)
                $("#deleteRakModal").modal('hide')
                this.$router.push({ name: 'persediaan'})
            }
        },
        computed: {
            ...mapState('persediaan_store' ,{
                nomorRak: state => state.nomorRak
            }),
        }
    }
</script>