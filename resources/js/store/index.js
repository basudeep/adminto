
export default{
    state:{
        category:[],
        post:[]
    },
    getters:{
        getCategory( state ){
            return state.category
        },
        getPost( state ){
            return state.post
        }
    },
    actions:{
        //Mounted Category Action 
        getAllCategory( context ){
            axios.get('/categories-list')
                .then( res =>{       
                    context.commit('categories', res.data.categories )
                })
        },
        getAllPost( context ){
            axios.get('/allpost')
                .then( res =>{
                    context.commit('posts', res.data.posts)
                })
        }
    },
    mutations:{
        categories( state, data ){
            return state.category = data
        },
        posts( state, data ){
            return state.post = data
        }
    }
}