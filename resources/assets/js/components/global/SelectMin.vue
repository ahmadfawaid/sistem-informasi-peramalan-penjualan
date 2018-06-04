<template>
    <div class="selectmin" :class="{'active': active}">
        <input type="text" ref="search" v-model="searchText" @click="searchChanged" @blur="setActive(false)">
        <ul class="list">
            <li v-for="option in filteredOptions" :key="option.id" @mousedown.prevent @click="optionSelected(option)">{{ option.text }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['value', 'options'],
        data() {
            return {
                searchText: '',
                selectedOption: null,
                active: false,
            }
        },
        methods: {
            setActive(value) {
                this.active = value
                if(this.active) {
                    this.$refs.search.focus()
                }
            },
            searchChanged() {
                if(!this.active) {
                    this.active = true
                    this.searchText = ''
                }
            },
            optionSelected(option) {
                this.active = false
                this.searchText = option.text
                this.$emit('input', option.id)
            }
        },
        computed: {
            filteredOptions() {
                return this.options.filter(option => { 
                    return option.text.toLowerCase().includes(this.searchText.toLowerCase())
                })
            }
        }
    }
</script>

<style>
    .selectmin {
        border: none;
        border-radius: 6px;
        position: relative;
    }

    .selectmin.active {
        border: 2px solid #0065ff;
    }

    .selectmin.active input {
        border: none;
    }

    .selectmin .list {
        display: none;
    }

    .selectmin.active .list {
        display: block;
    }

    .list {
        /* position: absolute;
        top: 40px;
        width: 100%;
        background: #fff;
        display: none;
        margin: 0;
        padding: 0;
        max-height: 100px;
        overflow-y: scroll;
        z-index: 2; */

        background-color: rgba(255, 255, 255, 0.95);
        border: 1px solid #ddd;
        list-style: none;
        display: block;
        margin: 0;
        padding: 0;
        width: 100%;
        overflow: hidden;
        position: absolute;
        top: 40px;
        left: 0;
        z-index: 2;
    }

    .selectmin .list li {
        cursor: pointer;
        padding: 10px 14px;
    }

    .selectmin .list li:hover {
        color: #fff;
        background: #ccc;
    }
</style>