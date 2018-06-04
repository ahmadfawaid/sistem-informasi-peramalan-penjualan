import api from '../../api'

// state
const state = {
    produks: [],
    produk: {
        id: '',
        index: '',
        kode_produk: '',
        nama_produk: '',
        jenis_produk_id: '',
        satuan_pembelian_id: '',
        isi: '',
        satuan_penjualan_id: '',
        harga_beli: '',
        harga_jual: '',
        stok_minimal: ''
    },
    errors: {
        kode_produk: '',
        nama_produk: '',
        jenis_produk_id: '',
        satuan_pembelian_id: '',
        isi: '',
        satuan_penjualan_id: '',
        harga_beli: '',
        harga_jual: '',
        stok_minimal: ''
    },
    pagination: {
        current_page: '',
        per_page: '',
        from: '',
        to: '',
        total: '',
        last_page: ''
    },
    jenisProduk: [],
    satuanPembelian: [],
    satuanPenjualan: [],
    selected: [],
    perPage: 10,
    loading: false
}

// mutations
const mutations = {
    fetch(state, payload) {
        state.produks = payload.data
        state.pagination = {
            current_page: payload.current_page,
            per_page: payload.per_page,
            from: payload.from,
            to: payload.to,
            total: payload.total,
            last_page: payload.last_page 
        }
    },
    fetchJenisProduk(state, payload) {
        state.jenisProduk = payload
    },
    fetchSatuanPembelian(state, payload) {
        state.satuanPembelian = payload
    },
    fetchSatuanPenjualan(state, payload) {
        state.satuanPenjualan = payload
    },
    update(state, payload) {
        state.produks.splice(payload.index, 1, payload.response)
    },
    setSelected(state, payload) {
        state.selected = payload
    },
    setPerPage(state, payload) {
        state.perPage = payload
    },
    setForm(state, payload) {
        state.produk = {
            id: payload.produk.id,
            index: payload.index,
            kode_produk: payload.produk.kode_produk,
            nama_produk: payload.produk.nama_produk,
            jenis_produk_id: payload.produk.jenis_produk_id,
            satuan_pembelian_id: payload.produk.satuan_pembelian_id,
            isi: payload.produk.isi,
            satuan_penjualan_id: payload.produk.satuan_penjualan_id,
            harga_beli: payload.produk.harga_beli,
            harga_jual: payload.produk.harga_jual,
            stok_minimal: payload.produk.stok_minimal
        }
    },
    emptyForm(state) {
        state.produk = {
            id: '',
            index: '',
            kode_produk: '',
            nama_produk: '',
            jenis_produk_id: '',
            satuan_pembelian_id: '',
            isi: '',
            satuan_penjualan_id: '',
            harga_beli: '',
            harga_jual: '',
            stok_minimal: ''
        }
        state.errors = {
            kode_produk: '',
            nama_produk: '',
            jenis_produk_id: '',
            satuan_pembelian_id: '',
            isi: '',
            satuan_penjualan_id: '',
            harga_beli: '',
            harga_jual: '',
            stok_minimal: ''
        }
    },
    setError(state, payload) {
        state.errors = payload
    },
    setErrorForm(state, payload) {
        if(payload.form == 'kode_produk') {
            state.errors.kode_produk = payload.error.kode_produk
        }else if(payload.form == 'nama_produk') {
            state.errors.nama_produk = payload.error.nama_produk
        }else if(payload.form == 'jenis_produk_id') {
            state.errors.jenis_produk_id = payload.error.jenis_produk_id
        }else if(payload.form == 'satuan_pembelian_id') {
            state.errors.satuan_pembelian_id = payload.error.satuan_pembelian_id
        }else if(payload.form == 'isi') {
            state.errors.isi = payload.error.isi
        }else if(payload.form == 'satuan_penjualan_id') {
            state.errors.satuan_penjualan_id = payload.error.satuan_penjualan_id
        }else if(payload.form == 'harga_beli') {
            state.errors.harga_beli = payload.error.harga_beli
        }else if(payload.form == 'harga_jual') {
            state.errors.harga_jual = payload.error.harga_jual
        }else if(payload.form == 'stok_minimal') {
            state.errors.stok_minimal = payload.error.stok_minimal
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
            axios.get(api.produk + 'index/' + perPage).then(response => {
                commit('fetch', response.data)
                commit('setPerPage', perPage)
                commit('setLoading', false)
            })
        }, 500)
    },
    fetchPerPage({ commit }, payload) {
        axios.get(api.produk + 'index/' + payload.perPage + '?page=' + payload.page).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
        })
    },
    fetchJenisProduk({ commit }) {
        axios.get(api.jenis_produk + 'getOptions').then(response => {
            commit('fetchJenisProduk', response.data)
        })
    },
    fetchSatuanPembelian({ commit }) {
        axios.get(api.satuan_pembelian + 'getOptions').then(response => {
            commit('fetchSatuanPembelian', response.data)
        })
    },
    fetchSatuanPenjualan({ commit }) {
        axios.get(api.satuan_penjualan + 'getOptions').then(response => {
            commit('fetchSatuanPenjualan', response.data)
        })
    },
    store({ commit }, payload) {
        axios.post(api.produk + 'store/' + payload.perPage, payload.produk).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
            $("#addModal").modal('hide')
            flash('berhasil menambah data produk', 'success')
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    update({ commit }, payload) {
        axios.patch(api.produk + 'update/' + payload.id, payload).then(response => {
            commit('update', {index: payload.index, response: response.data})
            commit('setSelected', [])
            $("#editModal").modal('hide')
            flash('data produk berhasil diperbarui', 'success')	
        }).catch(error => {
            commit('setError', error.response.data.errors)
        })
    },
    destroy({ commit }, payload) {
        axios.post(api.produk + 'destroy/' + payload.perPage, payload.selected).then(response => {
            commit('fetch', response.data)
            commit('setSelected', [])
            $("#deleteModal").modal('hide')
            var text = payload.selected.length > 1 ? payload.selected.length + ' produk' : payload.selected[0].nama_produk
            flash(text + ' berhasil dihapus', 'success')
        }).catch(error => {
            $("#deleteModal").modal('hide')
            flash('gagal menghapus data', 'error')
        })
    },
    checkForm({ commit }, payload) {
        axios.post(api.produk + 'checkForm/' + payload.form, payload.produk).then(response => {
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
    getKodeProduk(state) {
        if(state.produk.jenis_produk_id != '') {
            var id = 0, jenis
            if(state.produks.length > 0) {
                if(state.produk.id != '') {
                    id = state.produk.id
                }else{
                    id = state.produks[0].id + 1
                }
            }else{
                id = 1
            }

            if(id < 10) {
                id = '0' + id
            }

            if(state.produk.jenis_produk_id < 10) {
                jenis = '0' + state.produk.jenis_produk_id
            } else {
                jenis = state.produk.jenis_produk_id
            }

            return state.produk.kode_produk = 'P' + id + '.' + jenis
        }
    }
    // getKodeProduk(state) {
    //     if(state.produk.jenis_produk_id != '' && state.produk.satuan_penjualan_id != '') {
    //         var id = 0, jenis, satuan
    //         if(state.produks.length > 0) {
    //             if(state.produk.id != '') {
    //                 id = state.produk.id
    //             }else{
    //                 id = state.produks[0].id + 1
    //             }
    //         }else{
    //             id = 1
    //         }

    //         if(id < 10) {
    //             id = '0' + id
    //         }

    //         if(state.produk.jenis_produk_id < 10) {
    //             jenis = '0' + state.produk.jenis_produk_id
    //         } else {
    //             jenis = state.produk.jenis_produk_id
    //         }

    //         if(state.produk.satuan_penjualan_id < 10) {
    //             satuan = '0' + state.produk.satuan_penjualan_id
    //         } else {
    //             satuan = state.produk.satuan_penjualan_id
    //         }

    //         return state.produk.kode_produk = 'p' + id + '.' + jenis + '.' + satuan
    //     }
    // }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}