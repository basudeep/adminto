<template>
    <div id="wrapper">
    
    <section id="inner-headline">
      <div class="container">
        <div class="row">
          <div class="span4">
            <div class="inner-heading">
              <h2>Blog left sidebar</h2>
            </div>
          </div>
          <div class="span8">
            <ul class="breadcrumb">
              <li><a href="#"><i class="icon-home"></i></a><i class="icon-angle-right"></i></li>
              <li><router-link to='/blogpage'>Blog</router-link><i class="icon-angle-right"></i></li>
              <li class="active">Blog with left sidebar</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <section id="content">
      <div class="container">
        <div class="row">
          <div class="span8">
            <article  v-for="(post, i ) in posts " :key="i"  >
              <div class="row">
                <div class="span8">
                  <div class="post-image">
                    <div class="post-heading">
                      <router-link :to="`/singleblog/${post.id}`" ><h3><a href="#">{{post.title | wordcut(36, '')}}</a></h3></router-link>
                    </div>
                    <img :src="`assets/images/posts/${post.photo}`" alt="" />
                  </div>
                  <p>
                   {{post.description | bloddesc( 300, '..')}}
                  </p>
                  <div class="bottom-article">
                    <ul class="meta-post">
                      <li><i class="icon-calendar"></i><a href="#"> {{ post.created_at | dateformat}}</a></li>
                      <li><i class="icon-user"></i><a href="#"> {{post.user.name}}</a></li>
                      <li><i class="icon-folder-open"></i><a href="#"> {{post.category.category_name }}</a></li>
                      <li><i class="icon-comments"></i><a href="#">0 Comments</a></li>
                    </ul>
                    <a href="#" class="pull-right"><router-link :to="`/singleblog/${post.id}`"> Continue reading </router-link><i class="icon-angle-right"></i></a>
                  </div>
                </div>
              </div>
            </article>


            <div class="pagination">
              <!-- <pagination  :data="posts" @pagination-change-page="getResults"></pagination> -->
            </div>


          </div>
          
          <div v-if="posts.length ===  0" class="span8">
              <h2 >No Post Found</h2>
          </div>



        <Sidebar v-on:isSearching="onChildKeyUp" />


        </div>
      </div>
    </section>


    </div>
</template>
<style scoped>
.container{
    padding:0
}
.ivu-spin-dot{
  display: block!important;
}

</style>

<script>
import Sidebar from './Sidebar'
export default {

    
    components:{
        Sidebar
    },
    data(){
        return{
          isChildSearch: '',
        }
    },
    computed:{
        posts(){
            return this.$store.getters.getAllBlogPost
        }
    },
    mounted(){
        this.$store.dispatch('getBlogPost')
    },
    methods:{
      //  getResults(page) {
      //           if (typeof page === 'undefined') {
      //               page = 1;
      //           }

      //   if(this.$route.params.id != null){
      //      this.$store.dispatch('getBlogPostCategoryByWise', this.$route.params.id )
      //   } else{
      //     this.$store.dispatch('getBlogPost', page)
        
      //   }

      //  },
      gettingPost(){
        if(this.$route.params.id != null){
           this.$store.dispatch('getBlogPostCategoryByWise', this.$route.params.id )
        } else{
          this.$store.dispatch('getBlogPost')
        }
      },

       onChildKeyUp (value) {
        this.isChildSearch = value
      }






    },
    watch:{
      $route( to, from){
        this.gettingPost()
      }
    }
}
</script>