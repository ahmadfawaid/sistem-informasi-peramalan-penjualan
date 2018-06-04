<template>
    <div class="content">
        <div class="container">
            <topbar :title="title"></topbar>
            <div class="row">
                <div class="col col-10">
                    <toolbar page="jenis_produk" :selected="selected" :perPage="perPage"></toolbar>
                    <loading v-if="loading"></loading>
                    <div v-else class="main-content">
                        <div class="card">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="checkbox"><label><input type="checkbox" v-model="selectAll"><span></span></label></th>
                                        <th class="nomor">No</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in jenis_produks" :key="item.id">
                                        <td class="checkbox"><label><input type="checkbox" v-model="selectOne" :value="{id: item.id, jenis: item.jenis, jumlah: item.produk_count}"><span></span></label></td>
                                        <td class="nomor">{{ pagination.from + index }}</td>
                                        <td>{{ item.jenis }}</td>
                                        <td>{{ item.produk_count }}</td>
                                        <td><a @click.prevent="edit(item, index)" href=""><i class="icon-ubah warning" title="ubah"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination page="jenis_produk" :pagination="pagination"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <flash></flash>
        <addmodal></addmodal>
        <editmodal></editmodal>
        <deletemodal></deletemodal>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import AddModal from './AddModal'
    import EditModal from './EditModal'
    import DeleteModal from './DeleteModal'

    export default {
        data() {
            return {
                title: 'Data Jenis Obat'
            }
        },
        mounted() {
            this.$store.dispatch('jenis_produk_store/fetch', this.perPage)
            this.$store.commit('jenis_produk_store/setSelected', [])
        },
        methods: {
            edit(jenis_produk, index) {
                this.openModal('edit')
                this.$store.commit('jenis_produk_store/setForm', {jenis_produk, index})
            },
            openModal(modal) {
                $("#" + modal + "Modal").modal('show')
                this.$store.commit('jenis_produk_store/emptyForm')
            }
        },
        computed: {
            ...mapState('jenis_produk_store', {
                jenis_produks: state => state.jenis_produks,
                pagination: state => state.pagination,
                selected: state => state.selected,
                perPage: state => state.perPage,
                loading: state => state.loading
            }),
            selectAll: {
                get() {
                    return this.jenis_produks ? this.selected.length == this.jenis_produks.length : false;
                },
                set(value) {
                    var selected = []
                    if (value) {
                        this.jenis_produks.forEach(function (jenis_produk) {
                            selected.push({id: jenis_produk.id, jenis: jenis_produk.jenis, jumlah: jenis_produk.produk_count})
                        });
                    }
                    this.$store.commit('jenis_produk_store/setSelected', selected)
                }
            },
            selectOne: {
                get() {
                    return this.selected
                },
                set(value) {
                    this.$store.commit('jenis_produk_store/setSelected', value)
                }
            }
        },
        components: {
            'addmodal': AddModal,
            'editmodal': EditModal,
            'deletemodal': DeleteModal
        }
    }
</script>
