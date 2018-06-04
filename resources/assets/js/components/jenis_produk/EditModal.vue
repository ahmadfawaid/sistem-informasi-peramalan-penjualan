<template>
    <div aria-hidden="true" class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="update()">
                    <div class="modal-header">
                        <span class="modal-title">Ubah Jenis Produk</span>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="label">Jenis Produk</label>
                            <input v-model="jenis_produk.jenis" type="text" class="input" :class="{'has-error':errors.jenis}" @change="checkForm()">
                            <span v-if="errors.jenis" class="help error">{{ errors.jenis[0] }}</span>
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

    export default {
        methods: {
            update() {
				this.$store.dispatch('jenis_produk_store/update', this.jenis_produk)
            },
            checkForm() {
                this.$store.dispatch('jenis_produk_store/checkForm', this.jenis_produk)
            }
        },
        computed: {
            ...mapState('jenis_produk_store', {
                jenis_produk: state => state.jenis_produk,
                errors: state => state.errors,
                perPage: state => state.perPage
            })
        }
    }
</script>
