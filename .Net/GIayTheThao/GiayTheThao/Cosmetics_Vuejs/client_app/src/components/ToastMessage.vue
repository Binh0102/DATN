<template>
    <v-slide-y-transition>
      <v-alert closable :text="content" :color="this.color" :icon="icon" dense dismissible class="success-alert text-left">
       
      </v-alert>
    </v-slide-y-transition>
  </template>
  <script>
  export default {
      name:'ToastMessage',
      props:{
          icon:String,
          color:String,
          content:String
      }
  }
  </script>
  
  <style scoped>
  .success-alert {
    position: fixed;
    top: 12%; 
    right: 20px; 
    min-width: 300px;
  }
  </style>