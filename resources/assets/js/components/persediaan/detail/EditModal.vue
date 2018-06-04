<template>
    <div aria-hidden="true" class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="update()">
                    <div class="modal-header">
                        <span class="modal-title">Ubah Detail Persediaan {{ nomorRak }}</span>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="label">Produk</label>
                            <search-select v-model="persediaan.produk_id" :options="produk" placeholder="Pilih Produk"></search-select>
                            <span v-if="errors.produk_id" class="help error">{{ errors.produk_id[0] }}</span>
                        </div>
                        <div class="row">
                            <div class="col col-6" style="padding-right: 10px;">
                                <div class="form-group">
                                    <label class="label">Stok</label>
                                    <input v-model="persediaan.stok" type="text" class="input" :class="{'has-error':errors.stok}" @change="checkForm('stok')">
                                    <span v-if="errors.stok" class="help error">{{ errors.stok[0] }}</span>
                                </div>
                            </div>
                            <div class="col col-6" style="padding-left: 10px;">
                                <div class="form-group">
                                    <label class="label">Tanggal Kadaluarsa</label>
                                    <input v-model="persediaan.tanggal_kadaluarsa" type="text" onfocus="(this.type='date')" onfocusout="(this.type='text')" class="input" :class="{'has-error':errors.tanggal_kadaluarsa}" @change="checkForm('tanggal_kadaluarsa')">
                                    <span v-if="errors.tanggal_kadaluarsa" class="help error">{{ errors.tanggal_kadaluarsa[0] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="cancel" data-dismiss="modal">Batal</span>
                        <button class="button" type="submit"><i class="icon-sukses"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import { ModelSelect } from 'vue-search-select'

    export default {
        mounted() {
            this.$store.dispatch('persediaan_store/fetchProduk')
        },
        methods: {
            update() {
                this.$store.dispatch('persediaan_store/update', {persediaan: this.persediaan, perPage: this.perPage, nomorRak: this.nomorRak})
            },
            checkForm(form) {
                this.$store.dispatch('persediaan_store/checkForm', {form: form, persediaan: this.persediaan})
            }
        },
        computed: {
            ...mapState('persediaan_store', {
                persediaan: state => state.persediaan,
                nomorRak: state => state.nomorRak,
                rak: state => state.rak,
                produk: state => state.produk,
                errors: state => state.errors,
                perPage: state => state.perPage
            }),

        },
        watch:{
            'persediaan.rak_id': function(oldVal) {
                if(oldVal !== '') {
                    this.checkForm('rak_id')
                }
            },
            'persediaan.produk_id': function(oldVal) {
                if(oldVal !== '') {
                    this.checkForm('produk_id')
                }
            }
        },
        components: {
            'search-select': ModelSelect
        }
    }
</script>
