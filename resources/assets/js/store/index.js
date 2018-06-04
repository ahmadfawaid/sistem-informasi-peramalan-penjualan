import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

// import modules
import dashboard_store from './modules/dashboard'
import peramalan_store from './modules/peramalan'
import pembelian_store from './modules/pembelian'
import penjualan_store from './modules/penjualan'
import persediaan_store from './modules/persediaan'
import rak_store from './modules/rak'
import produk_store from './modules/produk'
import jenis_produk_store from './modules/jenis_produk'
import satuan_pembelian_store from './modules/satuan_pembelian'
import satuan_penjualan_store from './modules/satuan_penjualan'
import vendor_store from './modules/vendor'
import user_store from './modules/user'

export default new Vuex.Store({
    state: {
        loadingGlobal: false
    },
    modules: {
        dashboard_store,
        peramalan_store,
        pembelian_store,
        penjualan_store,
        persediaan_store,
        rak_store,
        produk_store,
        jenis_produk_store,
        satuan_pembelian_store,
        satuan_penjualan_store,
        vendor_store,
        user_store
    }
})