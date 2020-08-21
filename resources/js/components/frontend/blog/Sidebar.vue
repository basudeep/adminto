<template>
    <div class="span4">
            <aside class="right-sidebar">
              <div class="widget">
                <form class="form-search">
                  <input placeholder="Type something" type="text" class="input-medium search-query">
                  <button type="submit" class="btn btn-square btn-theme">Search</button>
                </form>
              </div>
              <div class="widget">
                <h5 class="widgetheading">Categories</h5>
                <ul class="cat">
                  <li v-for="(data , i ) in categories " :key='i'><i class="icon-angle-right"></i><a href="#">{{data.category_name}}</a><span> (20)</span></li>
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
</style>
<script>

export default {
  data(){
    return {

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
    }
  }
}
</script>