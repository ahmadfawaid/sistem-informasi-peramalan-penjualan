import api from '../../api'

// state
const state = {
    jenis_produks: [],
    jenis_produk: {
        id: '',
        index: '',
        jenis: ''
    },
    errors: {
        jenis: ''
    },
    pagination: {
        current_page: '',
        per_page: '',
        from: '',
        to: '',
        total: '',
        last_page: ''
    },
    selected: [],
    perPage: 5,
    loading: false
}

// mutations
const mutations = {
    fetch(state, payload) {
        state.jenis_produks = payload.data
        state.pagination = {
            current_page: payload.current_page,
            per_page: payload.per_page,
            from: payload.from,
            to: payload.to,
            total: payload.total,
            last_page: payload.last_page 
        }
    },
    update(state, payload) {
        state.jenis_produks.splice(payload.index, 1, payload.response)
    },
    setSelected(state, payload) {
        state.selected = payload
    },
    setPerPage(state, payload) {
        state.perPage = payload
    },
    setForm(state, payload) {
        state.jenis_produk = {
            id: payload.jenis_produk.id,
            index: payload.index,
            jenis: payload.jenis_produk.jenis
        }
    },
    emptyForm(state) {
        state.jenis_produk = {
            id: '',
            index: '',
            jenis: ''
        }
        state.errors = {
            jenis: ''
        }
    },
    setError(state, payload) {
        state.errors = payload
    },
    setErrorForm(state, payload) {
        state.errors.jenis = payload.jenis
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
            axios.get(api.jenis_produk + 'index/' + perPage).then(response => {
                commit('fetch', response.data)
                commit('setPerPage', perPage)
                commit('setLoading', false)
            })
        }, 500)
    },
    fetchPerPage({ commit }, payload) {
        axios.get(api.jenis_produk + 'index/' + payload.perPage + '?page=' + payload.page).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
        })
    },
    store({ commit }, payload) {
        axios.post(api.jenis_produk + 'store/' + payload.perPage, payload.jenis_produk).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
            $("#addModal").modal('hide')
            flash('berhasil menambah data jenis produk', 'success')
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    update({ commit }, payload) {
        axios.patch(api.jenis_produk + 'update/' + payload.id, payload).then(response => {
            commit('update', {index: payload.index, response: response.data})
            commit('setSelected', [])
            $("#editModal").modal('hide')
            flash('data jenis produk berhasil diperbarui', 'success')	
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    destroy({ commit }, payload) {
        axios.post(api.jenis_produk + 'destroy/' + payload.perPage, payload.selected).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
            $("#deleteModal").modal('hide')
            var text = payload.selected.length > 1 ? payload.selected.length + ' jenis produk' : payload.selected[0].jenis
            flash(text + ' berhasil dihapus', 'success')
        }).catch(error => {
            $("#deleteModal").modal('hide')
            flash('gagal menghapus data', 'error')
        })
    },
    checkForm({ commit }, payload) {
        axios.post(api.jenis_produk + 'checkForm', payload).then(response => {
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