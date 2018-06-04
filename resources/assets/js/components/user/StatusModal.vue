<template>
  <div aria-hidden="true" class="modal fade delete move" id="statusModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span v-if="user.status" class="modal-title">Nonaktifkan Pengguna</span>
                    <span v-else class="modal-title">Aktifkan Pengguna</span>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan 
                    <span v-if="user.status">menonaktifkan</span>
                    <span v-else>mengaktifkan</span>
                    {{ user.nama }}?
                </div>
                <div class="modal-footer">
                    <button class="button" type="submit" @click="setStatus">Ya</button>
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
            setStatus() {
                console.log(this.user)
                this.$store.dispatch('user_store/setStatus', this.user)
            }
        },
        computed: {
            ...mapState('user_store' ,{
                user: state => state.user,
            }),
        }
    }
</script>

<style scoped>
    .modal-header{
        margin-top: 0px !important;
    }
</style>
