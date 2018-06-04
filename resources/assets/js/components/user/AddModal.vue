<template>
    <div aria-hidden="true" class="modal fade" id="addModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="store()">
                    <div class="modal-header">
                        <span class="modal-title">Tambah Pengguna</span>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="label">Nama</label>
                            <input v-model="user.nama" type="text" class="input" :class="{'has-error':errors.nama}" @change="checkForm('nama')">
                            <span v-if="errors.nama" class="help error">{{ errors.nama[0] }}</span>
                        </div>
                        <div class="form-group">
                            <label class="label">Username</label>
                            <input v-model="user.username" type="text" class="input" :class="{'has-error':errors.username}" @change="checkForm('username')">
                            <span v-if="errors.username" class="help error">{{ errors.username[0] }}</span>
                        </div>
                        <div class="form-group">
                            <label class="label">Email</label>
                            <input v-model="user.email" type="email" class="input" :class="{'has-error':errors.email}" @change="checkForm('email')">
                            <span v-if="errors.email" class="help error">{{ errors.email[0] }}</span>
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
            store() {
				this.$store.dispatch('user_store/store', {user: this.user, perPage: this.perPage})
            },
            checkForm(form) {
                this.$store.dispatch('user_store/checkForm', {form: form, user: this.user})
            }
        },
        computed: {
            ...mapState('user_store', {
                user: state => state.user,
                errors: state => state.errors,
                perPage: state => state.perPage
            })
        }
    }
</script>
