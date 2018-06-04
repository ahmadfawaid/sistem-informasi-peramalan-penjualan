import api from '../../api'

// state
const state = {
    pembelians: [],
    pembelian: {
        id: '',
        nomor_faktur: '',
        vendor_id: '',
        tanggal: '',
        total: '',
        detail_pembelian: [],
        user_id: ''
    },
    detailPembelian: [],
    errors: {
        nomor_faktur: '',
        vendor_id: '',
        tanggal: '',
    },
    produk: [],
    vendor: [],
    rak: [],
    pagination: [],
    perPage: 10,
    loading: false
}

// mutations
const mutations = {
    fetch(state, payload) {
        state.pembelians = payload.data
        state.pagination = {
            current_page: payload.current_page,
            per_page: payload.per_page,
            from: payload.from,
            to: payload.to,
            total: payload.total,
            last_page: payload.last_page 
        }
    },
    fetchProduk(state, payload) {
        state.produk = payload
    },
    fetchVendor(state, payload) {
        state.vendor = payload
    },
    fetchRak(state, payload) {
        state.rak = payload
    },
    init(state) {
        state.pembelian.detail_pembelian = [{
            id: 1,
            produk_id: "",
            kuantitas: 1,
            harga_satuan: 0
        }]
    },
    fetchPembelian(state, payload) {
        state.pembelian = payload
    },
    fetchDetailPembelian(state, payload) {
        state.pembelian = payload.pembelian
        state.pembelian.nama_vendor = payload.pembelian.vendor.nama_vendor
        state.pembelian.nama_user = payload.pembelian.user.nama
        state.detailPembelian = payload.detail
    },
    emptyPembelian(state, payload) {
        state.pembelian= {
            id: '',
            nomor_faktur: '',
            vendor_id: '',
            tanggal: '',
            total: '',
            detail_pembelian: [],
            user_id: payload
        }

        state.errors = {
            id: '',
            nomor_faktur: '',
            vendor_id: '',
            tanggal: '',
            total: '',
            detail_pembelian: [],
        }
    },
    setPerPage(state, payload) {
        state.perPage = payload
    },
    setError(state, payload) {
        state.errors = payload
    },
    setErrorForm(state, payload) {
        if(payload.form == 'vendor_id') {
            state.errors.vendor_id = payload.error.vendor_id
        }else if(payload.form == 'nomor_faktur') {
            state.errors.nomor_faktur = payload.error.nomor_faktur
        }else if(payload.form == 'tanggal') {
            state.errors.tanggal = payload.error.tanggal
        }
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
            axios.get(api.pembelian + 'index/' + perPage).then(response => {
                commit('fetch', response.data)
                commit('setLoading', false)
            })
        }, 500)
    },
    fetchPerPage({ commit }, payload) {
        axios.get(api.pembelian + 'index/' + payload.perPage + '?page=' + payload.page).then(response => {
            commit('fetch', response.data)
        })
    },
    fetchDetailPembelian({ commit }, payload) {
        commit('setLoading', true)
        setTimeout(() => {
            axios.get(api.pembelian + 'detail/' + payload).then(response => {
                commit('fetchDetailPembelian', response.data)
                commit('setLoading', false)
            })
        }, 500)
    },
    fetchEditPembelian({ commit }, payload) {
        commit('setLoading', true)
        setTimeout(() => {
            axios.get(api.pembelian + 'edit/' + payload).then(response => {
                commit('fetchPembelian', response.data)
                commit('setLoading', false)
            })
        }, 500)
    },
    fetchProduk({ commit }) {
        axios.get(api.produk + 'getOptions').then(response => {
            commit('fetchProduk', response.data)
        })
    },
    fetchVendor({ commit }) {
        axios.get(api.vendor + 'getOptions').then(response => {
            commit('fetchVendor', response.data)
        })
    },
    fetchRak({ commit }) {
        axios.get(api.rak + 'getOptions').then(response => {
            commit('fetchRak', response.data)
        })
    },
    store({ commit }, payload) {
        axios.post(api.pembelian + 'store/' + payload.rakID + '/' + payload.perPage, payload.pembelian).then(response => {
            commit('fetch', response.data)
            flash('berhasil menambah transaksi pembelian', 'success')
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    skip({ commit }, payload) {
        axios.post(api.pembelian + 'skip/' + payload.perPage, payload.pembelian).then(response => {
            commit('fetch', response.data)
            flash('berhasil menambah transaksi pembelian', 'success')
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    update({ commit }, payload) {
        axios.patch(api.pembelian + 'update/' + payload.perPage, payload.pembelian).then(response => {
            commit('fetch', response.data)
            flash('berhasil memperbarui transaksi pembelian', 'success')
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    checkForm({ commit }, payload) {
        axios.post(api.pembelian + 'checkForm/' + payload.form, payload.pembelian).then(response => {
            var error = ''
            commit('setErrorForm', {form: payload.form, error: error})
        }).catch(error => {
            var error = error.response.data.errors
            commit('setErrorForm', {form: payload.form, error: error})
        })
    }
}

// getters
const getters = {
    getTotal: state => {
        var total = 0
        var data = state.pembelian.detail_pembelian
        if(data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                total += data[i].kuantitas * data[i].harga_satuan
            }
        }
        return state.pembelian.total = total
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}