<template>
  <v-dialog
      :scrim="false"
      persistent
      width="auto"
    >
      <v-card
      style="background-color: #ffffff;color: rgb(19, 3, 3);"
      >
        <v-card-text>
          Loading .....
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
</template>

<script>
export default {
   
    data()
    {
        return{

        }
    }
}
</script>

<style>

</style>