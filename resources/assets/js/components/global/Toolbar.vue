<template>
    <div class="toolbar">
        <div class="left">
            <router-link v-if="page == 'pembelian' && role == 'apoteker'" :to="{ name: 'pembelian-add' }" class="button"><i class="icon-tambah"></i>Transaksi Baru</router-link>
            <router-link v-else-if="page == 'penjualan' && role == 'apoteker'" :to="{ name: 'penjualan-add' }" class="button"><i class="icon-tambah"></i>Transaksi Baru</router-link>
            <button v-else-if="role == 'manager' && page != 'user'" type="button" class="button" @click="openModal('add')"><i class="icon-cetak"></i>Cetak</button>
            <button v-else-if="page == 'user' && role == 'manager'" type="button" class="button" @click="openModal('add')"><i class="icon-tambah"></i>Tambah</button>
            <button v-else type="button" class="button" @click="openModal('add')"><i class="icon-tambah"></i>Tambah</button>
            <button v-if="page != 'user' && role == 'apoteker'" type="button" class="button-icon success" title="cetak"><i class="icon-cetak"></i></button>
            <button v-if="nomorRak && role == 'apoteker'" type="button" class="button-icon warning" title="pindah persediaan" :disabled="disableAction" @click="openModal('move')"><i class="icon-transaksi"></i></button>
            <button v-if="page != 'pembelian' && page != 'penjualan' && page != 'user' && role == 'apoteker'" type="button" class="button-icon error" title="hapus" :disabled="disableAction" @click="openModal('delete')"><i class="icon-hapus"></i></button>
        </div>
        <div class="right">
            <div class="select">
                <span>Menampilkan</span>
                <select v-model="showPerPage" @change="changePerPage">
                    <option value="5">5 item</option>
                    <option value="10">10 item</option>
                    <option value="25">25 item</option>
                    <option value="50">50 item</option>
                    <option value="100">100 item</option>
                </select>
                <i class="icon-expand"></i>
            </div>
            <div class="search-field">
                <input type="text" placeholder="cari data...">
                <i class="icon-cari"></i>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        props: ['page', 'selected', 'perPage', 'nomorRak'],
        data() {
            return {
                role: $('meta[name="user-role"]').attr('content'),
            }
        },
        methods: {
            changePerPage(e) {
                if(this.page == 'persediaan') {
                    this.$store.dispatch(this.page + '_store/fetch', {nomorRak: this.nomorRak, perPage: e.target.value})
                }else{
                    this.$store.dispatch(this.page + '_store/fetch', e.target.value)
                }
            },
            openModal(modal) {
                $("#" + modal + "Modal").modal('show')
                this.$store.commit(this.page + '_store/emptyForm')
            }
        },
        computed: {
            showPerPage: {
                get() {
                    return this.perPage
                },
                set(value) {
                    this.$store.commit(this.page + '_store/setPerPage', value)
                }
            },
            disableAction() {
                if(this.page != 'pembelian' && this.page != 'penjualan') {
                    return this.selected.length > 0 ? false : true
                }
            }
        }
    }
</script>