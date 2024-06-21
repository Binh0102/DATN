<template>
    <v-row justify="center">
        <v-col cols="12">
            <v-container class="text-center max-width">
                <v-btn @click="this.$emit('giam',this.formData)" size="large" density="compact" icon="mdi mdi-chevron-left"></v-btn>
                <span class="mx-4 bg-blue" style="padding:15px;color:#f1e9f0;border-radius: 100%;">{{ page }}</span>
                <v-btn @click="this.$emit('tang',this.formData)" size="large" density="compact" icon="mdi mdi-chevron-right"></v-btn>
            </v-container>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name:'PageView',
    props: {
    page: {
      type: Number, // Định kiểu dữ liệu là số nguyên
      required: true // Tùy chọn: Để đảm bảo `page` là bắt buộc
    }
  },
}
</script>

<style></style>