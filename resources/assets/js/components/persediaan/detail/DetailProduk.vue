<template>
    <div aria-hidden="true" class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="update()">
                    <div class="modal-header">
                        <span class="modal-title">Ubah Produk</span>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="label">Nama Produk</label>
                            <input v-model="produk.nama_produk" type="text" class="input" :class="{'has-error':errors.nama_produk}" @change="checkForm('nama_produk')">
                            <span v-if="errors.nama_produk" class="help error">{{ errors.nama_produk[0] }}</span>
                        </div>
                        <div class="row">
                            <div class="col col-6" style="padding-right: 10px;">
                                <div class="form-group">
                                    <label class="label">Jenis Produk</label>
                                    <search-select v-model="produk.jenis_produk_id" :options="jenisProduk" placeholder="Pilih Jenis"></search-select>
                                    <span v-if="errors.jenis_produk_id" class="help error">{{ errors.jenis_produk_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col col-6" style="padding-left: 10px;">
                                <div class="form-group">
                                    <label class="label">Satuan Produk</label>
                                    <search-select v-model="produk.satuan_produk_id" :options="satuanProduk" placeholder="Pilih Satuan"></search-select>
                                    <span v-if="errors.satuan_produk_id" class="help error">{{ errors.satuan_produk_id[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="label">Kode Produk</label>
                            <input v-model="getKodeProduk" type="text" class="input" :class="{'has-error':errors.kode_produk}" readonly>
                            <span v-if="errors.kode_produk" class="help error">{{ errors.kode_produk[0] }}</span>
                        </div>
                        <div class="row">
                            <div class="col col-6" style="padding-right: 10px;">
                                <div class="form-group">
                                    <label class="label">Harga Beli</label>
                                    <input v-model="produk.harga_beli" type="text" class="input" :class="{'has-error':errors.harga_beli}" @change="checkForm('harga_beli')">
                                    <span v-if="errors.harga_beli" class="help error">{{ errors.harga_beli[0] }}</span>
                                    <span v-if="produk.harga_beli == ''" class="help">Kosongkan jika harga beli belum ditentukan</span>
                                </div>
                            </div>
                            <div class="col col-6" style="padding-left: 10px;">
                                <div class="form-group">
                                    <label class="label">Harga Jual</label>
                                    <input v-model="produk.harga_jual" type="text" class="input" :class="{'has-error':errors.harga_jual}" @change="checkForm('harga_jual')">
                                    <span v-if="errors.harga_jual" class="help error">{{ errors.harga_jual[0] }}</span>
                                    <span v-if="produk.harga_jual == ''" class="help">Kosongkan jika harga jual belum ditentukan</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="label">Stok Minimal</label>
                            <input v-model="produk.stok_minimal" type="text" class="input" :class="{'has-error':errors.stok_minimal}" @change="checkForm('stok_minimal')">
                            <span v-if="errors.stok_minimal" class="help error">{{ errors.stok_minimal[0] }}</span>
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
    import { mapState, mapGetters } from 'vuex'
    import { ModelSelect } from 'vue-search-select'

    export default {
        mounted() {
            this.$store.dispatch('produk_store/fetchJenisProduk')
            this.$store.dispatch('produk_store/fetchSatuanProduk')
        },
        methods: {
            update() {
				this.$store.dispatch('produk_store/update', this.produk)
            },
            checkForm(form) {
                this.$store.dispatch('produk_store/checkForm', {form: form, produk: this.produk})
            }
        },
        computed: {
            ...mapState('produk_store', {
                produk: state => state.produk,
                errors: state => state.errors,
                jenisProduk: state => state.jenisProduk,
                satuanProduk: state => state.satuanProduk,
                perPage: state => state.perPage
            }),
            ...mapGetters('produk_store', [
                'getKodeProduk'
            ])
        },
        watch:{
            'produk.kode_produk': function() {
                this.checkForm('kode_produk')
            },
            'produk.jenis_produk_id': function(oldVal) {
                if(oldVal !== '') {
                    this.checkForm('jenis_produk_id')
                }
            },
            'produk.satuan_produk_id': function(oldVal) {
                if(oldVal !== '') {
                    this.checkForm('satuan_produk_id')
                }
            }
        },
        components: {
            'search-select': ModelSelect
        }
    }
</script>
