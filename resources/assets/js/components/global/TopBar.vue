<template>
    <div class="topbar">
        <div class="page-title">
            <h2 class="title">{{ title }}</h2>
            <span class="subtitle">Sistem Informasi Peramalan Penjualan</span>
        </div>
        <div class="user-area">
            <div class="user">
                <div class="name">{{ user }}</div>
                <span class="role">{{ role }}</span>
            </div>
            <img class="img" src="/images/avatar.png">
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title'],
        data() {
            return {
                user: $('meta[name="user-nama"]').attr('content'),
                role: $('meta[name="user-role"]').attr('content'),
            }
        }
    }
</script>