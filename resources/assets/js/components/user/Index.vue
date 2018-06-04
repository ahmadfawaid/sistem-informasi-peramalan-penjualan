<template>
    <div class="content">
        <div class="container">
            <topbar :title="title"></topbar>
            <div class="row">
                <div class="col col-12">
                    <toolbar page="user" :perPage="perPage"></toolbar>
                    <loading v-if="loading"></loading>
                    <div v-else class="main-content user">
                        <div class="card">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="nomor">No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in users" :key="item.id">
                                        <td class="nomor">{{ pagination.from + index }}</td>
                                        <td>{{ item.nama }}</td>
                                        <td>{{ item.username }}</td>
                                        <td>{{ item.email }}</td>
                                        <td><input v-model="item.status" type="checkbox" class="switch" @click.prevent="setStatus(item, index)"></td>
                                        <td><a @click.prevent="edit(item, index)" href=""><i class="icon-ubah warning" title="ubah"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination page="user" :pagination="pagination"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <flash></flash>
        <addmodal></addmodal>
        <editmodal></editmodal>
        <statusmodal></statusmodal>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import AddModal from './AddModal'
    import EditModal from './EditModal'
    import StatusModal from './StatusModal'

    export default {
        data() {
            return {
                title: 'Data Pengguna'
            }
        },
        mounted() {
            this.$store.dispatch('user_store/fetch', this.perPage)
        },
        methods: {
            edit(user, index) {
                this.openModal('edit')
                this.$store.commit('user_store/setForm', {user, index})
            },
            setStatus(user, index) {
                user.status == true ? true : false
                this.openModal('status')
                this.$store.commit('user_store/setForm', {user, index})
            },
            openModal(modal) {
                $("#" + modal + "Modal").modal('show')
                this.$store.commit('user_store/emptyForm')
            }
        },
        computed: {
            ...mapState('user_store', {
                users: state => state.users,
                pagination: state => state.pagination,
                perPage: state => state.perPage,
                loading: state => state.loading
            })
        },
        components: {
            'addmodal': AddModal,
            'editmodal': EditModal,
            'statusmodal': StatusModal
        }
    }
</script>

<style lang="scss">
    .main-content.user {
        img {
            width: 44px;
            height: 44px;
            border-radius: 50px;
        }
    }
</style>
