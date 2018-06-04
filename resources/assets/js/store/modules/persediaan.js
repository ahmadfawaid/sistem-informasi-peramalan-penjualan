import api from '../../api'

// state
const state = {
    persediaans: [],
    persediaan: {
        id: '',
        index: '',
        produk_id: '',
        stok: '',
        tanggal_kadaluarsa: ''
    },
    errors: {
        produk_id: '',
        stok: '',
        tanggal_kadaluarsa: ''
    },
    pagination: {
        current_page: '',
        per_page: '',
        from: '',
        to: '',
        total: '',
        last_page: ''
    },
    rakInfo:{
        id: '',
        nomor_rak: '',
        jumlah_produk: '',
        total_stok: ''
    },
    nomorRak: '',
    rakID: '',
    rak: [],
    produk: [],
    selected: [],
    perPage: 5,
    loading: false
}

// mutations
const mutations = {
    fetch(state, payload) {
        state.persediaans = payload.data
        state.pagination = {
            current_page: payload.current_page,
            per_page: payload.per_page,
            from: payload.from,
            to: payload.to,
            total: payload.total,
            last_page: payload.last_page 
        }
        state.rakID = state.persediaans[0].rak_id
    },
    fetchRak(state, payload) {
        state.rak = payload
    },
    fetchRakInfo(state, payload) {
        if(payload.length > 0) {
            var jumlah = []
            for (var i = 0; i < payload.length; i++) {
                if(jumlah.length > 0 ){
                    var cek = 0
                    var cek = jumlah.find(value => {
                        return value == payload[i].produk_id
                    })
                    var status = false
                    if(cek != undefined){
                        status = true
                    }
                    if(!status){
                        jumlah[i] = payload[i].produk_id
                    }
                }else{
                    jumlah[i] = payload[i].produk_id
                }
            }

            var total = 0
            for (var i = 0; i < payload.length; i++) {
                total += payload[i].stok
            }

            state.rakInfo = {
                id: payload[0].rak_id,
                nomor_rak: payload[0].nomor_rak,
                jumlah_produk: jumlah.length,
                total_stok: total
            }
        }
    },
    fetchProduk(state, payload) {
        state.produk = payload
    },
    setRakID(state, payload) {
        state.rakID = payload
    },
    setNomorRak(state, payload) {
        state.nomorRak = payload
    },
    setSelected(state, payload) {
        state.selected = payload
    },
    setPerPage(state, payload) {
        state.perPage = payload
    },
    setForm(state, payload) {
        state.persediaan = {
            id: payload.persediaan.id,
            index: payload.index,
            produk_id: payload.persediaan.produk_id,
            stok: payload.persediaan.stok,
            tanggal_kadaluarsa: payload.persediaan.tanggal_kadaluarsa
        }
    },
    emptyForm(state) {
        state.persediaan = {
            id: '',
            index: '',
            produk_id: '',
            stok: '',
            tanggal_kadaluarsa: ''
        }
        state.errors = {
            produk_id: '',
            stok: '',
            tanggal_kadaluarsa: ''
        }
    },
    setError(state, payload) {
        state.errors = payload
    },
    setErrorForm(state, payload) {
        if(payload.form == 'produk_id') {
            state.errors.produk_id = payload.error.produk_id
        }else if(payload.form == 'stok') {
            state.errors.stok = payload.error.stok
        }else if(payload.form == 'tanggal_kadaluarsa') {
            state.errors.tanggal_kadaluarsa = payload.error.tanggal_kadaluarsa
        }
    },
    setLoading(state, payload) {
        state.loading = payload
    }
}

// actions
const actions = {
    fetch({ commit }, payload) {
        commit('setLoading', true)
        setTimeout(() => {
            axios.get(api.persediaan + 'index/' + payload.nomorRak + '/' + payload.perPage).then(response => {
                commit('fetch', response.data)
            })
            axios.get(api.persediaan + 'getPerRak/' + payload.nomorRak).then(response => {
                commit('fetchRakInfo', response.data)
                commit('setLoading', false)
            })
        }, 500)
    },
    fetchPerPage({ commit }, payload) {
        axios.get(api.persediaan + 'index/' + payload.nomorRak + '/' + payload.perPage + '?page=' + payload.page).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
        })
    },
    fetchRak({ commit }) {
        axios.get(api.rak + 'getOptions').then(response => {
            commit('fetchRak', response.data)
        })
    },
    fetchProduk({ commit }) {
        axios.get(api.produk + 'getOptions').then(response => {
            commit('fetchProduk', response.data)
        })
    },
    store({ commit }, payload) {
        axios.post(api.persediaan + 'store/' + payload.nomorRak + '/' + payload.perPage, payload.persediaan).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
            $("#addModal").modal('hide')
            flash('berhasil menambah produk pada rak ' + payload.nomorRak, 'success')
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
        axios.get(api.persediaan + 'getPerRak/' + payload.nomorRak).then(response => {
            commit('fetchRakInfo', response.data)
        })
    },
    update({ commit }, payload) {
        axios.patch(api.persediaan + 'update/' +  payload.nomorRak + '/' + payload.perPage, payload.persediaan).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
            $("#editModal").modal('hide')
            flash('persediaan ' + payload.nomorRak + ' berhasil diperbarui', 'success')	
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
        axios.get(api.persediaan + 'getPerRak/' + payload.nomorRak).then(response => {
            commit('fetchRakInfo', response.data)
        })
    },
    move({ commit }, payload) {
        axios.post(api.persediaan + 'move/' + payload.newRakID + '/' + payload.nomorRak + '/' + payload.perPage, payload.selected).then(response => {
            commit('fetch', response.data)
            $("#moveModal").modal('hide')
            var text = payload.selected.length > 1 ? payload.selected.length + ' produk' : payload.selected[0].nama_produk
            flash('Berhasil memindah ' + text + ' dari rak ' + payload.nomorRak, 'success')	
            commit('setSelected', [])
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    destroy({ commit }, payload) {
        axios.post(api.persediaan + 'destroy/' + payload.nomorRak + '/' + payload.perPage, payload.selected).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
            $("#deleteModal").modal('hide')
            var text = payload.selected.length > 1 ? payload.selected.length + ' produk' : payload.selected[0].nama_produk
            flash(text + ' berhasil dihapus dari rak ' + payload.nomorRak, 'success')
        }).catch(error => {
            $("#deleteModal").modal('hide')
            flash('gagal menghapus data', 'error')
        })
    },
    checkForm({ commit }, payload) {
        axios.post(api.persediaan + 'checkForm/' + payload.form, payload.persediaan).then(response => {
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
    rakID(state) {
        return state.rakID
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}