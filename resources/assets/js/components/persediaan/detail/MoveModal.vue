<template>
    <div aria-hidden="true" class="modal fade delete move" id="moveModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="move()">
                    <div class="modal-header">
                        <i class="icon icon-transaksi"></i>
                        <span class="modal-title">Memindah Produk</span>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label v-if="selected.length > 1" class="label">Pindahkan {{ selected.length }} Produk Ke</label>
                            <label v-if="selected.length == 1" class="label">Pindahkan {{ selected[0].nama_produk }} Ke</label>
                            <search-select v-model="moveTo" :options="rak"></search-select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-if="moveStatus" class="button" type="submit">Pindahkan</button>
                        <button v-else class="button disabled" type="submit" disabled>Pindahkan</button>
                        <span class="cancel" data-dismiss="modal">Batal</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapGetters } from 'vuex'
    import { ModelSelect } from 'vue-search-select'

    export default {
        mounted() {
            this.$store.dispatch('persediaan_store/fetchRak')
        },
        methods: {
            move() {
                this.$store.dispatch('persediaan_store/move', {newRakID: this.moveTo, nomorRak: this.nomorRak, selected: this.selected, perPage: this.perPage})
            }
        },
        computed: {
            ...mapState('persediaan_store', {
                nomorRak: state => state.nomorRak,
                rak: state => state.rak,
                rakID: state => state.rakID,
                rakInfo: state => state.rakInfo,
                selected: state => state.selected,
                perPage: state => state.perPage
            }),
            moveTo: {
                get() {
                    return this.rakID
                    state.jeniss.splice(index, 1)
                },
                set(value) {
                   this.$store.commit('persediaan_store/setRakID', value)
                }
            },
            moveStatus() {
                return this.moveTo != this.rakInfo.id ? true : false
            }
        },
        components: {
            'search-select': ModelSelect
        }
    }
</script>

<style scoped>
    .disabled{
        background: #ddd !important;
        box-shadow: none;
        color: #777;
        cursor: default;
    }
</style>
