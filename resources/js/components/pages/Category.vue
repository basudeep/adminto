<template>
  <div>
        <div class="row justify-content-between my-4">
            <h1 class="m-0">Categories List</h1>
            <Button type="primary" icon='md-add' @click='addModal=true'>Add New</Button>
        </div>

    <div class="table-responsive mb-5">
      <table class="table table-striped mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Category</th>
            <th>User</th>
            <th>Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          <tr  v-for='(category, i ) in getCategory' :key="i" >
            <th scope="row">{{i+1}}</th>
            <td>{{category.category_name}}</td>
            <td>Admin</td>
            <td>{{category.created_at | timeformat }}</td>
            <td>
                <Button type="error" icon='ios-trash' @click.prevent="deleteCategory(category.id)">Delete</Button>
                <Button type="info" icon='ios-color-wand' @click="editCategory(category)">Edit</Button>
            </td>
          </tr>
           <h1></h1>
          </tbody>
      </table>
    </div>


   <!--Add New Modal  -->
    <Modal
        v-model="addModal"
        title="Common Modal dialog box title"
        :mask-closable='false'
        :closable='false'>
              <Input type="text" :rules='ruleInline' v-model="data.category_name" placeholder="Type Category Name" />
        <div slot='footer'>
            <Button @click="addModal=false">Cancel</Button>
            <Button  @click="addCategory" type="primary"  :loading='isAdding' >{{ isAdding ? 'Saving...' : 'Save'}}</Button>
        </div>
    </Modal>


 
<!--Edit Modal  -->
    <Modal
        v-model="editModal"
        title="Edit Category"
        :mask-closable='false'
        :closable='false'>
              <Input type="text" :rules='ruleInline' v-model="editData.category_name" placeholder="Type Category Name" />
        <div slot='footer'>
            <Button @click="editModal=false">Cancel</Button>
            <Button  @click="updateCategory" type="primary"  :loading='isAdding' >{{ isAdding ? 'Updating...' : 'Update'}}</Button>
        </div>
    </Modal>



  </div>
</template>

<script>
export default {
  mounted(){
    this.$Loading.start();
    //  let res = await this.callingApi('get', 'categories-list')
    //  if(res.status == 200 ){
    //    this.categories = res.data
    //  }
    
     this.$store.dispatch('getAllCategory')
     this.$Loading.finish();
   },

  computed:{
    getCategory(){
      return this.$store.getters.getCategory
    }
  },  

  data(){
    return {
      data:{
          category_name:''
      },
      addModal: false,
      isAdding: false,
      ruleInline: {
        category_name: [
            { required: true, message: 'Please fill in the user name', trigger: 'blur' },
            { type: 'string', min: 3, message: 'Must be 3 characters', trigger: 'change' }
            ],
      },
      categories: [],
      deleteModal:false,
      editModal:false,
      editData:{
        category_name:''
      }
    }
  },
  methods :{
    async addCategory(){
      if(this.data.category_name.trim() == '') return this.error('Category is required')
      this.isAdding = true
      const res = await this.callingApi('post','/category-add', this.data )
      if(res.status == 200 ){
        this.success('Category Added Succesfully')
        this.addModal = false
        this.data.category_name= ''
      } else{
        this.default('should be minimum 3 characters')
      }
      this.$store.dispatch('getAllCategory')
      this.isAdding = false
    },

   deleteCategory(id){
      console.log(id)
      Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this category!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
      if (result.value) {
      axios.get(`/category-delete/${id}`)
        .then( res => {
          this.$store.dispatch('getAllCategory')
          this.success('Category Delete Succesfully')
        })
        .catch( err =>{
          console.log(err)
        })
      
      }
    })
    },

    editCategory(category){
      Object.assign(this.editData, category )
      this.editModal = true
      console.log(this.editdata)
    },

    async updateCategory(){
      if(this.editData.category_name.trim() == '') return this.error('Category is required')
      this.isAdding = true
      let res = await this.callingApi('post','/category-update', this.editData)
      if(res.status == 200 ){
        this.success('Category Update Succesfully')
        this.$store.dispatch('getAllCategory')
        this.editModal = false
      }else{
        this.error('minimum 3 caharacters')
      }
      this.isAdding = false
    } 
  },

    
  
   
  
}
</script>