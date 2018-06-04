<template>
    <div class="content pembelian">
        <div class="container">
            <topbar :title="title"></topbar>
            <loading v-if="loading"></loading>
            <div v-else class="row">
                <div class="col col-11">
                    <div class="card custom">
                        <span class="title" style="margin-bottom: 20px;display: block;">Nomor Faktur {{ pembelian.nomor_faktur }} ({{ pembelian.detail_pembelian_count }})</span>
                        <div class="row">
                            <div class="col col-5" style="padding-right: 10px">
                                <div class="form-group">
                                    <label class="label">Nama Vendor</label>
                                    <search-select v-model="pembelian.vendor_id" :options="vendor" placeholder="Pilih Vendor"></search-select>
                                    <span v-if="errors.vendor_id" class="help error">{{ errors.vendor_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col col-4" style="padding: 0px 10px">
                                <div class="form-group">
                                    <label class="label">Nomor Faktur</label>
                                    <input v-model="pembelian.nomor_faktur" type="text" class="input" @change="checkForm('nomor_faktur')">
                                    <span v-if="errors.nomor_faktur" class="help error">{{ errors.nomor_faktur[0] }}</span>
                                </div>
                            </div>
                            <div class="col col-3" style="padding-left: 10px">
                                <div class="form-group">
                                    <label class="label">Tanggal Pembelian</label>
                                    <input v-model="pembelian.tanggal" type="text" onfocus="(this.type='date')" onfocusout="(this.type='text')" class="input" @change="checkForm('tanggal')">
                                    <span v-if="errors.tanggal" class="help error">{{ errors.tanggal[0] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="padding: 25px 40px 40px">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="">Produk</th>
                                    <th style="width: 70px">Kuantitas</th>
                                    <th style="width: 175px">Harga</th>
                                    <th style="width: 175px">Subtotal</th>
                                    <th v-if="pembelian.detail_pembelian.length > (pembelian.detail_pembelian.length - point)" style="width: 30px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in pembelian.detail_pembelian" :key="index">
                                    <td class="nomor">{{ 1 + index }}</td>
                                    <td><search-select v-model="item.produk_id" :options="produk" placeholder="Pilih Produk"></search-select></td>
                                    <td v-if="item.produk_id == ''"><input v-model="item.kuantitas" type="number" class="input disabled" min="1" style="text-align:center"></td>
                                    <td v-else><input v-model="item.kuantitas" type="number" class="input" min="1" style="text-align:center"></td>
                                    <td v-if="item.produk_id == ''"><input v-model="item.harga_satuan" type="number" class="input disabled"></td>
                                    <td v-else><input v-model="item.harga_satuan" type="number" class="input"></td>
                                    <td v-if="item.produk_id == ''"><input type="text" class="input disabled" :value="item.kuantitas * item.harga_satuan | rupiah" readonly></td>
                                    <td v-else><input type="text" class="input" :value="item.kuantitas * item.harga_satuan | rupiah" readonly></td>
                                    <td v-if="pembelian.detail_pembelian.length > (pembelian.detail_pembelian.length - point)"><a @click.prevent="removeLine(index)" href=""><i class="icon-hapus error" title="hapus"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="footer">
                            <div class="left">
                                <button type="button" class="button-icon success" title="tambah" @click="newLine"><i class="icon-tambah"></i></button>
                                <button class="button" type="submit" @click="update"><i class="icon-sukses"></i>Simpan</button>
                                <router-link :to="{ name: 'pembelian' }" class="cancel">Batal</router-link>
                            </div>
                            <div class="right">
                                <span>Total</span>
                                <div class="total">{{ getTotal | rupiah }}</div>
                            </div>
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
    import { ModelSelect } from 'vue-search-select'

    export default {
        data() {
            return {
                title: 'Transaksi Pembelian',
                point: 0,
            }
        },
        mounted() {
            this.$store.dispatch('pembelian_store/fetchProduk')
            this.$store.dispatch('pembelian_store/fetchVendor')
            this.$store.dispatch('pembelian_store/fetchEditPembelian', this.$route.params.nomor_faktur)
        },
        methods: {
            update() {
                this.$store.dispatch('pembelian_store/update', {pembelian: this.pembelian, perPage: this.perPage})
                this.$router.push({ name: 'pembelian'})
            },
            openModal(modal) {
                $("#" + modal + "Modal").modal('show')
            },
            newLine() {
                var temp = {
                    produk_id: "",
                    kuantitas: 1,
                    harga_satuan: 0
                }
                this.pembelian.detail_pembelian.push(temp)
                this.point += 1
            },
            removeLine(index) {
                var n = this.pembelian.detail_pembelian.length - this.point
                if(this.pembelian.detail_pembelian.length > n) {
                    this.pembelian.detail_pembelian.splice(index, 1)
                    this.point -= 1
                }
            },
            checkForm(form) {
                this.$store.dispatch('pembelian_store/checkForm', {form: form, pembelian: this.pembelian})
            }
        },
        computed: {
            ...mapState('pembelian_store', {
                pembelian: state => state.pembelian,
                errors: state => state.errors,
                produk: state => state.produk,
                vendor: state => state.vendor,
                perPage: state => state.perPage,
                loading: state => state.loading
            }),
            ...mapGetters('pembelian_store', [
                'getTotal'
            ])
        },
        watch: {
            'pembelian.vendor_id': function(oldVal) {
                if(oldVal !== '') {
                    this.checkForm('vendor_id')
                }
            },
        },
        components: {
            'search-select': ModelSelect
        }
    }
</script>

<style lang="scss" scoped>
    .input.disabled {
        background: #ddd;
    }

    .footer {
        .left {
            display: flex;
            line-height: 40px;
        }

        button[type="submit"] {
            margin: 0px 12px;
        }

        .button-icon {
            background: #13ce66;
            color: #fff;
            box-shadow: 0px 5px 5px 0 rgba(0, 0, 0, 0.15)
        }

        .cancel {
            color: #465368;
            font-weight: 500;
            opacity: 0.7;
        }

        .right {
            margin-right: 10px;

            span {
                opacity: 0.7;
                font-weight: 500 !important;
                font-size: 13px !important;
            }

            .total {
                font-weight: 500;
                font-size: 24px;
                color: #13ce66;
            }
        }
    }
</style>