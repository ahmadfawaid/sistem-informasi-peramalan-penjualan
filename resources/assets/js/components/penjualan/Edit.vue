<template>
    <div class="content penjualan">
        <div class="search-area">
            <div class="search-form">
                <i class="icon-cari"></i>
                <input v-model="searchText" type="text" class="input" placeholder="cari produk...">
            </div>
            <span v-if="loading" class="info">Sedang mengambil data...</span>
            <span v-else-if="filteredProduks.length > 0" class="info">Menampilkan {{ filteredProduks.length }} produk</span>
            <span v-else class="info">Produk '{{ searchText }}' tidak tersedia</span>
            <loading v-if="loading"></loading>
            <ul v-else class="search-results">
                <li v-for="item in filteredProduks" :key="item.id">
                    <div class="list" @click="addCart(item)">
                        <div class="product">
                            <span class="name">{{ item.nama_produk }}</span>
                            <span class="detail">{{ item.kode_produk }} | {{ item.stok }} {{ item.satuan.toLowerCase() }} tersedia</span>
                        </div>
                        <div class="add">
                            <i class="icon-tambah"></i>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="container">
            <topbar :title="title"></topbar>
            <div class="row">
                <div class="col col-12">
                    <div class="main-content row">
                        <div class="col" style="width: 70%;padding-right: 10px">
                            <div class="card row header" style="padding:0px; margin-bottom: 20px">
                                <div class="col col-6" style="padding: 20px">
                                    <span class="label">Nomor Faktur</span>
                                    <span class="value">{{ penjualan.nomor_faktur }}</span>
                                </div>
                                <div class="col col-6" style="padding: 20px; border-left: 1px solid #eaeaea">
                                    <span class="label">Tanggal</span>
                                    <span class="value">{{ penjualan.tanggal | tanggal }}</span>
                                </div>
                            </div>
                            <div class="card">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="nomor">No</th>
                                            <th style="width: 200px;">Produk</th>
                                            <th style="width: 50px;text-align: center;">Kuantitas</th>
                                            <th style="width: 100px">Harga</th>
                                            <th style="width: 120px">Subtotal</th>
                                            <th style="width: 30px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in penjualan.detail_penjualan" :key="index">
                                            <td class="nomor">{{ 1 + index }}</td>
                                            <td v-if="cekKuantitas[index]" style="min-width: 150px;"><a style="font-weight: 500">{{ item.nama_produk }}</a><span>{{ item.jenis_produk }} | <span style="color: #ff4949">{{ item.stok }} stok tersedia</span></span></td>
                                            <td v-else style="min-width: 150px;"><a style="font-weight: 500">{{ item.nama_produk }}</a><span>{{ item.kode_produk }} | {{ item.stok }} {{ item.satuan_produk.toLowerCase() }} tersedia</span></td>
                                            <td><input v-model="item.kuantitas" @input="cekStok(item.kuantitas, item.stok, item.nama_produk, index)" :class="{'has-error': cekKuantitas[index] || item.kuantitas == ''}" type="number" class="input" min="1" style="width: 50px;text-align: center;padding: 0;margin: 0 auto"></td>
                                            <td>{{ item.harga_satuan | rupiah }}</td>
                                            <td>{{ item.kuantitas * item.harga_satuan | rupiah }}</td>
                                            <td><a @click.prevent="removeCart(index)" href=""><i class="icon-hapus error" title="hapus"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col col-4" style="width: 30%;padding-left: 10px">
                            <div class="card right">
                                <div class="total">
                                    <span class="label">Total</span>
                                    <span class="value">{{ getTotal | rupiah }}</span>
                                </div>
                                <div class="bayar">
                                    <span class="label">Bayar</span>
                                    <input v-model="penjualan.jumlah_bayar" type="number" @keyup.enter="bayar" placeholder="0">
                                </div>
                            </div>
                            <button v-if="penjualan.detail_penjualan.length > 0 && penjualan.jumlah_bayar > 0 && cekKuantitas.length == 0 && getTotal > 0" class="button button-bayar" type="button" @click="bayar">Bayar</button>
                            <button v-else class="button button-bayar nonaktif" type="button" style="cursor: default">Bayar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <flash></flash>
    </div>
</template>

<script>
    import { mapState, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                title: 'Transaksi Penjualan',
                searchText: '',
                cekKuantitas: []
            }
        },
        mounted() {
            this.$store.dispatch('penjualan_store/fetchPersediaan')
            this.$store.commit('penjualan_store/emptyPenjualan')
            this.$store.dispatch('penjualan_store/fetchEditPenjualan', this.$route.params.nomor_faktur)
        },
        methods: {
            addCart(item) {
                if(this.checkCart(item.produk_id)){
                    var temp = {
                        produk_id: item.produk_id,
                        nama_produk: item.nama_produk,
                        jenis_produk: item.jenis,
                        satuan_produk: item.satuan,
                        stok: item.stok,
                        kuantitas: 1,
                        harga_satuan: item.harga_jual
                    }
                    this.penjualan.detail_penjualan.push(temp)
                    this.searchText = ''
                }else{
                    flash(item.nama_produk +' sudah ditambahkan', 'warning')
                }
            },
            removeCart(index) {
                this.penjualan.detail_penjualan.splice(index, 1)
            },
            checkCart(id) {
                var result = true
                for(var i = 0; i < this.penjualan.detail_penjualan.length; i++) {
                    if(id == this.penjualan.detail_penjualan[i].produk_id) {
                        result = false
                    }
                }
                return result
            },
            cekStok(kuantitas, stok, produk, index){
                if(parseInt(kuantitas) > parseInt(stok)) {
                    flash('kuantitas '+ produk +' melebihi stok yang ada', 'error')
                    return this.cekKuantitas[index] = produk
                }
                return this.cekKuantitas.splice(index, 1)
            },
            bayar() {
                if(this.checkPembayaran()) {
                    this.penjualan.user_id = $('meta[name="user-id"]').attr('content')
                    this.$store.dispatch('penjualan_store/store', {penjualan: this.penjualan, perPage: this.perPage})
                    this.$router.push({ name: 'penjualan' })
                }
            },
            checkPembayaran() {
                var selisih = this.penjualan.jumlah_bayar - this.penjualan.total
                var results = false
                if(this.penjualan.jumlah_bayar ==  0 ) {
                    flash('bayar dulu ya...', 'error')
                    results = false
                } else if(selisih < 0 ) {
                    flash('Uang pembayaran kurang ' + Math.abs(selisih), 'warning')
                    results = false
                } else if(this.cekKuantitas.length > 0 ) {
                    flash('Terdapat kuantitas yang dimasukkan melebihi stok', 'error')
                    results = false
                } else {
                    results = true
                }
                return results
            }
        },
        computed: {
            ...mapState('penjualan_store', {
                penjualan: state => state.penjualan,
                persediaan: state => state.persediaan,
                perPage: state => state.perPage,
                loading: state => state.loading
            }),
            ...mapGetters('penjualan_store', [
                'getTotal'
            ]),
            filteredProduks() {
                return this.persediaan.filter(item => { 
                    var kode_produk = item.kode_produk.toLowerCase().includes(this.searchText.toLowerCase())
                    var nama_produk = item.nama_produk.toLowerCase().includes(this.searchText.toLowerCase())
                    return kode_produk || nama_produk
                })
            }
        }
    }
</script>

<style lang="scss">
    input.has-error, input.has-error:focus {
        border-color:#ff4949;
    }
</style>
