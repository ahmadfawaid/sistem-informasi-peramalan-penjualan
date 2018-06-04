<template>
    <div class="content">
        <div class="container">
            <topbar :title="title"></topbar>
            <div class="row">
                <div class="col col-12">
                    <div class="toolbar" style="margin-bottom: 30px;" v-if="role == 'apoteker'">
                        <div class="left">
                            <button type="button" class="button" @click="openModal('add')"><i class="icon-tambah"></i>Tambah Rak</button>
                            <div class="search-field">
                                <input type="text" placeholder="cari produk..." style="width: 250px">
                                <i class="icon-cari"></i>
                            </div>
                        </div>
                    </div>
                    <loading v-if="loading"></loading>
                    <div v-else class="main-content stok">
                        <div v-for="(item, index) in raks" :key="index" class="item">
                            <div class="card">
                                <div class="top">
                                    <span class="label">Nomor Rak</span>
                                    <a v-if="role == 'apoteker'" @click.prevent="edit(item, index)" href=""><i class="icon-ubah warning" title="ubah"></i></a>
                                </div>
                                <router-link v-if="role == 'apoteker'" :to="{ name: 'persediaan-detail', params: { nomor_rak: item.nomor_rak }}" class="number">{{ item.nomor_rak }}</router-link>
                                <router-link v-else :to="{ name: 'data-persediaan-detail', params: { nomor_rak: item.nomor_rak }}" class="number">{{ item.nomor_rak }}</router-link>
                                <span v-if="item.jumlah_produk != 0 && item.total_stok != 0" class="info" style="color: #0065ff">{{ item.jumlah_produk }} produk, {{ item.total_stok }} stok</span>
                                <span v-else class="info">rak sedang kosong</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <flash></flash>
        <addmodal></addmodal>
        <editmodal></editmodal>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import AddModal from './AddModal'
    import EditModal from './EditModal'

    export default {
        data() {
            return {
                title: 'Data Persediaan',
                role: $('meta[name="user-role"]').attr('content'),
            }
        },
        mounted() {
            this.$store.dispatch('rak_store/fetch')
        },
        methods: {
            edit(rak, index) {
                this.openModal('edit')
                this.$store.commit('rak_store/setForm', {rak, index})
            },
            openModal(modal) {
                $("#" + modal + "Modal").modal('show')
                this.$store.commit('rak_store/emptyForm')
            }
        },
        computed: {
            ...mapState('rak_store', {
                raks: state => state.raks,
                loading: state => state.loading
            })
        },
        components: {
            'addmodal': AddModal,
            'editmodal': EditModal,
        }
    }
</script>
