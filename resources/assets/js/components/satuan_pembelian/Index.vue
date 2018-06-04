<template>
    <div class="content">
        <div class="container">
            <topbar :title="title"></topbar>
            <div class="row">
                <div class="col col-10">
                    <toolbar page="satuan_pembelian" :selected="selected" :perPage="perPage"></toolbar>
                    <loading v-if="loading"></loading>
                    <div v-else class="main-content">
                        <div class="card">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="checkbox"><label><input type="checkbox" v-model="selectAll"><span></span></label></th>
                                        <th class="nomor">No</th>
                                        <th>Satuan</th>
                                        <th>Jumlah</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in satuan_pembelians" :key="item.id">
                                        <td class="checkbox"><label><input type="checkbox" v-model="selectOne" :value="{id: item.id, satuan: item.satuan, jumlah: item.produk_count}"><span></span></label></td>
                                        <td class="nomor">{{ pagination.from + index }}</td>
                                        <td>{{ item.satuan }}</td>
                                        <td>{{ item.produk_count }}</td>
                                        <td><a @click.prevent="edit(item, index)" href=""><i class="icon-ubah warning" title="ubah"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination page="satuan_pembelian" :pagination="pagination"></pagination>
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
                title: 'Data Satuan Pembelian'
            }
        },
        mounted() {
            this.$store.dispatch('satuan_pembelian_store/fetch', this.perPage)
            this.$store.commit('satuan_pembelian_store/setSelected', [])
        },
        methods: {
            edit(satuan_pembelian, index) {
                this.openModal('edit')
                this.$store.commit('satuan_pembelian_store/setForm', {satuan_pembelian, index})
            },
            openModal(modal) {
                $("#" + modal + "Modal").modal('show')
                this.$store.commit('satuan_pembelian_store/emptyForm')
            }
        },
        computed: {
            ...mapState('satuan_pembelian_store', {
                satuan_pembelians: state => state.satuan_pembelians,
                pagination: state => state.pagination,
                selected: state => state.selected,
                perPage: state => state.perPage,
                loading: state => state.loading
            }),
            selectAll: {
                get() {
                    return this.satuan_pembelians ? this.selected.length == this.satuan_pembelians.length : false;
                },
                set(value) {
                    var selected = []
                    if (value) {
                        this.satuan_pembelians.forEach(function (item) {
                            selected.push({id: item.id, satuan: item.satuan, jumlah: item.produk_count})
                        });
                    }
                    this.$store.commit('satuan_pembelian_store/setSelected', selected)
                }
            },
            selectOne: {
                get() {
                    return this.selected
                },
                set(value) {
                    this.$store.commit('satuan_pembelian_store/setSelected', value)
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
