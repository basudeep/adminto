<template>
    <div>
       <div class="row justify-content-between my-4">
            <h1 class="m-0">Post List</h1>
            <Button type="primary" icon='md-add' @click='addModal=true'>Add New Post</Button>
        </div>

    <div class="table-responsive mb-5">
      <table class="table table-striped mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Desc</th>
            <th>Author</th>
            <th>Time</th>
            <th>Photo</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

            <tr class="align-middle"  v-for="(post, i) in getPost" :key='i'>
            <th class="align-middle" scope="row">{{i+1}}</th>
            <td class="align-middle" v-if="post.title">{{post.title | wordcut(30, '..')}}</td>
            <td class="align-middle" v-if="post.description ">{{post.description | wordcut(70, '...')}}</td>
            <td class="align-middle" v-if="post.user.name">{{post.user.name }}</td>
            <td class="align-middle" >{{post.created_at | timeformat}}</td>
            <td class="tablephoto" v-if="post.photo"><img :src="`assets/images/posts/${post.photo}`" alt=""></td>
            <td class="align-middle" >
                <Button class=" mb-2" type="error" icon='ios-trash' long @click="deletePost(post.id)">Delete</Button>
                <Button class=" mb-2" type="success" icon='ios-color-wand' long @click='updatePost(post)'>Edit</Button>
                <Button type="info" icon='ios-color-wand' long @click="viewPost(post)">view</Button>
            </td>
          </tr>
           <h1></h1>
          </tbody>
      </table>
    </div>


    <!--Add New Post Modal -->

    <Modal
        v-model="addModal"
        title="Add New Post"
        :mask-closable='false'
        :closable='false'
        >
        Title
        <Input class="mb-2" v-model="post.title" placeholder="Post Title" />
        Description
        <Input class="mb-2" v-model="post.description" type="textarea" :rows="4" placeholder="Enter Description..." />
            Category
            <Select class="mb-2" v-model="post.categoryId" placeholder="Select a category">
                <Option v-for="(category, i) in getCategory" :key="i" :value="category.id">{{category.category_name}}</Option>
            </Select>
        
        
        Photo
        <Upload
        ref="uploads"
        :headers="{
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
        }"
        :disabled='isDisable'
        :max-size="2048"
        type="drag"
        :on-remove='deleteImage'
        :on-error='handleError'
        :on-success="handleSuccess"
        :on-format-error="handleFormatError"
        :format="['jpg','jpeg','png','gif']"
        :on-exceeded-size="handleMaxSize"
        action="/upload-post-image">
        <div style="padding: 20px 0">
            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
            <p>Click or drag files here to upload</p>
        </div>
    </Upload>

    <div class="demo-upload-list" v-if="post.photo">
            <img :src="`/assets/images/posts/${post.photo}`">
            <div class="demo-upload-list-cover">
                <Icon type="ios-eye-outline" @click="imageView=true"></Icon>
                <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
            </div>
        </div>
        <!-- <div class="image-preview" v-if='post.photo'>
            <img class="img-fluid" :src="`/assets/images/posts/${post.photo}`" alt="">
        </div> -->

        <div slot="footer">
            <Button @click="[deleteImage(), addModal =false]"  >Cancel</Button>
            <Button type="primary" @click='addPost' :loading='isLoading' >{{ isLoading ? 'Saving....' : 'Save'}}</Button>
        </div>
    </Modal>

    <!--Image View  -->
    <Modal :footer-hide='true' v-model="imageView" >
       <img class="img-fluid" :src="`/assets/images/posts/${post.photo}`" alt="">
    </Modal>




    <Modal
        v-model="editModal"
        title="Add New Post"
        :mask-closable='false'
        :closable='false'
        >
        Title
        <Input class="mb-2" v-model="editPost.title" placeholder="Post Title" />
        Description
        <Input class="mb-2" v-model="editPost.description" type="textarea" :rows="4" placeholder="Enter Description..." />
            Category
            <Select class="mb-2" v-model="editPost.category_id" placeholder="Select a category">
                <Option v-for="(category, i) in getCategory" :key="i" :value="category.id">{{category.category_name}}</Option>
            </Select>
        
        
        Photo
        <Upload
        ref="upload"
        :headers="{
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
        }"
        :disabled='isDisableUpdate'
        :max-size="2048"
        type="drag"
        :on-remove='handleRemove'
        :on-error='handleError'
        :on-success="handleUpdateSuccess"
        :on-format-error="handleFormatError"
        :format="['jpg','jpeg','png','gif']"
        :on-exceeded-size="handleMaxSize"
        action="/upload-post-image">
        <div style="padding: 20px 0">
            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
            <p>Click or drag files here to upload</p>
        </div>
    </Upload>

    <div class="demo-upload-list" v-if="editPost.photo">
            <img :src="`/assets/images/posts/${editPost.photo}`">
            <div class="demo-upload-list-cover">
                <Icon type="ios-eye-outline" @click="editimageView=true"></Icon>
                <Icon type="ios-trash-outline" @click="deleteEditImage"></Icon>
            </div>
        </div>

        <div slot="footer">
            <Button @click="cancelUpdate()"  >Cancel</Button>
            <Button type="primary" @click='updateEditPost' :loading='isLoading' >{{ isLoading ? 'Saving....' : 'Save'}}</Button>
        </div>
    </Modal>
    <Modal :footer-hide='true' v-model="editimageView" >
       <img class="img-fluid" :src="`/assets/images/posts/${editPost.photo}`" alt="">
    </Modal>




    <!-- View Post Modal  -->


    <Modal
        v-model="postViewModal"
        title="Post Detailis"
        fullscreen 
        :mask-closable='false'


        >

        <Card>
        <div style="text-align:center">
            <h2 class="my-3" slot="title">{{postView.title}}</h2>
            <img class="img-fluid" :src="`/assets/images/posts/${postView.photo}`">
            <p v-if="postView.user.name">{{postView.user.name }}</p>
            <h4 class="my-3 text-justify">{{postView.description}}</h4>
        </div>
    
    </Card>
        <div slot="footer">
            <Button @click="postViewModal=false" >Close</Button>
        </div>
    </Modal>



    </div>
