
export default{
    state:{
        category:[],
        post:[],
        contact:[],
        blogpost:[],    //FRONT END STATE START HERE /BLOG
        blogsingle:[],
        categories:[],
        latestposts:[]

    },
    getters:{
        getCategory( state ){
            return state.category
        },
        getPost( state ){
            return state.post
        },
        getContact( state ){
            return state.contact
        },


        /*================================
                FRONT END GETTERS
        =================================*/

        getAllBlogPost( state ){
            return state.blogpost
        },

        getSingleBlog( state ){
            return state.blogsingle
        },

        allCategories( state ){
            return state.categories
        },
        allLatestPost( state ){
            return state.latestposts
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
        },
        getAllContacts( context ){
            axios.get('/mycontacts')
                .then( res =>{
                    context.commit('contacts', res.data)
                })
        },


        /*================================
                FRONT END ACTION
        =================================*/
        getBlogPost( context ){
            axios.get('api/blogpost')
                .then( res =>{
                    context.commit('blogposts', res.data.posts)
                })
        },
        getSingleBlog( context , id ){
            axios.get(`api/single-blog/${id}`)
                .then( res =>{
                    context.commit('singleblog', res.data.post )
                })
        },
        getBlogCategories( context ){
            axios.get('api/categories')
                .then( res =>{
                    context.commit('blogCategories', res.data.categories)
                })
        },
        getLatestPosts( context ){
            axios.get('api/latest-post')
                .then( res => {
                    context.commit('latestposts', res.data.posts)
                })
        },
        getBlogPostCategoryByWise( context , id){
            axios.get(`api/categorywise-post/${id}`)
                .then( res =>{
                    context.commit('categorywise', res.data)
                })
        },
        handleSearch( context, keyword ){
            axios.get(`api/search?query=${keyword}`)
                .then( res =>{
                    context.commit('searchedPosts', res.data.posts)
                })
        }
    },
    mutations:{
        categories( state, data ){
            return state.category = data
        },
        posts( state, data ){
            return state.post = data
        },
        contacts( state, data ){
            return state.contact = data
        },

        //FRONT END START HERE / BLOGPOST
        blogposts( state, data ){
            return state.blogpost = data
        },

        singleblog( state, data ){
            return state.blogsingle = data
        },

        blogCategories( state, data ){
            return state.categories = data
        },
        latestposts( state, data ){
            return state.latestposts = data
        },
        categorywise( state, data ){
            return state.blogpost = data
        },
        searchedPosts( state, data ){
            return state.blogpost = data
        }
    }
}