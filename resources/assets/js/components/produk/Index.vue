<template>
    <div class="content">
        <div class="container">
            <topbar :title="title"></topbar>
            <div class="row">
                <div class="col col-12">
                    <toolbar page="produk" :selected="selected" :perPage="perPage"></toolbar>
                    <loading v-if="loading"></loading>
                    <div v-else class="main-content">
                        <div class="card">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="checkbox"><label><input type="checkbox" v-model="selectAll"><span></span></label></th>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Jenis</th>
                                        <th>Satuan Beli</th>
                                        <th>Isi</th>
                                        <th>Satuan Jual</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th class="text-center">Stok Min</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in produks" :key="item.id">
                                        <td class="checkbox"><label><input type="checkbox" v-model="selectOne" :value="{id: item.id, nama_produk: item.nama_produk, jumlah_persediaan: item.persediaan_count, jumlah_penjualan: item.detail_penjualan_count, jumlah_pembelian: item.detail_pembelian_count}"><span></span></label></td>
                                        <td class="nomor">{{ pagination.from + index }}</td>
                                        <td style="min-width: 150px;"><a href="">{{ item.nama_produk }}</a><span>{{ item.kode_produk }}</span></td>
                                        <td>{{ item.jenis.jenis }}</td>
                                        <td>{{ item.satuan_pembelian.satuan }}</td>
                                        <td>{{ item.isi }}</td>
                                        <td>{{ item.satuan_penjualan.satuan }}</td>
                                        <td>{{ item.harga_beli | rupiah }}</td>
                                        <td>{{ item.harga_jual | rupiah }}</td>
                                        <td class="text-center">{{ item.stok_minimal }}</td>
                                        <td><a @click.prevent="edit(item, index)" href=""><i class="icon-ubah warning" title="ubah"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination page="produk" :pagination="pagination"></pagination>
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
                title: 'Data Obat dan Alat Kesehatan'
            }
        },
        mounted() {
            this.$store.dispatch('produk_store/fetch', this.perPage)
            this.$store.commit('produk_store/setSelected', [])
        },
        methods: {
            edit(produk, index) {
                this.openModal('edit')
                this.$store.commit('produk_store/setForm', {produk, index})
            },
            openModal(modal) {
                $("#" + modal + "Modal").modal('show')
                this.$store.commit('produk_store/emptyForm')
            }
        },
        computed: {
            ...mapState('produk_store', {
                produks: state => state.produks,
                pagination: state => state.pagination,
                selected: state => state.selected,
                perPage: state => state.perPage,
                loading: state => state.loading
            }),
            selectAll: {
                get() {
                    return this.produks ? this.selected.length == this.produks.length : false;
                },
                set(value) {
                    var selected = []
                    if (value) {
                        this.produks.forEach(function (item) {
                            selected.push({id: item.id, nama_produk: item.nama_produk, jumlah_persediaan: item.persediaan_count, jumlah_penjualan: item.detail_penjualan_count, jumlah_pembelian: item.detail_pembelian_count})
                        });
                    }
                    this.$store.commit('produk_store/setSelected', selected)
                }
            },
            selectOne: {
                get() {
                    return this.selected
                },
                set(value) {
                    this.$store.commit('produk_store/setSelected', value)
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
