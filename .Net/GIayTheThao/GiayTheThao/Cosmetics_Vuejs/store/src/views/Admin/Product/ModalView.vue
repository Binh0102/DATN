<template>
    <v-dialog transition="dialog-top-transition" width="800px">
      <v-card class="rounded-16">
        <v-toolbar class="text-center bold-text" style="background-color: #673AB7; color: white;"
                  :title="this.idEdit != null ? 'SỬA SẢN PHẨM' : 'THÊM SẢN PHẨM'">
        </v-toolbar>
        <v-card-text>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field label="Tên Sản Phẩm" required v-model="this.formData.ProductName" outlined></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-select v-model="this.formData.CategoryId" :items="this.catergories" item-title="CategoryName" item-value="CategoryId"
                        label="Thuộc danh mục" outlined></v-select>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field label="Giá bán" required v-model="this.formData.Price" outlined></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-file-input ref="fileInput" @change="handleFileChange" accept="image/png, image/jpeg, image/bmp"
                            placeholder="Chọn ảnh" prepend-icon="mdi-camera" outlined></v-file-input>
            </v-col>
            <v-col cols="12">
              <v-textarea clearable label="Mô tả" v-model="this.formData.Description" outlined></v-textarea>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions style="background-color: #f0eff2;" class="justify-center">
          <v-btn @click="save()" class="rounded-16"
                 style="background-color: #f7f0f2; color: rgb(9, 0, 0);">{{ this.idEdit != null ? 'Cập nhật' : 'Thêm Sản Phẩm' }}</v-btn>
          <v-btn @click="closeDialog()" class="rounded-16"
                 style="background-color: #f7f0f2; color: rgb(19, 1, 1);">Hủy</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
<script>
import ProductService from '@/Service/ProductService'
import CategoryService from '@/Service/CategoryService'
export default {
    props: {
        idEdit: null
    },
    data() {
        return {
            formData: {
                ProductId: '',
                ProductName: '',
                file: null,
                Description: '',
                Price: '',
                CategoryId:'',
                ProductImage:''
            },
            catergories: []
        }
    },
    created() {
        this.getAllCategories()
    },
    methods: {
        save() {
            this.$emit("save", this.formData)
            this.$emit("reset-form"); // Gửi sự kiện reset-form khi thêm thành công
            this.emtyForm() 
        },
        closeDialog() {
            this.$emit("close")
        },
        emtyForm() {
            this.formData.ProductId = '',
            this.formData.ProductName = ''
            this.formData.file = null
            this.formData.Description = ''
            this.formData.Price = '',
            this.formData.ProductImage='',
            this.formData.CategoryId=null
        },
        handleFileChange(event) {
            this.formData.file = event.target.files[0];
        },
        getAllCategories() {
            CategoryService.getAll(-1).then(rs => {
                this.catergories=rs.data
            })
        }
    },
    watch: {
        idEdit(newValue) {
            if (newValue == null) {
                this.emtyForm()
            }
            else {
                ProductService.getById(newValue).then(rs => {
                    this.formData = rs.data
                }).catch(ex => {
                    alert("Lỗi" + ex)
                })
            }
        }
    }
}
</script>
<style scoped>

.bold-text {
    font-weight: bold;
    /* Đặt kiểu chữ đậm */
}
</style>