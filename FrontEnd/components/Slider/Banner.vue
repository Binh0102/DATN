<template>
  <div class="">
    <Swiper
      :modules="[SwiperAutoplay]"
      :slides-per-view="1"
      :loop="true"
      :autoplay="{
        delay: 3000,
        disableOnInteraction: true,
      }"
      class="container"
    >
      <SwiperSlide v-for="img in items" :key="img">
        <img :src="img.src" class="h-[500px] w-[100%]" alt="" />
      </SwiperSlide>
    </Swiper>
  </div>
</template>
<script setup>
const items = [
  {
    src:
      "https://sneakernews.com/wp-content/uploads/2020/12/ebay-nike-dunk-sponsored-dunk-banner-1.jpg",
  },
  {
    src:
      "https://www.invincible.id/cdn/shop/files/Nike_Wide_Banner.png?v=1704525807&width=2048",
  },
  {
    src: "https://allgoodtales.com/wp-content/uploads/2018/10/Nike-Header-min.jpg",
  },
  {
    src:
      "https://uproxx.com/wp-content/uploads/2023/10/Chicago_skyline_SNX1600x500.jpg?w=1600&h=500&crop=1",
  },
  {
    src: "https://moxlondon.com/wp-content/uploads/2022/10/TW-WEBSITE-V2-04.jpg",
  },
];
</script>
