<template>
 <v-footer style="background-color: #f8f9fa !important;" class="text-black">
    <v-container class="ma-center  ">
        <v-row width="100%">
            <v-card flat class="pa-4" style="width: 100%;">
                <v-row>
                    <v-col cols="6" class="pl-5">
                        <h3 class="text-left">Cửa hàng giày thể thao Nike Uy Tín Tại Việt Nam</h3>
                        <p class="text-left mt-3"> <v-icon>mdi mdi-map-marker-radius</v-icon> Số 1-Phố Xốm-Phú Lãm-Hà-Đông-Hà Nội</p>
                        <p class="text-left mt-3"> <v-icon>mdi mdi-phone-in-talk-outline</v-icon> 0978666666</p>
                        <p class="text-left mt-3"> <v-icon>mdi mdi-gmail</v-icon> duyphungduc25@gmail.com</p>
                        <div class="d-flex align-center">
                            <v-btn icon @click="openLink('https://www.facebook.com/profile.php?id=100027660773287')">
                                <v-icon>mdi mdi-facebook</v-icon>
                            </v-btn>
                            <v-btn icon @click="openLink('https://www.instagram.com/duybeeus._.26')">
                                <v-icon>mdi mdi-twitter</v-icon>
                            </v-btn>
                            <v-btn icon @click="openLink('https://www.instagram.com/duybeeus._.26')">
                                <v-icon>mdi mdi-linkedin</v-icon>
                            </v-btn>
                            <v-btn icon @click="openLink('https://www.instagram.com/duybeeus._.26')">
                                <v-icon>mdi mdi-instagram</v-icon>
                            </v-btn>
                        </div>
                    </v-col>
                    <v-col cols="6">
                        <v-card-title class="text-h6 text-uppercase font-weight-bold">Liên kết nhanh</v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="4" class="pr-5555">
                                        <div class="text-black font-weight-bold">Về Chúng Tôi</div>
                                        <ul class="pl-0">
                                            <li><a href="#" class="text-decoration-none text-black">Trang Chủ</a></li>
                                            <li><a href="#" class="text-decoration-none text-black">Giới thiệu</a></li>
                                            <li><a href="#" class="text-decoration-none text-black">Sản Phẩm</a></li>
                                            <li><a href="#" class="text-decoration-none text-black">Hệ thống cửa hàng</a></li>
                                        </ul>
                                    </v-col>
                                    <v-col cols="4" class="px-222222">
                                        <div class="text-black font-weight-bold">Chính Sách</div>
                                        <ul class="pl-0">
                                            <li><a href="#" class="text-decoration-none text-black">Chính sách đối tác</a></li>
                                            <li><a href="#" class="text-decoration-none text-black">Chính sách đổi trả</a></li>
                                            <li><a href="#" class="text-decoration-none text-black">Chính sách thanh toán</a></li>
                                            <li><a href="#" class="text-decoration-none text-black">Chính sách giao hàng</a></li>
                                        </ul>
                                    </v-col>
                                    <v-col cols="4" class="pl-2">
                                        <div class="text-black font-weight-bold">Hỗ Trợ</div>
                                        <ul class="pl-0">
                                            <li><span class="text-black">Mua hàng hotline: 1800000</span></li>
                                            <li><span class="text-black">Bảo hành:...........</span></li>
                                            <li><span class="text-black">Khiếu nại:...........</span></li>
                                        </ul>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                    </v-col>
                </v-row>
            </v-card>
        </v-row>
    </v-container>
</v-footer>






</template>
<script>
export default {
    name:'FooTer',
    data()
    {
      return {
  socialMediaLinks: [
    { icon: 'mdi-facebook', link: 'https://www.facebook.com/your_facebook_page' },
    { icon: 'mdi-twitter', link: 'https://twitter.com/your_twitter_account' },
    { icon: 'mdi-linkedin', link: 'https://www.linkedin.com/in/your_linkedin_profile' },
    { icon: 'mdi-instagram', link: 'https://www.instagram.com/your_instagram_account' }
  ]
}


    },
    methods: {
    openLink(link) {
      window.open(link, '_blank');
    }
  }
}
</script>

<style>

</style>