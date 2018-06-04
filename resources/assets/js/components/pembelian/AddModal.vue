<template>
    <div aria-hidden="true" class="modal fade delete move" id="addModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="icon icon-persediaan"></i>
                    <span class="modal-title">Tambahkan Ke Persediaan</span>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="label">Tambahkan daftar pembelian ke data persediaan</label>
                        <search-select v-model="rak_id" :options="rak" placeholder="Pilih Rak"></search-select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="button" type="submit" @click="simpan">Simpan</button>
                    <span class="cancel" @click="skip">Lewati</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import { ModelSelect } from 'vue-search-select'

    export default {
        data() {
            return {
                rak_id: ''
            }
        },
        mounted() {
            this.$store.dispatch('pembelian_store/fetchRak')
            // this.pembelian.user_id = $('meta[name="user-id"]').attr('content')
        },
        methods: {
            simpan() {
                this.$store.dispatch('pembelian_store/store', {pembelian: this.pembelian, rakID: this.rak_id, perPage: this.perPage})
                $("#addModal").modal('hide')
                this.next()
            },
            skip() {
                this.$store.dispatch('pembelian_store/skip', {pembelian: this.pembelian, perPage: this.perPage})
                $("#addModal").modal('hide')
                this.next()
            },
            next() {
                if(this.pembelian.vendor_id != '' && this.pembelian.nomor_faktur != '' && this.pembelian.tanggal != '') {
                    this.$router.push({ name: 'pembelian'})
                }
            }
        },
        computed: {
            ...mapState('pembelian_store', {
                pembelian: state => state.pembelian,
                errors: state => state.errors,
                perPage: state => state.perPage,
                rak: state => state.rak,
            })
        },
        components: {
            'search-select': ModelSelect
        }
    }
</script>

<style scoped>
    .disabled{
        background: #ddd !important;
        box-shadow: none;
        color: #777;
        cursor: default;
    }
</style>
