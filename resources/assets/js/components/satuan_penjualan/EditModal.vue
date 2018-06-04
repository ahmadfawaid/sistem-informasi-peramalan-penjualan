<template>
    <div aria-hidden="true" class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="update()">
                    <div class="modal-header">
                        <span class="modal-title">Ubah Satuan</span>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="label">Satuan</label>
                            <input v-model="satuan_penjualan.satuan" type="text" class="input" :class="{'has-error':errors.satuan}" @change="checkForm()">
                            <span v-if="errors.satuan" class="help error">{{ errors.satuan[0] }}</span>
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
				this.$store.dispatch('satuan_penjualan_store/update', this.satuan_penjualan)
            },
            checkForm() {
                this.$store.dispatch('satuan_penjualan_store/checkForm', this.satuan_penjualan)
            }
        },
        computed: {
            ...mapState('satuan_penjualan_store', {
                satuan_penjualan: state => state.satuan_penjualan,
                errors: state => state.errors,
                perPage: state => state.perPage
            })
        }
    }
</script>
