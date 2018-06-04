<template>
    <div class="content">
        <div class="container">
            <topbar :title="title"></topbar>
            <div class="row">
                <div class="col col-12">
                    <toolbar page="penjualan" :perPage="perPage"></toolbar>
                    <loading v-if="loading"></loading>
                    <div v-else class="main-content">
                        <div class="card">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="nomor">No</th>
                                        <th style="width: 200px;">Nomor Faktur</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah Item</th>
                                        <th>Total</th>
                                        <th>Petugas</th>
                                        <!-- <th></th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in penjualans" :key="item.id">
                                        <td class="nomor">{{ pagination.from + index }}</td>
                                        <td v-if="role == 'apoteker'" style="width: 200px;"><router-link :to="{ name: 'penjualan-detail', params: { nomor_faktur: item.nomor_faktur }}">{{ item.nomor_faktur }}</router-link></td>
                                        <td v-else style="width: 200px;"><router-link :to="{ name: 'data-penjualan-detail', params: { nomor_faktur: item.nomor_faktur }}">{{ item.nomor_faktur }}</router-link></td>
                                        <td>{{ item.tanggal | tanggal }}</td>
                                        <td>{{ item.detail_penjualan_count }}</td>
                                        <td>{{ item.total | rupiah }}</td>
                                        <td>{{ item.user.nama }}</td>
                                        <!-- <td><router-link :to="{ name: 'penjualan-edit', params: { nomor_faktur: item.nomor_faktur }}"><i class="icon-ubah warning" title="ubah"></i></router-link></td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination page="penjualan" :pagination="pagination"></pagination>
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
                title: 'Data Penjualan',
                role: $('meta[name="user-role"]').attr('content'),
            }
        },
        mounted() {
            this.$store.dispatch('penjualan_store/fetch', this.perPage)
        },
        computed: {
            ...mapState('penjualan_store', {
                penjualans: state => state.penjualans,
                pagination: state => state.pagination,
                perPage: state => state.perPage,
                loading: state => state.loading
            }),
        }
    }
</script>

<style>
    .searchh {
        position: fixed;
        top:0px;
        left: 0px;
        z-index: 1000;
        background: black;
        width: 350px;
        height: 100vh;
    }
</style>