</template>

<script>
export default {
     



    data() {
        return {
            addModal : false,
            post:{
                title: '',
                description: '',
                photo: '',
                categoryId:''
            },
            oldImage:'' ,
            imageView:false,
            editimageView:false,
            isDisable :false,
            uploadList:[],
            isLoading: false,
            token:'',
            editModal:false,
            isDisableUpdate: false,
            editPost:{},
            postViewModal: false,
            postView: {
                user:{}
            }
            
        }
    },


    mounted(){
        this.$Loading.start();
        this.$store.dispatch('getAllPost')
        this.$Loading.finish();
        this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        this.$store.dispatch('getAllCategory')
    },
    computed:{
        getPost(){
            return this.$store.getters.getPost
        },
        getCategory(){
            return this.$store.getters.getCategory
        }
    },

    methods: {

        /*============================
                Add New Post
        ==============================*/

        async addPost(){
            if(this.post.title.trim() == '' || this.post.description.trim() == '') return this.error('Plese Fill all of the inputs')
            if(this.post.photo.trim() == '') return this.error('Please upload a photo')
            if(this.post.categoryId == '') return this.error('Please select a category')
            this.isLoading = true
            let res = await this.callingApi('post', '/add-post', this.post )
            if(res.status == 200 ){
                this.success('Post Added Succesfully')
                this.$store.dispatch('getAllPost')
            } else {
                this.error('Something went wrong.Please try again..')
            } 
            this.isLoading = false
            this.addModal=false
            this.post = {}  
        },

        


        handleFormatError(file){
            this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
        },
        handleView (name) {
            this.imgName = name;
            this.visible = true;
        },
        handleRemove (file) {
            const fileList = this.$refs.upload.fileList;
            this.isDisableUpdate = false
            axios.post('/delete-image', {image:this.editPost.photo})
                .then( res => {
                    console.log('remove')
                })
            this.editPost.photo = this.oldImage
        },
        handleSuccess (res, file) {
            this.post.photo = res
            this.isDisable = true
        },
        handleUpdateSuccess (res, file) {
            if(this.editPost.photo){
                this.editPost.photo= ''
            }
            this.editPost.photo = res
            this.isDisableUpdate = false            
        },
        handleMaxSize (file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },
        handleError(res, file){
            this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: `${file.errors.file.length ? file.errors.file[0] : 'Somthing is wrong, try again' }`
                });
        },
        async deleteImage(){
            let image = this.post.photo
            // console.log(image)
            let res = await this.callingApi('post','/delete-image', { image })
            if(res.status !== 200){
                return this.error('Something went wrong')
            }
            this.$refs.uploads.clearFiles()
            this.isDisable=false
            this.post.photo =  ''
        },
        /*=======================================
            Delete Updated Image From Front-End
        =========================================*/
        deleteEditImage(){
            this.$refs.upload.clearFiles()
            this.isDisable=false
            this.editPost.photo =  ''
        },

        /*=======================================
                     Post Delete
        ========================================*/

        deletePost(id){
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
            this.$Loading.start();
            axios.get(`/post-delete/${id}`)
                .then( res => {
                    this.$store.dispatch('getAllPost')
                    this.$Loading.finish();
                    this.success('Post Delete Succesfully')
                })
                .catch( err =>{
                    this.$Loading.error();
                     console.log(err)
                })
                }
            })
            
        },


        /*=================================
            On Click Post Edit Button
        ===================================*/

        updatePost(post){
            // console.log(post)
            this.editPost = post
            this.oldImage = this.editPost.photo
            this.editModal = true
            this.isDisableUpdate =false
        },

        /*==========================================
                   Post Update Method
        ===========================================*/

        async updateEditPost(){
            if(this.editPost.title.trim() == '' || this.editPost.description.trim() == '') return this.error('Plese Fill all of the inputs')
            if(this.editPost.photo.trim() == '') return this.error('Please upload a photo')
            if(this.editPost.categoryId == '') return this.error('Please select a category')
            this.$Loading.start()
            this.isLoading = true
            let res = await this.callingApi('post', '/update-post', this.editPost )
            if(res.status == 200 ){
                this.success('Post update Succesfully')
                this.$store.dispatch('getAllPost')
                this.$Loading.finish()
            }else{
                this.error('Something went wrong.Please try again..')
                this.$Loading.error()
            } 
            this.isLoading = false
            this.editModal = false
        },

        /*=============================================
              Postpond Update When Image Uploaded
        ===============================================*/

        cancelUpdate(){
            this.$store.dispatch('getAllPost')
            this.editModal = false
            this.$refs.upload.clearFiles()
            if(this.oldImage != this.editPost.photo ){
                 axios.post('/delete-image', {image:this.editPost.photo})
                .then( res => {
                    console.log('remove')
                })
                .catch( err =>{
                    console.log(err)
                })
            }
        },


    /*=============================================
                    Post View
    ===============================================*/


        viewPost(post){
            this.postViewModal = true,
            this.postView = post
            console.log(post)
        }
        
    }
}
</script>