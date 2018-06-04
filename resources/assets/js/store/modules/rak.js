import api from '../../api'

// state
const state = {
    raks: [],
    rak: {
        id: '',
        index: '',
        nomor_rak: ''
    },
    errors: {
        nomor_rak: ''
    },
    loading: false
}

// mutations
const mutations = {
    fetch(state, payload) {
        state.raks = payload
    },
    push(state, payload) {
        state.raks.unshift(payload)
    },
    update(state, payload) {
        state.raks.splice(payload.index, 1, payload.response)
    },
    setForm(state, payload) {
        state.rak = {
            id: payload.rak.id,
            index: payload.index,
            nomor_rak: payload.rak.nomor_rak
        }
    },
    emptyForm(state) {
        state.rak = {
            id: '',
            index: '',
            nomor_rak: ''
        }
        state.errors = {
            nomor_rak: ''
        }
    },
    setError(state, payload) {
        state.errors = payload
    },
    setErrorForm(state, payload) {
        state.errors.nomor_rak = payload.nomor_rak
    },
    setLoading(state, payload) {
        state.loading = payload
    }
}

// actions
const actions = {
    fetch({ commit }) {
        commit('setLoading', true)
        setTimeout(() => {
            axios.get(api.rak + 'index').then(response => {
                commit('fetch', response.data)
                commit('setLoading', false)
            })
        }, 500)
    },
    store({ commit }, payload) {
        axios.post(api.rak + 'store', payload).then(response => {
            commit('push', response.data)
            $("#addModal").modal('hide')
            flash('berhasil menambah rak baru', 'success')
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    update({ commit }, payload) {
        axios.patch(api.rak + 'update/' + payload.id, payload).then(response => {
            commit('update', {index: payload.index, response: response.data})
            $("#editModal").modal('hide')
            flash('berhasil memperbarui nomor rak', 'success')	
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    destroy({ commit }, payload) {
        axios.get(api.rak + 'destroy/' + payload).then(response => {
            flash('Rak ' + payload + ' telah dihapus', 'success')
        }).catch(error => {
            flash('gagal menghapus data', 'error')
        })
    },
    checkForm({ commit }, payload) {
        axios.post(api.rak + 'checkForm', payload).then(response => {
            var error = ''
            commit('setErrorForm', error)
        }).catch(error => {
            var error = error.response.data.errors
            commit('setErrorForm', error)
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