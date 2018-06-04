import api from '../../api'

// state
const state = {
    users: [],
    user: {
        id: '',
        index: '',
        nama: '',
        username: '',
        email: '',
        status: ''
    },
    errors: {
        nama: '',
        username: '',
        email: ''
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
        state.users = payload.data
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
        state.users.splice(payload.index, 1, payload.response)
    },
    setPerPage(state, payload) {
        state.perPage = payload
    },
    setForm(state, payload) {
        state.user = {
            id: payload.user.id,
            index: payload.index,
            nama: payload.user.nama,
            username: payload.user.username,
            email: payload.user.email,
            status: payload.user.status
        }
    },
    emptyForm(state) {
        state.user = {
            id: '',
            index: '',
            nama: '',
            username: '',
            email: '',
        }
        state.errors = {
            nama: '',
            username: '',
            email: ''
        }
    },
    setError(state, payload) {
        state.errors = payload
    },
    setErrorForm(state, payload) {
        if(payload.form == 'nama') {
            state.errors.nama = payload.error.nama
        }else if(payload.form == 'username') {
            state.errors.username = payload.error.username
        }else if(payload.form == 'email') {
            state.errors.email = payload.error.email
        }
    },
    setLoading(state, param) {
        state.loading = param
    }
}

// actions
const actions = {
    fetch({ commit }, perPage) {
        commit('setLoading', true)
        setTimeout(() => {
            axios.get(api.user + 'index/' + perPage).then(response => {
                commit('fetch', response.data)
                commit('setPerPage', perPage)
                commit('setLoading', false)
            })
        }, 500)
    },
    fetchPerPage({ commit }, payload) {
        axios.get(api.user + 'index/' + payload.perPage + '?page=' + payload.page).then(response => {
            commit('fetch', response.data)
        })
    },
    store({ commit }, payload) {
        axios.post(api.user + 'store/' + payload.perPage, payload.user).then(response => {
            commit('fetch', response.data)
            $("#addModal").modal('hide')
            flash('berhasil menambah ' + payload.pengguna.nama, 'success')
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    update({ commit }, payload) {
        axios.patch(api.user + 'update/' + payload.id, payload).then(response => {
            commit('update', {index: payload.index, response: response.data})
            $("#editModal").modal('hide')
            flash('data pengguna berhasil diperbarui', 'success')	
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    setStatus({ commit }, payload) {
        axios.post(api.user + 'setStatus/' + payload.id, payload).then(response => {
            console.log(payload.status)
            commit('update', {index: payload.index, response: response.data})
            $("#statusModal").modal('hide')
            console.log(response.data)
            if(response.data.status == 1) {
                flash(payload.nama + ' telah diaktifkan', 'success')
            }else{
                flash(payload.nama + ' telah dinonaktifkan', 'success')
            }	
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    checkForm({ commit }, payload) {
        console.log(payload)
        axios.post(api.user + 'checkForm/' + payload.form, payload.user).then(response => {
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