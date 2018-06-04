<template>
    <div aria-hidden="true" class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="update()">
                    <div class="modal-header">
                        <span class="modal-title">Ubah Vendor</span>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="label">Nama Vendor</label>
                            <input v-model="vendor.nama_vendor" type="text" class="input" :class="{'has-error':errors.nama_vendor}" @change="checkForm('nama_vendor')">
                            <span v-if="errors.nama_vendor" class="help error">{{ errors.nama_vendor[0] }}</span>
                        </div>
                        <div class="form-group">
                            <label class="label">Kota</label>
                            <input v-model="vendor.kota" type="text" class="input" :class="{'has-error':errors.namakota_vendor}" @change="checkForm('kota')">
                            <span v-if="errors.kota" class="help error">{{ errors.kota[0] }}</span>
                        </div>
                        <div class="form-group">
                            <label class="label">Telepon</label>
                            <input v-model="vendor.telepon" type="text" class="input" :class="{'has-error':errors.telepon}" @change="checkForm('telepon')">
                            <span v-if="errors.telepon" class="help error">{{ errors.telepon[0] }}</span>
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
				this.$store.dispatch('vendor_store/update', this.vendor)
            },
            checkForm(form) {
                this.$store.dispatch('vendor_store/checkForm', {form: form, vendor: this.vendor})
            }
        },
        computed: {
            ...mapState('vendor_store', {
                vendor: state => state.vendor,
                errors: state => state.errors,
                perPage: state => state.perPage
            })
        }
    }
</script>
