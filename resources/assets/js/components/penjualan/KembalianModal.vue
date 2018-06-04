<template>
  <div aria-hidden="true" class="modal fade delete" id="kembalianModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title">Kembalian</span>
                </div>
                <div class="modal-body">
                    {{ kembalian | rupiah }}
                </div>
                <div class="modal-footer">
                    <button class="button bg-primary" type="submit" @click="simpan" @keyup.enter="simpan" autofocus>OK</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import { mapState } from 'vuex'
    export default {
        methods: {
            simpan() {
                $("#kembalianModal").modal('hide')
                this.$store.dispatch('penjualan_store/store', {penjualan: this.penjualan, perPage: this.perPage})
                this.$router.push({ name: 'penjualan' })
            }
        },
        computed: {
            ...mapState('penjualan_store', {
                kembalian: state => state.kembalian,
                penjualan: state => state.penjualan,
                perPage: state => state.perPage,
            }),
        }
    }
</script>

<style scoped>
    .modal-header .modal-title{
        margin-top: 0px !important;
    }
    .modal-body{
        font-size: 40px !important;
        letter-spacing: 0 !important;
        font-weight: bold !important;
        color: #13ce66;
        line-height: 1 !important;
        margin: 10px 0px 20px !important;
    }
    .modal-footer .button {
        background: #0065ff !important;
    }
</style>
