
require('./bootstrap');
window.Vue = require('vue');
import router from './routes'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import Common from './common'
import {filter} from './filter'
import Vuex from 'vuex'
import vuestore from './store/index'
import Swal from 'sweetalert2'
Vue.use(ViewUI)

Vue.use(require('vue-resource'))

Vue.mixin(Common)
window.Swal = Swal

Vue.use(Vuex)
//Vue Store
const store = new Vuex.Store(
    vuestore
)






Vue.component('pagination', require('laravel-vue-pagination'));




const app = new Vue({
    el: '#app',
    router,
    store
});
