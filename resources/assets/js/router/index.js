import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

// all
import Dashboard from '../components/dashboard/Index.vue'

// user
import Peramalan from '../components/peramalan/Index.vue'
import Pembelian from '../components/pembelian/Index.vue'
import PembelianAdd from '../components/pembelian/Add.vue'
import PembelianDetail from '../components/pembelian/Detail.vue'
import PembelianEdit from '../components/pembelian/Edit.vue'
import Penjualan from '../components/penjualan/Index.vue'
import PenjualanAdd from '../components/penjualan/Add.vue'
import PenjualanDetail from '../components/penjualan/Detail.vue'
import Persediaan from '../components/persediaan/Index.vue'
import PersediaanDetail from '../components/persediaan/detail/Index.vue'
import Produk from '../components/produk/Index.vue'
import JenisProduk from '../components/jenis_produk/Index.vue'
import SatuanPembelian from '../components/satuan_pembelian/Index.vue'
import SatuanPenjualan from '../components/satuan_penjualan/Index.vue'
import Vendor from '../components/vendor/Index.vue'

// admin
import User from '../components/user/Index.vue'
import DataPembelian from '../components/pembelian/Index.vue'
import DataPembelianDetail from '../components/pembelian/Detail.vue'
import DataPenjualan from '../components/penjualan/Index.vue'
import DataPenjualanDetail from '../components/penjualan/Detail.vue'
import DataPersediaan from '../components/persediaan/Index.vue'
import DataPersediaanDetail from '../components/persediaan/detail/Index.vue'

const routes = [
    //all
    { path: '/dashboard', name: 'dashboard', component: Dashboard },

    //user
    { path: '/peramalan', name: 'peramalan', component: Peramalan },
    { path: '/pembelian', name: 'pembelian', component: Pembelian },
    { path: '/pembelian/transaksi', name: 'pembelian-add', component: PembelianAdd },
    { path: '/pembelian/detail/:nomor_faktur', name: 'pembelian-detail', component: PembelianDetail },
    { path: '/pembelian/edit/:nomor_faktur', name: 'pembelian-edit', component: PembelianEdit },
    { path: '/penjualan', name: 'penjualan', component: Penjualan },
    { path: '/penjualan/transaksi', name: 'penjualan-add', component: PenjualanAdd },
    { path: '/penjualan/detail/:nomor_faktur', name: 'penjualan-detail', component: PenjualanDetail },
    { path: '/persediaan', name: 'persediaan', component: Persediaan },
    { path: '/persediaan/detail/:nomor_rak', name: 'persediaan-detail', component: PersediaanDetail },
    { path: '/produk', name: 'produk', component: Produk },
    { path: '/jenis', name: 'jenis_produk', component: JenisProduk },
    { path: '/satuan/pembelian', name: 'satuan_pembelian', component: SatuanPembelian },
    { path: '/satuan/penjualan', name: 'satuan_penjualan', component: SatuanPenjualan },
    { path: '/vendor', name: 'vendor', component: Vendor },

    // admin
    { path: '/user', name: 'user', component: User },
    { path: '/data-pembelian', name: 'data-pembelian', component: DataPembelian },
    { path: '/data-pembelian/detail/:nomor_faktur', name: 'data-pembelian-detail', component: DataPembelianDetail },
    { path: '/data-penjualan', name: 'data-penjualan', component: DataPenjualan },
    { path: '/data-penjualan/detail/:nomor_faktur', name: 'data-penjualan-detail', component: DataPenjualanDetail },
    { path: '/data-persediaan', name: 'data-persediaan', component: DataPersediaan },
    { path: '/data-persediaan/detail/:nomor_rak', name: 'data-persediaan-detail', component: DataPersediaanDetail },
]

export default new VueRouter ({
    mode: 'history',
    routes,
    saveScrollPosition: true,
    linkActiveClass: 'active'
})