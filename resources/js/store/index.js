import Axios from "axios";

export default {
    state: {
      userList:[],
      userMessage:[]
    },
  mutations: {
    userList(state,payload){
    return state.userList = payload
    },
    userMessage(state,payload){
      return state.userMessage = payload
    },
      shortCode(state,payload){
          return state.userList = payload
      }
  },
  actions: {
    userList(context){
        Axios.get('/userlist')
        .then(response=>{
          context.commit("userList",response.data);
        })
    },
    userMessage(context,obj){
      Axios.get('/usermessage/'+obj.prop1+'/'+obj.prop2)
      .then(response=>{
        context.commit("userMessage",response.data);
      })
    },
      shortCode(context,payload){
          Axios.get('/userlist/'+payload)
              .then(response=>{
                  context.commit("shortCode",response.data);
              })
      }
   },
  getters: {
    userList(state){
      return state.userList
     },
     userMessage(state){
       return state.userMessage
     },
      shortCode(state){
          return state.shortCode
      }
    }
}
