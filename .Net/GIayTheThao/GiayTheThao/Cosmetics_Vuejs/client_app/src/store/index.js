import { createStore } from 'vuex'
import axios from 'axios';
export default createStore({
  state: {
    token:null,
    UserId:null,
    loginErro:{
      show:false,
      content:'ok nhé',
      icon:'$success',
      color:'success'
    },
    FavoriteProductForUserId:[],
    listCart:[]
  },
  getters: {
    token:state=>state.token,
    UserId:state=>state.UserId,
    loginErro:state=>state.loginErro,
    FavoriteProductForUserId:state=>state.FavoriteProductForUserId,
    listCart:state=>state.listCart
  },
  mutations: {
    setToken(state){
      state.token=sessionStorage.getItem('token');
    },
    setUserId(state){
      state.UserId=sessionStorage.getItem('UserId');
    },
    clearToken(state){
      if(!sessionStorage.getItem('token'))
        return
      state.token=null
      sessionStorage.removeItem('token');
    },
    clearUserId(state){
      if(!sessionStorage.getItem('UserId'))
        return
      state.UserId=null
      sessionStorage.removeItem('UserId');
    },
    // lúc toast message
    setLoginError(state, { show, icon, content,color }) {
      state.loginErro = { show, icon, content,color };
    },
    clearLoginError(state) {
      state.loginErro = { show: false, icon: '', content: '',color:'' };
    },


    //cho danh sách sản phẩm yêu thích của khách hàng
    setFavoriteProductForUserId(state,data)
    {
      //console.log(data)
      state.FavoriteProductForUserId=data
    },
    clearFavoriteProductForUserId(state)
    {
      state.FavoriteProductForUserId=null
    },


    // danh sách giỏ hàng
    setListCart(state,data)
    {
      state.listCart=data
      console.log(state.listCart)
    },
    clearListCart(state)
    {
      state.listCart=null
    }
  },
  actions: {
    login(context,form)
    {
      axios.post("http://localhost:5224/api/Account/login",form).then(rs=>{
        sessionStorage.setItem('token', rs.data.token);
        sessionStorage.setItem('UserId', rs.data.UserId);
        context.commit('setToken')
        context.commit('setUserId')
        context.dispatch('getFavoriteProductForUserId',rs.data.UserId)
        context.dispatch('getListCart',rs.data.UserId)
      }).catch(erro=>{
          context.commit('setLoginError', {
            show: true,
            icon: '$error',
            content: erro.response.data,
            color: 'error'
          });
          setTimeout(() => {
            context.commit('clearLoginError');
          }, 3000);
      })
    },
    logout(context)
    {
      context.commit('clearToken')
      context.commit('clearUserId')
      context.commit('clearFavoriteProductForUserId')
      context.commit('clearListCart')
    },
    getsessionStorage_token(context)
    {
      if(sessionStorage.getItem('token'))
      {
        context.commit('setToken')
      }
      if(sessionStorage.getItem('UserId'))
      {
        context.commit('setUserId')
        context.dispatch('getListCart',sessionStorage.getItem('UserId'))
        context.dispatch('getFavoriteProductForUserId',sessionStorage.getItem('UserId'))
      }
    },


    // action lấy thông tin danh sách yêu thích của khách hàng
    getFavoriteProductForUserId(context,id)
    {
      //alert("vào "+id)
      axios.get('http://localhost:5224/api/FavoriteProduct',{
            params: {
                userId: id
              },
              headers: {
                'Authorization': `Bearer ` + context.state.token,
            },
        }).then(rs=>{
            context.commit('setFavoriteProductForUserId',rs.data)
        }).catch(error=>{
          context.commit('setLoginError', {
            show: true,
            icon: '$error',
            content: error.message,
            color: 'error'
        });
        setTimeout(() => {
          context.commit('clearLoginError');
        }, 3000);
        });
    },


    //action lấy danh sách giỏ hàng của user
    getListCart(context,id)
    {
      axios.get('http://localhost:5224/api/Cart',{
        params: {
          userId: id
        },
        headers: {
          'Authorization': `Bearer ` + context.state.token,
      },
      }).then(rs=>{
        if(rs.data!=[])
          context.commit('setListCart',rs.data)
        else
          context.commit('setListCart',null)
        //console.log(rs.data)
      }).catch(erro=>{
        this.$store.commit('setLoginError', {
          show: true,
          icon: '$error',
          content: erro.message,
          color: 'error'
      });
      setTimeout(() => {
        context.commit('clearLoginError');
      }, 3000);
      })
    }
  },
  modules: {
    
  }
})
