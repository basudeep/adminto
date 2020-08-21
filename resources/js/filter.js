import Vue from 'vue'
import moment from 'moment'



Vue.filter('timeformat', (arg)=>{
    moment.locale()
    return moment(arg).startOf('hour').fromNow();
})

Vue.filter('dateformat', (arg)=>{
    moment.locale()
    return moment(arg).format("MMM Do YY");    
})

Vue.filter('wordcut', (text, length, suffix) =>{
    return text.substring( 0, length )+ suffix
})


Vue.filter('bloddesc', (text, length, suffix) =>{
    return text.substring( 0, length )+ suffix
})


Vue.filter('name', ( name ) =>{
   let first = name.substr(0,1)
   let title = name.substr(name.indexOf(' ')+1);
   let last = title.substr(0,1)
   return first+last
})

