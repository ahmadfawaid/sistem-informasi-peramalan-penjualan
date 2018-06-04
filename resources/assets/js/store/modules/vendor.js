import api from '../../api'

// state
const state = {
    vendors: [],
    vendor: {
        id: '',
        index: '',
        nama_vendor: '',
        kota: '',
        telepon: ''
    },
    errors: {
        nama_vendor: '',
        kota: '',
        telepon: ''
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
        state.vendors = payload.data
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
        state.vendors.splice(payload.index, 1, payload.response)
    },
    setSelected(state, payload) {
        state.selected = payload
    },
    setPerPage(state, payload) {
        state.perPage = payload
    },
    setForm(state, payload) {
        state.vendor = {
            id: payload.vendor.id,
            index: payload.index,
            nama_vendor: payload.vendor.nama_vendor,
            kota: payload.vendor.kota,
            telepon: payload.vendor.telepon
        }
    },
    emptyForm(state) {
        state.vendor = {
            id: '',
            index: '',
            nama_vendor: '',
            kota: '',
            telepon: ''
        }
        state.errors = {
            nama_vendor: '',
            kota: '',
            telepon: ''
        }
    },
    setError(state, payload) {
        state.errors = payload
    },
    setErrorForm(state, payload) {
        if(payload.form == 'nama_vendor') {
            state.errors.nama_vendor = payload.error.nama_vendor
        }else if(payload.form == 'kota') {
            state.errors.kota = payload.error.kota
        }else if(payload.form == 'telepon') {
            state.errors.telepon = payload.error.telepon
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
            axios.get(api.vendor + 'index/' + perPage).then(response => {
                commit('fetch', response.data)
                commit('setPerPage', perPage)
                commit('setLoading', false)
            })
        }, 500)
    },
    fetchPerPage({ commit }, payload) {
        axios.get(api.vendor + 'index/' + payload.perPage + '?page=' + payload.page).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
        })
    },
    store({ commit }, payload) {
        axios.post(api.vendor + 'store/' + payload.perPage, payload.vendor).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
            $("#addModal").modal('hide')
            flash('berhasil menambah data vendor', 'success')
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    update({ commit }, payload) {
        axios.patch(api.vendor + 'update/' + payload.id, payload).then(response => {
            commit('update', {index: payload.index, response: response.data})
            commit('setSelected', [])
            $("#editModal").modal('hide')
            flash('data vendor berhasil diperbarui', 'success')	
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    destroy({ commit }, payload) {
        axios.post(api.vendor + 'destroy/' + payload.perPage, payload.selected).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
            $("#deleteModal").modal('hide')
            var text = payload.selected.length > 1 ? payload.selected.length + ' vendor' : 'vendor ' + payload.selected[0].nama_vendor
            flash(text + ' berhasil dihapus', 'success')
        }).catch(error => {
            $("#deleteModal").modal('hide')
            flash('gagal menghapus data', 'error')
        })
    },
    checkForm({ commit }, payload) {
        axios.post(api.vendor + 'checkForm/' + payload.form, payload.vendor).then(response => {
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

}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}