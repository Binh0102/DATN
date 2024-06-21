<template>
    <div class="d-flex flex-row-reverse mb-0">
    <v-sheet @click="openModal()" class="custom-button ma-2 pa-2">
      <v-icon class="mdi mdi-plus"></v-icon>
      Thêm mới
    </v-sheet>

    <v-sheet @click="showFormSerch = !showFormSerch" class="custom-button ma-2 pa-2">
      <v-icon class="mdi mdi-magnify"></v-icon>
      Tìm kiếm
    </v-sheet>
  </div>    
    <v-container>
        <v-slide-y-transition>
            <div v-show="this.showFormSerch" class="rounded-0" style="background-color: #F5F5F5;">
                <v-row>
                    <v-col cols="4"> <!-- Một cột chiếm toàn bộ chiều rộng -->
                        <div></div>
                    </v-col>
                    <v-col cols="4"> <!-- Một cột chiếm một nửa chiều rộng -->
                        <v-form @submit.prevent="searchCategories()">
                            <v-text-field label="Loại sản phẩm" v-model="this.textSearch"></v-text-field>
                            <v-btn type="submit" class="rounded-0" style="background-color: #fef7fd;color: black;">
                                <v-icon class="mdi mdi-magnify" start></v-icon>
                                Tìm kiếm
                            </v-btn>
                            <v-btn @click="this.showFormSerch = false" class="rounded-0 ml-2"
                                style="background-color: rgb(255, 255, 255);color: black;">
                                <v-icon class="mdi mdi-close-circle" start></v-icon>
                                Đóng
                            </v-btn>
                        </v-form>
                    </v-col>
                    <v-col cols="4"> <!-- Một cột chiếm một nửa chiều rộng -->
                        <div></div>
                    </v-col>
                </v-row>

            </div>
        </v-slide-y-transition>
    </v-container>
    <v-container>
        <v-table class="elevation-1">
            <thead>
                <tr style="background-color: #d1c4d1;">
                    <th style="width:40px;color: black;text-align: center;border-right: 1px solid #CCC;">#</th>
                    <th style="color: black;text-align: center;border-right: 1px solid #CCC;">Action</th>
                    <th style="color: black;text-align: center;border-right: 1px solid #CCC;">Tên Sản Phẩm</th>
                    <th style="color: black;text-align: center;border-right: 1px solid #CCC;">Ảnh</th>
                    <th style="color: black;text-align: center;border-right: 1px solid #CCC;">Giá</th>
                    <th style="color: black;text-align: center;border-right: 1px solid #CCC;">Mô tả</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="this.products.length==0">
                    <td colspan="3" class="text-center text-red">Không có dữ liệu</td>
                </tr>
                <tr v-else v-for="(item, index) in products" :key="item.CategoryId">
                    <td class="text-center" width="30px" style="border-right: 1px solid #CCC;"><span>{{ index+1 }}</span></td>
                    <td width="50px" style="border-right: 1px solid #CCC;">
                        <v-menu location="bottom">
                            <template v-slot:activator="{ props }">
                                <v-btn style="color:#550648" border class="text-none" variant="text" v-bind="props">
                                    Acction
                                    <v-icon icon="mdi mdi-arrow-down-circle-outline" end />
                                </v-btn>
                            </template>
                            <v-list>
                                <v-list-item>
                                    <v-list-item-title style="cursor: pointer;" class="pa-1">
                                        <v-btn @click="editProduct(item)" style="color:#6809ed" border class="text-none"
                                            variant="text">
                                            Sửa thông tin
                                            <v-icon icon="mdi mdi-pencil" end />
                                        </v-btn>
                                    </v-list-item-title>
                                    <v-list-item-title style="cursor: pointer;" class="pa-1">
                                        <v-btn @click="deleteProduct(item)" border class="text-none text-red"
                                            variant="text">
                                            Xóa
                                            <v-icon icon="mdi mdi-delete" end />
                                        </v-btn>
                                    </v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </td>
                    <td style="border-right: 1px solid #CCC;">{{ item.ProductName }}</td>
                    <td class="text-center pa-1" style="border-right: 1px solid #CCC;"><img width="80" height="60" :src="item.ProductImage"></td>
                    <td style="border-right: 1px solid #CCC;">{{ formatCurrency(item.Price) }}</td>
                    <td style="border-right: 1px solid #CCC;">{{ item.Description }}</td>
                </tr>
            </tbody>
        </v-table>
        <PageView v-show="this.showLoadingDialog==false" :page="this.page" @giam="this.page--" @tang="this.page++"/>
    </v-container>
    <ModalView v-model="showModal" :idEdit="this.idEdit" @close="closeModal()" @save="saveProduct" />
    <LoadingDialog v-model="showLoadingDialog" />
    <ToastMessage v-model="showAlert.show" :content="showAlert.content" :color="showAlert.color" :icon="showAlert.icon" />
