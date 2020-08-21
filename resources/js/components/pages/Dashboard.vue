<template>
  <div>
    <div class="row justify-content-end py-4">
        <div class="col">
            <h3>My Contacts</h3>
        </div>
      <div class="col-8 text-right d-block">
         <Button icon='ios-contact' type="info" @click='messageModal = true'>Send a message</Button>
        <a 
          class="btn btn-success btn-md waves-effect waves-light text-light"
          data-animation="fadein"
          data-overlay-speed="200"
          data-overlay-color="#36404a"
          @click="addModal = true"
        >
          <i class="mdi mdi-plus-circle-outline"></i> Add New Contact
        </a>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row mb-5">
      <div v-for="(contact, i) in Contacts" :key="i" class="col-xl-4">
        <div class="text-center card-box">
          <div class="dropdown float-right">
            <a
              href="#"
              class="dropdown-toggle arrow-none card-drop"
              data-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="mdi mdi-dots-vertical"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <!-- item-->
              <a href="javascript:void(0);" class="dropdown-item">Action</a>
              <!-- item-->
              <a href="javascript:void(0);" class="dropdown-item">Another action</a>
              <!-- item-->
              <a href="javascript:void(0);" class="dropdown-item">Something else</a>
              <!-- item-->
              <a href="javascript:void(0);" class="dropdown-item">Separated link</a>
            </div>
          </div>
          <div>

           
            <img
              v-if="contact.photo"
              :src="`assets/images/contacts/${contact.photo}`"
              class="rounded-circle avatar-xl img-thumbnail mb-2"
              alt="profile-image"
            />

            <div v-else class="rounded-circle avatar-xl img-thumbnail mb-2 text-center name-text" >
               <div  class="name" >
                 {{ contact.contact_name | name }}
               </div>
            </div>

            <p class="text-muted font-13 mb-3">{{contact.description}}</p>

            <div class="text-left">
              <p class="text-muted font-13">
                <strong>Full Name :</strong>
                <span class="ml-2">{{contact.contact_name}}</span>
              </p>

              <p class="text-muted font-13">
                <strong>Mobile :</strong>
                <span class="ml-2">{{contact.phone}}</span>
              </p>

              <p class="text-muted font-13">
                <strong>Email :</strong>
                <span class="ml-2">{{contact.email}}</span>
              </p>

              <p class="text-muted font-13">
                <strong>Location :</strong>
                <span class="ml-2">{{contact.address}}</span>
              </p>
            </div>

            <button
              type="button"
              class="btn btn-primary btn-rounded waves-effect waves-light mt-2"
            >Send Message</button>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>

    <div class="row mb-5">
      <div class="col-md-4 col-xl-3">
        <!-- Simple card -->
        <div :v-if="messages.length" class="card" v-for="(message, i) in messages" :key="i">
          <img
            class="card-img-top img-fluid"
            src="assets/images/gallery/1.jpg"
            alt="Card image cap"
          />
          <div class="card-body">
            <h4 class="card-title">From :{{message.senderName}}</h4>
            <h4 class="card-title">Name :{{message.chatName}}</h4>
            <p class="card-text mb-3">message: {{message.body}}</p>
            <Button type="info" icon="ios-color-wand" long>view</Button>
          </div>
        </div>
      </div>
      <!-- end col -->
      <div class="mt-5">
        <button class="btn btn-danger" @click="wp">My Whatsapp Messages</button>
      </div>
    </div>
    <!-- end row -->



    <!--ADD CONTACT MODAL  -->
    <Modal v-model="addModal"
     title="Enter Contact Details" 
     :mask-closable='false'
     :closable='false'
    >   
       Contact Name
       <Input prefix="ios-contact" type='text'  class="mb-2" v-model="data.name" placeholder="Enter Contact Name" />
       Phone No.
       <Input  prefix='ios-phone-portrait' class="mb-2" v-model="data.phone" placeholder="Enter Phone Number" />
       Email
       <Input prefix="ios-at-outline" class="mb-2" v-model="data.email" placeholder="Enter Email Adress" />
       Address
       <Input prefix="md-home" class="mb-2" v-model="data.address" placeholder="Enter Email Adress" />
       Description
       <Input v-model="data.description" type="textarea" :rows="4" placeholder="Enter Some Description..." />
        <Upload
            type="drag"
            ref="upload"
            :headers ="{
              'X-CSRF-TOKEN': token,
              'X-Requested-With': 'XMLHttpRequest',
            }"
            :on-remove='handleRemove'
            :disabled='isDisable'
            :on-success="handleSuccess"
            :format="['jpg','jpeg','png','svg','gif']"
            :max-size="2048"
            :on-error='handleError'
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            action="upload-contact-image">
            <div style="padding: 20px 0">
                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                <p>Click or drag image here here to upload</p>
            </div>
        </Upload>


            <!-- Image View  -->
            <div class="demo-upload-list" v-if="data.photo">
                    <img :src="`assets/images/contacts/${data.photo}`">
                  <div class="demo-upload-list-cover">
                      <Icon type="ios-eye-outline" @click="viewContact = true"></Icon>
                      <Icon type="ios-trash-outline" @click="handleRemove"></Icon>
                  </div>
            </div>





      <div slot="footer">
            <Button type="error"  @click="[ handleRemove(), addModal = false]">Cancel</Button>
            <Button type="primary" :loading='isLoading' @click='addContact'>Save</Button>
        </div>
    </Modal>


    <!--BIG PREVIEW IMAGE -->

       <Modal
            footer-hide
            v-model="viewContact"
            title="Contact Image">
            <img class="img-fluid" :src="`assets/images/contacts/${this.data.photo}`" alt="">
        </Modal>



    <!--SEND MESSAGE MODAL -->
  
  
    <Modal
        v-model="messageModal"
        title="Message Box">
        Phone No
       <Input  prefix='ios-phone-portrait' class="mb-2" v-model="mobilemessage.phone" placeholder="Enter Phone Number" /> 
        Message
       <Input v-model="mobilemessage.message" type="textarea" :rows="4" placeholder="Enter Message..." />
        <div slot="footer">
              <Button type="error"  @click=" messageModal = false">Cancel</Button>
              <Button type="primary" :loading='isLoading' @click='sendMessage'>Send</Button>
          </div>
    </Modal>

  
  
  
  

  

  </div>
