<template>
    <div class="footer">
        <span v-if="pagination.total < 5" class="info">Menampilkan {{ pagination.total }} data</span>
        <span v-else class="info">Menampilkan {{ pagination.from }} sampai {{ pagination.to }} dari {{ pagination.total }} data</span>
        <ul class="pagination">
            <li v-if="pagination.current_page > 5">
                <a @click.prevent="changePage(1)" href="">First</a>
            </li>
            <li v-if="pagination.current_page > 1">
                <a @click.prevent="changePage(pagination.current_page - 1)" href="">Prev</a>
            </li>
            <li v-for="page in pagesNumber" :key="page" :class="[ page == isActive ? 'active' : '']">
                <a @click.prevent="changePage(page)" href="">{{ page }}</a>
            </li>
            <li v-if="pagination.current_page < pagination.last_page">
                <a @click.prevent="changePage(pagination.current_page + 1)" href="">Next</a>
            </li>
            <li v-if="(pagination.current_page + 4) < pagination.last_page">
                <a @click.prevent="changePage(pagination.last_page)" href="">Last</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['page', 'pagination', 'nomorRak'],
        methods: {
            changePage(page) {
                var perPage = this.pagination.per_page
                if(this.page == 'persediaan') {
                    var nomorRak = this.nomorRak
                    this.$store.dispatch(this.page + '_store/fetchPerPage', {nomorRak, page, perPage})
                } else {
                    this.$store.dispatch(this.page + '_store/fetchPerPage', {page, perPage})
                }
            }
        },
        computed: {
            isActive() {
                return this.pagination.current_page
            },
            pagesNumber() {
                if(this.pagination.last_page <= 1) {
                    return []
                }
                var from = this.pagination.current_page - 2
                if(from < 1) {
                    from = 1
                }
                var to = from + 4
                if(to >= this.pagination.last_page ) {
                    to = this.pagination.last_page
                }
                if((to-from) < 4) {
                    from = to - 4
                    if(from < 1) {
                        from = 1
                    }
                }
                var pagesArray = []
                while(from <= to) {
                    pagesArray.push(from)
                    from++;
                }
                return pagesArray
            }
        }
    }
</script>

<style>

</style>
