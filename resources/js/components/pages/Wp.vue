<template>
    <div>
        <div class="row mb-5">
            <div class="col-md-4 ">
                <!-- Simple card -->
                <div :v-if="messages.length" class="card" v-for="(message, i) in messages" :key="i">
                    <img class="card-img-top img-fluid" src="assets/images/gallery/1.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">From :{{message.senderName}}</h4>
                        <h4 class="card-title">Name :{{message.chatName}}</h4>
                        <p class="card-text mb-3"> message: {{message.body}}</p>
                            <Button  type="info" icon='ios-color-wand' long >view</Button>
                    </div>
                </div>

            </div><!-- end col -->

                <div class='mt-5'>
                    <button class="btn btn-danger" @click="wp">My Whatsapp Messages</button>

                </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return{
            messages:{}

        }
    },
    mounted:{
        
    },
    methods:{
        wp(){
            axios.get('https://eu106.chat-api.com/instance162414/messages?token=i3730972indu6dwj')
                .then( res =>{
                    console.log(res.data.messages)
                    this.messages = res.data.messages
                })
        }
    }
}
</script>