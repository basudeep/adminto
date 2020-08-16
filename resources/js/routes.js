// import Vue from 'vue'
// import VueRouter from 'vue-router'


// Vue.use(VueRouter)

// const Foo = { template: '<div>foo</div>' }
// const Bar = { template: '<div>bar</div>' }



// const routes = [
//     { path: '/foo', component: Foo },
//     { path: '/bar', component: Bar }
//   ]

// const router = new VueRouter({
// routes ,// short for `routes: routes`
// mode:'history'
// })

// export default router


import Vue from 'vue'
import VueRouter from 'vue-router'
import ViewUI from 'view-design';

Vue.use(VueRouter)

import Dashboard from './components/pages/Dashboard'
import Category from './components/pages/Category'
import Contact from './components/pages/Contact'
import Post from './components/pages/Post'




const routes = [
    {
        path:'/dashboard',
        component: Dashboard
    },
    {
        path:'/category',
        component: Category
    },
    {
        path:'/contact',
        component: Contact
    },
    {
        path:'/posts',
        component: Post
    },
]


const router = new VueRouter({
    routes,
    mode:'history'
})

router.beforeEach((to, from, next) => {
    ViewUI.LoadingBar.start();
    next();
});

router.afterEach(route => {
    ViewUI.LoadingBar.finish();
});



export default router