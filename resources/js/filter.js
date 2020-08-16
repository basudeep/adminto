import Vue from 'vue'
import moment from 'moment'
import en from 'moment/locale/en-in'



Vue.filter('timeformat', (arg)=>{
    moment.locale()
    return moment(arg).startOf('hour').fromNow();
})


Vue.filter('wordcut', (text, length, suffix) =>{
    return text.substring( 0, length )+ suffix
})