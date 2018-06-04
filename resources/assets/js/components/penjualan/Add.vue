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
            <div class="topbar">
                <div class="page-title">
                    <a class="logo" @click="$router.go(-1)"><div class="back"><span class="icon-expand"></span></div><img class="img" src="/images/logo2.png" alt="Logo"/></a>
                </div>
                <div class="user-area">
                    <div class="user">
                        <div class="name">{{ user }}</div>
                        <span class="role">{{ role }}</span>
                    </div>
                    <img class="img" src="/images/avatar.png">
                </div>
            </div>
            <div class="row">
                <div class="col col-12">
                    <div class="main-content row">
                        <div class="col" style="width: 70%;padding-right: 10px">
                            <div class="card row header" style="padding:0px; margin-bottom: 20px">
                                <div class="col col-4" style="padding: 20px">
                                    <span class="label">Nomor Faktur</span>
                                    <span class="value">{{ penjualan.nomor_faktur }}</span>
                                </div>
                                <div class="col col-4" style="padding: 20px; border-left: 1px solid #eaeaea">
                                    <span class="label">Tanggal</span>
                                    <span class="value">{{ penjualan.tanggal | tanggal }}</span>
                                </div>
                                <div class="col col-4" style="padding: 20px; border-left: 1px solid #eaeaea">
                                    <span class="label">Petugas</span>
                                    <span class="value">{{ user }}</span>
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
                                            <td><input v-model="item.kuantitas" @input="cekStok(item.kuantitas, item.stok, item.nama_produk, index)" :class="{'has-error': cekKuantitas[index] || item.kuantitas == '' || item.kuantitas == 0}" type="number" class="input" min="1" style="width: 50px;text-align: center;padding: 0;margin: 0 auto"></td>
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
        <kembalianmodal></kembalianmodal>
    </div>
</template>

<script>
    import { mapState, mapGetters } from 'vuex'
    import KembalianModal from './KembalianModal'

    export default {
        data() {
            return {
                title: 'Transaksi Penjualan',
                searchText: '',
                cekKuantitas: [],
                user: $('meta[name="user-nama"]').attr('content'),
                role: $('meta[name="user-role"]').attr('content'),
            }
        },
        mounted() {
            this.$store.dispatch('penjualan_store/fetchPersediaan')
            this.$store.commit('penjualan_store/emptyPenjualan')
            this.$store.dispatch('penjualan_store/setNomorFaktur')
            this.$store.dispatch('penjualan_store/setTanggal')
        },
        methods: {
            addCart(item) {
                if(this.checkCart(item.produk_id)){
                    var temp = {
                        produk_id: item.produk_id,
                        kode_produk: item.kode_produk,
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
                    var kembalian = this.penjualan.jumlah_bayar - this.penjualan.total
                    this.penjualan.user_id = $('meta[name="user-id"]').attr('content')
                    this.$store.commit('penjualan_store/setKembalian', kembalian)
                    $("#kembalianModal").modal('show')
                }
            },
            checkPembayaran() {
                var selisih = this.penjualan.jumlah_bayar - this.penjualan.total
                var results = false
                if(this.penjualan.jumlah_bayar ==  0 ) {
                    flash('bayar dulu ya...', 'error')
                    results = false
                } else if(selisih < 0 ) {
                    flash('uang pembayaran kurang ' + Math.abs(selisih), 'warning')
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
        },
        components: {
            'kembalianmodal': KembalianModal
        }
    }
</script>

<style lang="scss" scoped>
    input.has-error, input.has-error:focus {
        border-color:#ff4949;
    }

    .page-title {
        .logo {
            display: flex;
            cursor: pointer;
        }
        .back {
            transform: rotate(90deg);
            width: 18px;
            height: 18px;
            align-self: center
        }
    }
</style>
