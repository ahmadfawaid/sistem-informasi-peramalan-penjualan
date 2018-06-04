<template>
    <div class="content">
        <div class="container">
            <topbar :title="title"></topbar>
            <div class="row">
                <div class="col col-12">
                    <toolbar page="vendor" :selected="selected" :perPage="perPage"></toolbar>
                    <loading v-if="loading"></loading>
                    <div v-else class="main-content">
                        <div class="card">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="checkbox"><label><input type="checkbox" v-model="selectAll"><span></span></label></th>
                                        <th class="nomor">No</th>
                                        <th>Nama Vendor</th>
                                        <th>Kota</th>
                                        <th>Nomor Telepon</th>
                                        <th>Jumlah Transaksi</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in vendors" :key="item.id">
                                        <td class="checkbox"><label><input type="checkbox" v-model="selectOne" :value="{id: item.id, nama_vendor: item.nama_vendor, jumlah: item.pembelian_count}"><span></span></label></td>
                                        <td class="nomor">{{ pagination.from + index }}</td>
                                        <td>{{ item.nama_vendor }}</td>
                                        <td>{{ item.kota }}</td>
                                        <td>{{ item.telepon | isEmpty }}</td>
                                        <td>{{ item.pembelian_count }}</td>
                                        <td><a @click.prevent="edit(item, index)" href=""><i class="icon-ubah warning" title="ubah"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination page="vendor" :pagination="pagination"></pagination>
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
                title: 'Data Vendor'
            }
        },
        mounted() {
            this.$store.dispatch('vendor_store/fetch', this.perPage)
            this.$store.commit('vendor_store/setSelected', [])
        },
        methods: {
            edit(vendor, index) {
                this.openModal('edit')
                this.$store.commit('vendor_store/setForm', {vendor, index})
            },
            openModal(modal) {
                $("#" + modal + "Modal").modal('show')
                this.$store.commit('vendor_store/emptyForm')
            }
        },
        computed: {
            ...mapState('vendor_store', {
                vendors: state => state.vendors,
                pagination: state => state.pagination,
                selected: state => state.selected,
                perPage: state => state.perPage,
                loading: state => state.loading
            }),
            selectAll: {
                get() {
                    return this.vendors ? this.selected.length == this.vendors.length : false;
                },
                set(value) {
                    var selected = []
                    if (value) {
                        this.vendors.forEach(function (vendor) {
                            selected.push({id: vendor.id, nama_vendor: vendor.nama_vendor, jumlah: vendor.pembelian_count})
                        });
                    }
                    this.$store.commit('vendor_store/setSelected', selected)
                }
            },
            selectOne: {
                get() {
                    return this.selected
                },
                set(value) {
                    this.$store.commit('vendor_store/setSelected', value)
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
