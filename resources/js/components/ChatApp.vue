<template>
    <div class="container-chat clearfix">
        <div class="people-list" id="people-list">
            <div class="search">
                <input type="text" placeholder="search" />
                <i class="fa fa-search"></i>
            </div>
            <ul class="list">
                <li @click.prevent="selectUser(user.id)" class="clearfix names" v-for="user in userList.users" :key="user.id + Math.random()">
                    <img src="dist/img/default.jpg" alt="avatar" width="55" height="55" style="vertical-align: middle;  border-radius: 50%;"/>
                    <div class="about">
                        <div class="name">{{user.name}}</div>
                        <div class="status">
                            <i class="fa fa-circle online"></i> {{user.phonenumber}}
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="chat">
            <div class="chat-header clearfix">
                <div class="chat-about">
                    <div  class="chat-with"></div>
                </div>
                <div class="select">
                <select  v-model='shortcode' @change="selectShortCode">
                    <option disabled selected value='0' >Select Short Code</option>
                    <option v-for='data in shortcodes' :value='data.id'>{{ data.short_code }}</option>
                </select>
                    </div>
                <i class="fa fa-star"></i>
            </div> <!-- end chat-header -->
            <div class="chat-history" v-chat-scroll>
                <ul v-for="message in userMessage.messages" :key="message.id">
                    <li class="clearfix" v-if="message.incoming !== null">
                        <div class="message-data align-right">
                            <span class="message-data-time">{{isToday(message.created_at)}}</span> &nbsp; &nbsp;
                            <span class="message-data-name">{{message.name}}</span> <i class="fa fa-circle me"></i>
                        </div>
<!--                        <div :class="`message  float-right ${message.type==1 ? 'other-message' : 'my-message'}`">-->
                        <div class="message other-message float-right">
                            {{message.incoming}}
                        </div>
                    </li>
                    <li  v-if="message.outgoing !== null">
                        <div class="message-data">
                            <span class="message-data-name"><i class="fa fa-circle online"></i>{{message.short_code}}</span>
                            <span class="message-data-time">{{isToday(message.created_at)}}</span>
                        </div>
                        <div class="message my-message">
                            {{message.outgoing}}
                        </div>
                    </li>
                </ul>

            </div> <!-- end chat-history -->

            <div class="chat-message clearfix">
                <textarea @keydown.enter="sendMessage" v-model="message" name="message-to-send" id="message-to-send" placeholder="Type your message" rows="3"></textarea>
                <span id="error" style="color: maroon"></span>
                <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
                <i class="fa fa-file-image-o"></i>

                <button>Send</button>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    export default {
        mounted() {
            this.$store.dispatch('userList');
        },
        data(){
            return{
                message:'',
                typing:'' ,
                users:[],
                shortcode:1,
                shortcodes: [],
                online:''
            }
        },
        computed:{
            userList(){
                return  this.$store.getters.userList
            },
            userMessage(){
                return  this.$store.getters.userMessage
            },
        },
        created(){
             this.getShorCodes()
        },
        methods: {
            selectUser(userId) {
                let obj = { prop1: userId, prop2: this.shortcode, }
                this.$store.dispatch('userMessage', obj);
            },
            selectShortCode() {
               this.$store.dispatch('shortCode', this.shortcode);
            },
            isToday(date) {
                return moment(date).format('MMMM Do YYYY, h:mm:ss a')
            },
            sendMessage(e){
                var span = document.getElementById('error');
                e.preventDefault();
                if(this.message!=''){
                    axios.post('/sendmessage',{message:this.message,user_id:this.userMessage.user.id,short_code_id:this.shortcode})
                        .then(response=>{
                            this.selectUser(this.userMessage.user.id);
                        })
                        .catch(error => {
                            console.log(error.message);
                        })
                    if (error){
                        if ('textContent' in span) {
                            span.textContent = 'A connection attempt failed';
                        } else {
                            span.innerText = 'A connection attempt failed';
                        }
                    }
                    else {
                        if ('textContent' in span) {
                            span.textContent = 'Successfully sent';
                        } else {
                            span.innerText = 'Successfully sent';
                        }
                    }
                    this.message = '';
                }
            },
            getShorCodes: function(){
                axios.get('/get_codes')
                    .then(function (response) {
                        this.shortcodes = response.data;
                    }.bind(this));
            },
            // sortValue(){
            //     axios.post('/filter',{ shortcode:this.shortcode })
            //         .then(function (response) {
            //             this.shortcodes = response.data;
            //         }.bind(this));
            // }
        }
    }
</script>
<style>
.people-list ul{overflow-y: scroll!important}
select {
    /* Reset Select */
    appearance: none;
    outline: 0;
    border: 0;
    box-shadow: none;
    /* Personalize */
    flex: 1;
    padding: 0 1em;
    color: #007bff;
    cursor: pointer;
}
/* Remove IE arrow */
select::-ms-expand {
    display: none;
}
/* Custom Select wrapper */
.select {
    position: relative;
    display: flex;
    width: 20em;
    height: 3em;
    margin-left: 20%;
    float: left;
    border-radius: .25em;
    overflow: hidden;
}
/* Arrow */
.select::after {
    content: '\25BC';
    position: absolute;
    top: 0;
    right: 0;
    padding: 1em;
    background-color: #34495e;
    transition: .25s all ease;
    pointer-events: none;
}
/* Transition */
.select:hover::after {
    color: #f39c12;
}
</style>
