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
          <div class="span8" v-if="isSearching == false">
            <article>
              <div class="row" >
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
          



        <!-- IF SEARCHING TRUE -->

        <!-- <div class="span8">
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
              <pagination  :data="posts" @pagination-change-page="getResults"></pagination>
            </div>


          </div>  -->
        <div class="span8" v-if="isSearching == true">
            <article  v-for="(post, i ) in posts " :key="i"  >
              <div class="row">
                <div class="span8">
                  <div class="post-image">
                    <div class="post-heading">
                      <router-link  :to="`/singleblog/${post.id}`" ><h3 @click="isSearching=false"><a>{{post.title | wordcut(36, '')}}</a></h3></router-link>
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
                    <a @click="isSearching=false" class="pull-right"><router-link :to="`/singleblog/${post.id}`"> Continue reading </router-link><i class="icon-angle-right"></i></a>
                  </div>
                </div>
              </div>
            </article>

          </div>


        <Sidebar v-on:isSearching="fromChild"   />


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
            singlepost:{},
            isSearching: false
        }
    },
    components: {
        Sidebar
    },
    computed:{
      post(){
        return this.$store.getters.getSingleBlog
      },
      posts(){
          return this.$store.getters.getAllBlogPost
      }
    },
    mounted(){
        this.$store.dispatch('getSingleBlog', this.$route.params.id )
        this.scrollToTop()
    },
    methods:{
      scrollToTop(){
            window.scrollTo(0,0);
      },
      
    fromChild( value ){
      this.isSearching = value
    }

    },
    watch:{
      $route(to, from ){
        this.scrollToTop()
      }
    }

}
</script>