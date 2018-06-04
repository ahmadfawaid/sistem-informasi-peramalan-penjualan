<template>
    <div class="sidebar">
        <div class="slimscroll">
            <router-link class="logo" :to="{ name: 'dashboard' }"><img class="img" src="/images/logo.png" alt="Logo"/></router-link>
            <router-link v-if="role === 'apoteker'" :to="{ name: 'penjualan-add' }" class="button cashier">Penjualan Baru</router-link>
            <nav class="nav">
                <ul class="metismenu" id="menu">
                    <li class="menu-title">Navigasi</li>
                    <li>
                        <router-link :to="{ name: 'dashboard' }"><i class="icon-dashboard"></i>Dashboard</router-link>
                    </li>
                    <li v-if="role === 'manager'">
                        <router-link :to="{ name: 'data-pembelian' }"><i class="icon-transaksi"></i>Data Pembelian</router-link>
                    </li>
                    <li v-if="role === 'manager'">
                        <router-link :to="{ name: 'data-penjualan' }"><i class="icon-transaksi"></i>Data Penjualan</router-link>
                    </li>
                    <li v-if="role === 'manager'">
                        <router-link :to="{ name: 'data-persediaan' }"><i class="icon-persediaan"></i>Persediaan Produk</router-link>
                    </li>
                    <li v-if="role === 'manager'">
                        <router-link :to="{ name: 'user' }"><i class="icon-pengguna"></i>Data Pengguna</router-link>
                    </li>
                    <li v-if="role === 'apoteker'">
                        <a href="javascript: void(0);"><i class="icon-transaksi"></i>Transaksi<span class="icon-expand"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                                <router-link :to="{ name: 'pembelian' }">Pembelian</router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'penjualan' }">Penjualan</router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="role === 'apoteker'">
                        <router-link :to="{ name: 'persediaan' }"><i class="icon-persediaan"></i>Persediaan</router-link>
                    </li>
                    <li v-if="role === 'apoteker'">
                        <a href="javascript: void(0);"><i class="icon-produk"></i>Produk<span class="icon-expand"></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                                <router-link :to="{ name: 'produk' }">Data Produk</router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'jenis_produk' }">Jenis Produk</router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'satuan_pembelian' }">Satuan Pembelian</router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'satuan_penjualan' }">Satuan Penjualan</router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'vendor' }">Vendor</router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="role === 'apoteker'">
                        <router-link :to="{ name: 'peramalan' }"><i class="icon-grafik"></i>Peramalan</router-link>
                    </li>
                    <li>
                        <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="icon-keluar"></i>Keluar
                        </a>
                        <form id="logout-form" action="/logout" method="POST" style="display: none;">
                            <input type="hidden" name="_token" :value="csrf_token">
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                csrf_token: $('meta[name="csrf-token"]').attr('content'),
                role: $('meta[name="user-role"]').attr('content'),
            }
        },
        mounted(){
            // $('#menu').metisMenu()
        }
    }
</script>