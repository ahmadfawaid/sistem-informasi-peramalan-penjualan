<template>
    <div class="content">
        <div class="container">
            <topbar :title="title"></topbar>
            <div class="row">
                <div class="col col-12">
                    <toolbar page="persediaan" :selected="selected" :nomorRak="nomorRak" :perPage="perPage"></toolbar>
                    <loading v-if="loading"></loading>
                    <div v-else class="main-content">
                        <div class="card custom" style="padding: 20px">
                            <span v-if="persediaans.length > 0" class="title">Nomor Rak: {{ nomorRak }} ({{ rakInfo.jumlah_produk }} Produk, {{ rakInfo.total_stok }} Total Stok)</span>
                            <span v-else class="title">Nomor Rak: {{ nomorRak }} (Persediaan Kosong)</span>
                        </div>
                        <div v-if="persediaans.length > 0" class="card">
                            <table>
                                <thead>
                                    <tr>
                                        <th v-if="role == 'apoteker'" class="checkbox"><label><input type="checkbox" v-model="selectAll"><span></span></label></th>
                                        <th class="nomor">No</th>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Tanggal Kadaluarsa</th>
                                        <th v-if="role == 'apoteker'"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in persediaans" :key="item.id">
                                        <td v-if="role == 'apoteker'" class="checkbox"><label><input type="checkbox" v-model="selectOne" :value="{id: item.id, nama_produk: item.nama_produk}"><span></span></label></td>
                                        <td class="nomor">{{ pagination.from + index }}</td>
                                        <td style="min-width: 150px;"><a href="">{{ item.nama_produk }}</a><span>{{ item.kode_produk }}</span></td>
                                        <td>{{ item.harga_jual | rupiah }}</td>
                                        <td>{{ item.stok }} {{ item.satuan.toLowerCase() }}</td>
                                        <td>{{ item.tanggal_kadaluarsa | tanggal }}</td>
                                        <td v-if="role == 'apoteker'"><a @click.prevent="edit(item, index)" href=""><i class="icon-ubah warning" title="ubah"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination v-if="persediaans.length > 0" page="persediaan" :pagination="pagination" :nomorRak="nomorRak"></pagination>
                        <button v-if="role == 'apoteker' && persediaans.length == 0" class="button custom" type="button" @click="openModal('deleteRak')">Hapus rak {{ nomorRak}}</button>
                    </div>
                </div>
            </div>
        </div>
        <flash></flash>
        <addmodal></addmodal>
        <editmodal></editmodal>
        <movemodal></movemodal>
        <deletemodal></deletemodal>
        <deleterakmodal></deleterakmodal>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import AddModal from './AddModal'
    import EditModal from './EditModal'
    import MoveModal from './MoveModal'
    import DeleteModal from './DeleteModal'
    import DeleteRakModal from '../DeleteModal'

    export default {
        data() {
            return {
                title: 'Detail Persediaan',
                role: $('meta[name="user-role"]').attr('content'),
            }
        },
        mounted() {
            this.$store.commit('persediaan_store/setNomorRak', this.$route.params.nomor_rak)
            this.$store.commit('persediaan_store/setSelected', [])
            this.$store.dispatch('persediaan_store/fetch', {nomorRak: this.nomorRak, perPage: this.perPage})  
        },
        methods: {
            edit(persediaan, index) {
                this.openModal('edit')
                this.$store.commit('persediaan_store/setForm', {persediaan, index})
            },
            openModal(modal) {
                $("#" + modal + "Modal").modal('show')
                this.$store.commit('persediaan_store/emptyForm')
            }
        },
        computed: {
            ...mapState('persediaan_store', {
                persediaans: state => state.persediaans,
                nomorRak: state => state.nomorRak,
                rakInfo: state => state.rakInfo,
                pagination: state => state.pagination,
                selected: state => state.selected,
                perPage: state => state.perPage,
                loading: state => state.loading
            }),
            selectAll: {
                get() {
                    return this.persediaans ? this.selected.length == this.persediaans.length : false;
                },
                set(value) {
                    var selected = []
                    if (value) {
                        this.persediaans.forEach(function (item) {
                            selected.push({id: item.id, nama_produk: item.nama_produk})
                        });
                    }
                    this.$store.commit('persediaan_store/setSelected', selected)
                }
            },
            selectOne: {
                get() {
                    return this.selected
                },
                set(value) {
                    this.$store.commit('persediaan_store/setSelected', value)
                }
            },
        },
        components: {
            'addmodal': AddModal,
            'editmodal': EditModal,
            'movemodal': MoveModal,
            'deletemodal': DeleteModal,
            'deleterakmodal': DeleteRakModal,
        }
    }
</script>

<style>
    .button.custom {
        background: #ddd;
        box-shadow: none;
        color: #666;
        margin: 50px auto;
        opacity: 0.7;
    }
</style>
