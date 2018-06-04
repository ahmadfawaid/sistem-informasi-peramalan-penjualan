<template>
    <div class="content">
        <div class="container">
            <topbar :title="title"></topbar>
            <div class="row">
                <div class="col col-12">
                    <toolbar page="pembelian" :perPage="perPage"></toolbar>
                    <loading v-if="loading"></loading>
                    <div v-else class="main-content">
                        <div v-if="pembelians.length == 0" class="empty">
                            <i class="icon-transaksi"></i>
                            <span>Belum ada pencatatan transaksi pembelian</span>
                        </div>
                        <div v-if="pembelians.length > 0" class="card">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="nomor">No</th>
                                        <th>Nomor Faktur</th>
                                        <th>Vendor</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah Item</th>
                                        <th>Total</th>
                                        <th>Petugas</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in pembelians" :key="item.id">
                                        <td class="nomor">{{ pagination.from + index }}</td>
                                        <td v-if="role == 'apoteker'"><router-link :to="{ name: 'pembelian-detail', params: { nomor_faktur: item.nomor_faktur }}">{{ item.nomor_faktur }}</router-link></td>
                                        <td v-else><router-link :to="{ name: 'data-pembelian-detail', params: { nomor_faktur: item.nomor_faktur }}">{{ item.nomor_faktur }}</router-link></td>
                                        <td>{{ item.vendor.nama_vendor }}</td>
                                        <td>{{ item.tanggal | tanggal }}</td>
                                        <td>{{ item.detail_pembelian_count }}</td>
                                        <td>{{ item.total | rupiah }}</td>
                                        <td>{{ item.user.nama }}</td>
                                        <td v-if="role == 'apoteker'"><router-link :to="{ name: 'pembelian-edit', params: { nomor_faktur: item.nomor_faktur }}"><i class="icon-ubah warning" title="ubah"></i></router-link></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination v-if="pembelians.length > 0" page="pembelian" :pagination="pagination"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <flash></flash>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        data() {
            return {
                title: 'Data Pembelian',
                role: $('meta[name="user-role"]').attr('content'),
            }
        },
        mounted() {
            this.$store.dispatch('pembelian_store/fetch', this.perPage)
        },
        computed: {
            ...mapState('pembelian_store', {
                pembelians: state => state.pembelians,
                pagination: state => state.pagination,
                perPage: state => state.perPage,
                loading: state => state.loading
            }),
        }
    }
</script>