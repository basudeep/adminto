<template>
    <div class="span4">
            <aside class="right-sidebar">
              <div class="widget">
                <form class="form-search">
                  <input @keyup="handleSearch" v-on:keyup="emitToParent" v-model="searchKey" placeholder="Search Post Here" type="text" class="input-medium search-query">
                </form>
              </div>
              <div class="widget">
                <h5 class="widgetheading">Categories</h5>
                <ul class="cat">
                  <li v-for="(data , i ) in categories " :key='i'><i class="icon-angle-right"></i><router-link :to="`/category/${data.id}`">{{data.category_name}}</router-link><span> ({{data.count}})</span></li>
                </ul>
              </div>
              <div class="widget">
                <h5 class="widgetheading">Latest posts</h5>
                <ul class="recent">
                  <li class="d-flex" v-for="(item, i ) in latestposts" :key='i' >
                    <img :src="`assets/images/posts/${item.photo}`" class="pull-left" alt="" />
                    <div class="content">
                      <h6 @click='handleRefresh'><a><router-link :to="`/singleblog/${item.id}`">{{item.title | wordcut( 26, '')}}</router-link></a></h6>
                    <p>
                      {{item.description | wordcut(62, ' ..')}}
                    </p>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="widget">
                <h5 class="widgetheading">Popular tags</h5>
                <ul class="tags">
                  <li><a href="#">Web design</a></li>
                  <li><a href="#">Trends</a></li>
                  <li><a href="#">Technology</a></li>
                  <li><a href="#">Internet</a></li>
                  <li><a href="#">Tutorial</a></li>
                  <li><a href="#">Development</a></li>
                </ul>
              </div>
            </aside>
          </div>
</template>

<style scoped>
ul.recent img {
    width: 100px;
    height: 60px!important;
}
.d-flex {
    display: flex;
}
.content h6 {
    margin-bottom: 0!important;
    line-height: 20px;
}
input.search-query {
  height: 50px;
  margin-bottom: 0;
  border-radius: 50px;
  width: 100%;
}
</style>
<script>
import _ from 'lodash'
export default {
  data(){
    return {
      searchKey: '',
      isSearching: false
    }
  },
  computed:{
    categories(){
      return this.$store.getters.allCategories
    },
    latestposts(){
      return this.$store.getters.allLatestPost
    }
  },
  mounted(){
    this.$store.dispatch('getBlogCategories')
    this.$store.dispatch('getLatestPosts')
  },
  methods:{
    handleRefresh(){
      this.$store.dispatch('getSingleBlog', this.$route.params.id )
    },
    handleSearch:_.debounce( function (){
      this.$store.dispatch('handleSearch', this.searchKey )
    }, 500),



  emitToParent (event) {
    if(this.searchKey.trim() != ''){
      this.isSearching = true
    }else{
      this.isSearching = false
    } 
    this.$emit('isSearching', this.isSearching)
    }


  },
}
</script>