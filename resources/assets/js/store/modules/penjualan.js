import api from '../../api'

// state
const state = {
    penjualans: [],
    penjualan: {
        id: '',
        index: '',
        nomor_faktur: '',
        tanggal: '',
        jumlah_bayar: '',
        total: '',
        user_id: '',
        user: [],
        detail_penjualan: []
    },
    detailPenjualan: [],
    persediaan: [],
    pagination: [],
    perPage: 10,
    loading: false,
    kembalian: 0
}

// mutations
const mutations = {
    fetch(state, payload) {
        state.penjualans = payload.data
        state.pagination = {
            current_page: payload.current_page,
            per_page: payload.per_page,
            from: payload.from,
            to: payload.to,
            total: payload.total,
            last_page: payload.last_page 
        }
    },
    fetchPersediaan(state, payload) {
        state.persediaan = payload
    },
    fetchDetailPenjualan(state, payload) {
        state.penjualan = payload.penjualan
        state.penjualan.nomor_faktur = payload.penjualan.nomor_faktur
        state.penjualan.tanggal = payload.penjualan.tanggal
        state.penjualan.nama_user = payload.penjualan.user.nama
        state.penjualan.jumlah_bayar = payload.penjualan.jumlah_bayar
        state.penjualan.total = payload.penjualan.total
        state.detailPenjualan = payload.detail
    },
    setNomorFaktur(state, payload) {
        state.penjualan.nomor_faktur = payload
    },
    setTanggal(state, payload) {
        state.penjualan.tanggal = payload
    },
    emptyPenjualan(state) {
        state.penjualan= {
            id: '',
            index: '',
            nomor_faktur: '',
            tanggal: '',
            jumlah_bayar: '',
            total: '',
            user_id: '',
            user: [],
            detail_penjualan: []
        }
    },
    setPerPage(state, payload) {
        state.perPage = payload
    },
    setKembalian(state, payload) {
        state.kembalian = payload
    },
    setLoading(state, payload) {
        state.loading = payload
    }
}

// actions
const actions = {
    fetch({ commit }, perPage) {
        commit('setLoading', true)
        setTimeout(() => {
            axios.get(api.penjualan + 'index/' + perPage).then(response => {
                commit('fetch', response.data)
                commit('setLoading', false)
            })
        }, 500)
    },
    emptyPembelian(state) {
        state.pembelian= {
            id: '',
            nomor_faktur: '',
            tanggal: '',
            jumlah_bayar: '',
            total: '',
            user_id: '',
            user: [],
            detail_penjualan: []
        }
    },
    fetchPerPage({ commit }, payload) {
        axios.get(api.penjualan + 'index/' + payload.perPage + '?page=' + payload.page).then(response => {
            commit('fetch', response.data)
        })
    },
    fetchDetailPenjualan({ commit }, payload) {
        commit('setLoading', true)
        setTimeout(() => {
            axios.get(api.penjualan + 'detail/' + payload).then(response => {
                commit('fetchDetailPenjualan', response.data)
                commit('setLoading', false)
            })
        }, 500)
    },
    fetchPersediaan({ commit }) {
        commit('setLoading', true)
        setTimeout(() => {
            axios.get(api.persediaan + 'getList').then(response => {
                commit('fetchPersediaan', response.data)
                commit('setLoading', false)
            })
        }, 2000)
        
    },
    setNomorFaktur({ commit }) {
        axios.get(api.penjualan + 'getNomorFaktur').then(response => {
            commit('setNomorFaktur', response.data)
        })
    },
    setTanggal({ commit }) {
        var now = new Date(); 
        var date = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate()
        commit('setTanggal', date)
    },
    store({ commit }, payload) {
        axios.post(api.penjualan + 'store/' + payload.perPage, payload.penjualan).then(response => {
            commit('fetch', response.data)
            // console.log(response.data)
            var kembali = payload.penjualan.jumlah_bayar - payload.penjualan.total
            if(kembali > 0) {
                flash('transaksi sukses', 'success')
            }else{
                flash('transaksi sukses', 'success')
            }
        }).catch(error => {
            // commit('setError', error.response.data.errors)
        })
    },
    // update({ commit }, payload) {
    //     axios.patch(api.pembelian + 'update/' + payload.perPage, payload.pembelian).then(response => {
    //         commit('fetch', response.data)
    //         flash('berhasil memperbarui transaksi pembelian', 'success')
    //     }).catch(error => {
    //         commit('setError', error.response.data.errors)
    //     })
    // },
    // checkForm({ commit }, payload) {
    //     axios.post(api.pembelian + 'checkForm/' + payload.form, payload.pembelian).then(response => {
    //         var error = ''
    //         commit('setErrorForm', {form: payload.form, error: error})
    //     }).catch(error => {
    //         var error = error.response.data.errors
    //         commit('setErrorForm', {form: payload.form, error: error})
    //     })
    // }
}

// getters
const getters = {
    getTotal: state => {
        var total = 0
        var data = state.penjualan.detail_penjualan
        for (var i = 0; i < data.length; i++) {
            total += data[i].kuantitas * data[i].harga_satuan
        }
        return state.penjualan.total = total
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}