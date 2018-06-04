import api from '../../api'

// state
const state = {
    peramalan: [],
    chart: {
        periode: [],
        aktual: [],
        peramalan: []
    },
    produk: [],
    selectedProduk: [],
    loading: false,
}

// mutations
const mutations = {
    fetchPeramalan(state, payload) {
        state.peramalan = payload

        var periode = []
        var aktual = []
        var peramalan = []
        var alpha = []

        var month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']

        for(var i = 0; i < payload.hasil.length; i++){
            var date = payload.hasil[i].periode.split('-')
            periode[i] = month[date[1] - 1].substr(0, 3) + ' ' + date[0]
            if(i < payload.hasil.length - 1){
                aktual[i] = payload.hasil[i].aktual
            }else{
                aktual[i] = null
            }
            if(i == 0){
                peramalan[i] = null
            }else{
                peramalan[i] = parseFloat(payload.hasil[i].peramalan).toFixed(2)
            }
        }

        state.chart.periode = periode
        state.chart.aktual = aktual
        state.chart.peramalan = peramalan
        state.chart.alpha = alpha

        state.selectedProduk = payload.produk
    },
    fetchProduk(state, payload) {
        state.produk = payload
    },
    setLoading(state, payload) {
        state.loading = payload
    },
}

// actions
const actions = {
    fetchProduk({ commit }) {
        axios.get(api.produk + 'getOptions').then(response => {
            commit('fetchProduk', response.data)
        })
    },
    forecast({ commit }, payload) {
        commit('setLoading', true)
        setTimeout(() => {
            axios.post(api.peramalan, payload).then(response => {
                commit('fetchPeramalan', response.data)
                commit('setLoading', false)
                console.log(response.data)
            }).catch(error => {
                commit('setLoading', false)
                commit('setError', error.response.data.errors)
            })
        }, 1000)
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