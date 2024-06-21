<template>
<v-container justify="center" align="center">
    <v-card width="500px" class="rounded-0">
            <v-toolbar class="text-center bold-text" style="background-color: #4b574b;color: rgb(219, 207, 207);"
                title="Hồ sơ"></v-toolbar>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-text-field v-model="this.FormData.Fullname" label="Họ và tên" required ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field v-model="this.FormData.Age" type="number" label="Tuổi" required ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field v-model="this.FormData.Address" label="Địa chỉ" required ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field v-model="this.FormData.Phone" label="Số điện thoại" required ></v-text-field>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions style="background-color: #EFF3F8;" class="justify-center">
                    <v-btn @click="UpdateProfile()"  class="rounded-0"
                        style="background-color: rgb(179, 203, 184) !important;border-color: #028bda;color: rgb(81, 58, 58);">Lưu</v-btn>
                    
                </v-card-actions>
        </v-card>
  </v-container>
</template>

<script>
import axios from 'axios';
export default {
    data()
    {
        return{
            FormData:{
                Id:'',
                Fullname:'',
                Age:'',
                Address:'',
                Phone:''
            }
        }
    },
    methods:{
        getProfile()
        {
            axios.get('http://localhost:5224/api/Account/'+this.$store.state.UserId).then(rs=>{
                this.FormData=rs.data
            }).catch(erro => {
                this.$store.commit('setLoginError', {
                    show: true,
                    icon: '$error',
                    content: erro.message,
                    color: 'error'
                });
                setTimeout(() => {
                    this.$store.commit('clearLoginError');
                }, 3000);
            })
        },
        UpdateProfile()
        {
            axios.put('http://localhost:5224/api/Account/'+this.FormData.Id,this.FormData).then(rs=>{
                this.$store.commit('setLoginError', {
                    show: true,
                    icon: '$success',
                    content: rs.data,
                    color: 'success'
                });
                setTimeout(() => {
                    this.$store.commit('clearLoginError');
                }, 3000);
            }).catch(erro => {
                console.log(erro)
                this.$store.commit('setLoginError', {
                    show: true,
                    icon: '$error',
                    content: erro.message,
                    color: 'error'
                });
                setTimeout(() => {
                    this.$store.commit('clearLoginError');
                }, 3000);
            })
        }
    },
    created()
    {
        this.getProfile()
    }
}
</script>

<style>

</style>