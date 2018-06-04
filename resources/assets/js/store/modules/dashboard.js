import api from '../../api'

// state
const state = {
    chart: {
        periode: [],
        penjualan: []
    },
    persediaan: {
        produk: '',
        total: ''
    },
    loading: false,
    loaded: false,
}

// mutations
const mutations = {
    fetchPenjualan(state, payload) {
        var periode = []
        var penjualan = []

        var month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']

        for(var i = 0; i < payload.periode.length; i++){
            var date = payload.periode[i].split('-')
            periode[i] = month[date[1] - 1].substr(0, 3) + ' ' + date[0]
            penjualan[i] = payload.penjualan[i].toString()
        }

        state.chart.periode = periode
        state.chart.penjualan = penjualan
    },
    fetchTotalPersediaan(state, payload) {
        state.persediaan.produk = payload[0].produk
        state.persediaan.total = payload[0].total
    },
    setLoaded(state, payload) {
        state.loaded = payload
    },
    setLoading(state, payload) {
        state.loading = payload
    },
}

// actions
const actions = {
    fetchPenjualan({ commit }) {
        commit('setLoading', true)
        setTimeout(() => {
            axios.get(api.penjualan + 'getPenjualan').then(response => {
                commit('fetchPenjualan', response.data)
                commit('setLoaded', true)
                commit('setLoading', false)
            })
        }, 1000)
    },
    fetchTotalPersediaan({ commit }) {
        axios.get(api.persediaan + 'getTotalPersediaan').then(response => {
            commit('fetchTotalPersediaan', response.data)
        })
    }
}

// getters
const getters = {

}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}