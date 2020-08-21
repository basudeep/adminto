<template>
    <div id="wrapper">
    
    <section id="inner-headline">
      <div class="container">
        <div class="row">
          <div class="span4">
            <div class="inner-heading">
              <h2>Single Post</h2>
            </div>
          </div>
          <div class="span8">
            <ul class="breadcrumb">
              <li><a href="#"><i class="icon-home"></i></a><i class="icon-angle-right"></i></li>
              <li> <router-link to='/blogpage'>Blog</router-link> <i class="icon-angle-right"></i></li>
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
              <article>
              <div class="row">
                <div class="span8">
                  <div class="post-image">
                    <div class="post-heading">
                      <h3><a href="#">{{post.title}}</a></h3>
                    </div>
                    <img :src="`assets/images/posts/${post.photo}`" alt="">
                  </div>
                  <p>
                    {{ post.description }}
                  </p>
                  <div class="bottom-article">
                    <ul class="meta-post">
                      <li :v-if="post.user"><i class="icon-user"></i><a href="#"> {{post.user.name ? post.user.name : ''}}</a></li>
                      <li><i class="icon-folder-open"></i><a href="#"> post </a></li>
                      <li><i class="icon-tags"></i><a href="#">{{post.category.category_name}}</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </article>

          </div>
          
        <Sidebar />


        </div>
      </div>
    </section>


    </div>
</template>
<style scoped>
.container{
    padding:0
}
</style>
<script>
import Sidebar from './Sidebar'

export default {
    data(){
        return{
            singlepost:{}
        }
    },
    components: {
        Sidebar
    },
    computed:{
      post(){
        return this.$store.getters.getSingleBlog
      }
    },
    mounted(){
        this.$store.dispatch('getSingleBlog', this.$route.params.id )
        this.scrollToTop()
    },
    methods:{
      scrollToTop() {
                window.scrollTo(0,0);
           }
    }

}
</script>