</template>
<script>
import LoadingDialog from '@/components/Admin/LoadingDialog.vue'
import ProductService from '@/Service/ProductService'
import ModalView from '@/views/Admin/Product/ModalView.vue'
import ToastMessage from '@/components/Admin/ToastMessage.vue'
import PageView from '@/components/Admin/PageView.vue'
export default {
    components: { ModalView, LoadingDialog, ToastMessage ,PageView},
    name: "CategoryView",
    created() {
        this.getAllProducts()
    },
    data() {
        return {
            showModal: false,
            products: [],
            idEdit: null,
            showLoadingDialog: true,
            showAlert: {
                show: false,
                icon: '$success',
                content: '',
                color: 'success'
            },
            showFormSerch: false,
            textSearch: '',
            page:1,
        }
    },
    methods:
    {
        // searchCategories() {
        //     // alert(this.textSearch)
        //     if (this.textSearch != '') {
        //         CategoryService.search(this.textSearch).then(rs => {
        //             if (rs.leght == 0) {
        //                 this.products = []
        //                 this.textSearch = ''
        //             }
        //             else {
        //                 this.products = rs.data
        //                 this.textSearch = ''
        //             }
        //         })
        //     }
        //     else{
        //         this.getAllProducts()
        //     }
        // },
        openModal() {
            this.idEdit = null
            this.showModal = true
        },
        closeModal() {
            this.showModal = false
        },
        saveProduct(item) {
            if (item.ProductId!='') {
                ProductService.update(item).then(rs => {
                    this.AlertSuccess('Cập nhật thành công')
                    this.showLoadingDialog = true
                    this.closeModal()
                    this.getAllProducts()
                }).catch(ex => {
                    this.AlertError(ex.message)
                })
            }
            else {
                this.showLoadingDialog = true
                ProductService.post(item).then(rs => {
                    this.AlertSuccess('Thêm thành công')
                    this.closeModal()
                    this.getAllProducts()
                }).catch(ex => {
                    this.AlertError(ex.message)
                })
            }
        },
        deleteProduct(item) {
            ProductService.delete(item).then(rs => {
                this.AlertSuccess('Xóa thành công')
                this.showLoadingDialog = true
                this.getAllProducts()
            }).catch(ex => {
                this.AlertError(ex.message)
            })
        },
        getAllProducts() {
            ProductService.getAll(this.page).then(rs => {
                this.products = rs.data
                this.showLoadingDialog = false
            }).catch(ex => {
                this.AlertError(ex.message)
            })
        },
        editProduct(item) {
            this.showModal = true
            this.idEdit = item.ProductId
        },
        AlertSuccess(content) {
            this.showAlert.show = true
            this.showAlert.icon = '$success'
            this.showAlert.content = content
            this.showAlert.color = 'success'
        },
        AlertError(content) {
            this.showAlert.show = true
            this.showAlert.content = content
            this.showAlert.icon = '$error'
            this.showAlert.color = 'error'
        },
        formatCurrency(value) {
            const formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            });

            return formatter.format(value);
        },
    },
    watch: {
        showAlert: {
            deep: true,
            handler(newVal) {
                if (!newVal.show)
                    return
                setTimeout(() =>
                    (this.showAlert.show = false)
                    , 3000)
            },
        },
        page(newVal)
        {
            if(newVal<=0)
                this.page=1
            this.getAllProducts()
        }
    }

}
</script>

<style scoped>
.custom-button {
  border: none;
  background-color: #faf8fa;
  color: black;
  border-radius: 8px;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.custom-button:hover {
  background-color: #726672;
}

.custom-button:active {
  transform: scale(0.95); /* Hiệu ứng nhấn nút */
}

.custom-button v-icon {
  margin-right: 8px;
}
</style>