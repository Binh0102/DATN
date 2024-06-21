<template>
  <v-carousel height="500px" hide-delimiters v-model="currentIndex">
    <v-carousel-item
      v-for="(item, i) in items"
      :key="i"
      :src="item.src"
      cover
    ></v-carousel-item>
  </v-carousel>
</template>

<script>
export default {
  name: 'CarouselView',
  data() {
    return {
      items: [
        {
          src: 'https://sneakernews.com/wp-content/uploads/2020/12/ebay-nike-dunk-sponsored-dunk-banner-1.jpg',
        },
        {
          src: 'https://www.invincible.id/cdn/shop/files/Nike_Wide_Banner.png?v=1704525807&width=2048 ',
        },
        {
          src: 'https://allgoodtales.com/wp-content/uploads/2018/10/Nike-Header-min.jpg',
        },
        {
          src: 'https://uproxx.com/wp-content/uploads/2023/10/Chicago_skyline_SNX1600x500.jpg?w=1600&h=500&crop=1',
        },
        {
          src: 'https://moxlondon.com/wp-content/uploads/2022/10/TW-WEBSITE-V2-04.jpg',
        },
      ],
      currentIndex: 0, 
    };
  },
  created() {
    setInterval(() => {
      this.currentIndex = (this.currentIndex + 1) % this.items.length;
    }, 5000);
  },
};
</script>

<style>

</style>
