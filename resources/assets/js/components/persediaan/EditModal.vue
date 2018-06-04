<template>
    <div aria-hidden="true" class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="update()">
                    <div class="modal-header">
                        <span class="modal-title">Ubah Rak</span>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="label">Nomor Rak</label>
                            <input v-model="rak.nomor_rak" type="text" class="input" :class="{'has-error':errors.nomor_rak}" @change="checkForm()">
                            <span v-if="errors.nomor_rak" class="help error">{{ errors.nomor_rak[0] }}</span>
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
				this.$store.dispatch('rak_store/update', this.rak)
            },
            checkForm() {
                this.$store.dispatch('rak_store/checkForm', this.rak)
            }
        },
        computed: {
            ...mapState('rak_store', {
                rak: state => state.rak,
                errors: state => state.errors,
                perPage: state => state.perPage
            })
        }
    }
</script>