</template>


<style scoped>
p.text-muted.font-13.mb-3 {
  height: 80px;
}
.name-text{
  font-size: 35px;
  line-height: 85px;
  font-weight: 700;
  background: rebeccapurple;
  border-radius: 50%;
  color: #fff;
  margin: 0 auto;
}
button.ivu-btn.ivu-btn-info {
    padding: 0 25px;
    height: 37px;
}
</style>

<script>
export default {
  data() {
    return {
      addModal : false,
      isDisable: false,
      data: {
          name:'',
          phone: '',
          email: '',
          address: '',
          description : '',
          photo:''
      },
      isLoading: false,
      token:'',
      viewContact: false,
      messages: {},
      messageModal: false,
      mobilemessage:{
        phone: '',
        message: ''
      }
    };
  },

  mounted() {
    this.$store.dispatch("getAllContacts");
    this.token =  $('meta[name="csrf-token"]').attr('content')
  },
  computed: {
    Contacts() {
      return this.$store.getters.getContact;
    },
  },
  created() {},
  methods: {
    wp() {
            axios
              .get(
                "https://eu106.chat-api.com/instance162414/messages?token=i3730972indu6dwj"
              )
              .then((res) => {
                console.log(res.data.messages);
                this.messages = res.data.messages;
              });
          },

            handleView (name) {
                this.data.photo = name;
                this.visible = true;
            },
            async handleRemove () {
              let photo = this.data.photo
              let res = await this.callingApi('post','/delete-contact-image', { photo })
              if(res.status !==200 ){
                return this.error('Something went wrong')
              }
              this.$refs.upload.clearFiles()
              this.isDisable = false
              this.data.photo = ''
            },
            handleSuccess (res, file) {
              this.data.photo = res
              this.isDisable = true
            },
            handleFormatError (file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            },
            handleMaxSize (file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 2M.'
                });
            },
            handleError(file){
              console.log(file)
            },



            async addContact(){
              if(this.data.name.trim() == '') return this.error('Please Fill Contact Name')
              // if(this.data.phone.trim() == '') return this.error('Please Fill Contact Number')
              // if(this.data.phone.length < 10) return this.error('Phone Number is not valid')
              this.isLoading = true
              let res = await this.callingApi('post', '/add-contact', this.data )
              this.isLoading = false
              if( res.status == 422){
               Object.keys(res.data.errors).forEach((error, i) => {
                // console.log(res.data.errors);
                // console.log(res.data.errors[error][0]);
                    this.$Notice.warning({
                    title: res.data.errors[error][0],
                    });
                });
              }
              if( res.status !== 200){
                return this.error('Something went wrong')
              }
              this.$store.dispatch("getAllContacts");
              this.isDisable = false
              this.addModal = false
              this.data = ''
              this.success('Contact Added')
            },

            async sendMessage(){
            if(this.mobilemessage.message.trim() == '')return this.error('Please Enter Message')
            this.isLoading = true
            let res = await this.callingApi('post','/send-message', this.mobilemessage)
            if(res.status == 422){
              console.log(res.data.errors)
              Object.keys(res.data.errors).forEach((error, i) =>{
                this.error(res.data.errors[error][0])
              })
            }
            if(res.status == 200){
                this.success('Message Send')
                this.messageModal = false
            } else{
              this.error('Something Went Wrong, Please Check The Number')
            }
            this.isLoading = false
            }
            },
};
</script>