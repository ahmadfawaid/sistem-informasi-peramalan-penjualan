require('./bootstrap')

import Vue from 'vue'
import VueAxios from 'vue-axios'
import axios from 'axios'
import Vuebar from 'vuebar'
import VueSlimScroll from 'vue-slimscroll'

Vue.use(VueAxios, axios)

Vue.use(VueSlimScroll)

import router from './router'
import store from './store'
import filter from './filters'

// flash 
window.events = new Vue()
window.flash = function(message, type) {
    window.events.$emit('flash', message, type)
}

// global components
import SideBar from './components/global/SideBar.vue'
import TopBar from './components/global/TopBar.vue'
import Flash from './components/global/Flash.vue'
import Loading from './components/global/Loading.vue'
import Pagination from './components/global/Pagination.vue'
import ToolBar from './components/global/Toolbar.vue'
Vue.component('sidebar', SideBar)
Vue.component('topbar', TopBar)
Vue.component('flash', Flash)
Vue.component('loading', Loading)
Vue.component('pagination', Pagination)
Vue.component('toolbar', ToolBar)

var app = new Vue({
    router,
    store,
}).$mount('#app')