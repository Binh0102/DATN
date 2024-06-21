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
                            <div class="d-flex mb-0">
    <v-btn type="submit" class="custom-button" @click="submitSearch">
      <v-icon class="mdi mdi-magnify" left></v-icon>
      Tìm kiếm
    </v-btn>

    <v-btn @click="this.showFormSerch = fale" class="custom-button ml-2">
      <v-icon class="mdi mdi-close-circle" left></v-icon>
      Đóng
    </v-btn>
  </div>
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
                <tr style="background-color: #fbf6f6;">
                    <th style="width:40px;color: ;text-align: center;border-right: 1px solid #CCC;">#</th>
                    <th style="color: black;text-align: center;border-right: 1px solid #CCC;">Acction</th>
                    <th style="color: black;text-align: center;border-right: 1px solid #CCC;">Loại sản phẩm</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="this.categories.length==0">
                    <td colspan="3" class="text-center text-red">Không có dữ liệu</td>
                </tr>
                <tr v-else v-for="(item, index) in categories" :key="item.CategoryId">
                    <td class="text-center" style="border-right: 1px solid #CCC;"><span>{{ index + 1 }}</span></td>
                    <td width="50px" style="border-right: 1px solid #CCC;">
                        <v-menu location="bottom">
                            <template v-slot:activator="{ props }">
                                <v-btn style="color:#2f5cef" border class="text-none" variant="text" v-bind="props">
                                    Acction
                                    <v-icon icon="mdi mdi-arrow-down-circle-outline" end />
                                </v-btn>
                            </template>
                            <v-list>
                                <v-list-item>
                                    <v-list-item-title style="cursor: pointer;" class="pa-1">
                                        <v-btn @click="editCategory(item)" style="color:#550648" border class="text-none"
                                            variant="text">
                                            Edit
                                            <v-icon icon="mdi mdi-pencil" end />
                                        </v-btn>
                                    </v-list-item-title>
                                    <v-list-item-title style="cursor: pointer;" class="pa-1">
                                        <v-btn @click="deleteCategory(item)" border class="text-none text-red"
                                            variant="text">
                                            Delete
                                            <v-icon icon="mdi mdi-delete" end />
                                        </v-btn>
                                    </v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </td>
                    <td style="border-right: 1px solid #CCC;">{{ item.CategoryName }}</td>
                </tr>
            </tbody>
        </v-table>
        <PageView v-show="this.showLoadingDialog==false" :page="this.page" @giam="this.page--" @tang="this.page++"/>
    </v-container>
    <ModalView v-model="showModal" :idEdit="this.idEdit" @close="closeModal()" @save="saveCategory" />
    <LoadingDialog v-model="showLoadingDialog" />
    <ToastMessage v-model="showAlert.show" :content="showAlert.content" :color="showAlert.color" :icon="showAlert.icon" />
</template>
<script>
import LoadingDialog from '@/components/Admin/LoadingDialog.vue'
import CategoryService from '@/Service/CategoryService'
import ModalView from '@/views/Admin/Category/ModalView.vue'
import ToastMessage from '@/components/Admin/ToastMessage.vue'
import PageView from '@/components/Admin/PageView.vue'
export default {
    components: { ModalView, LoadingDialog, ToastMessage ,PageView},
    name: "CategoryView",
    created() {
        this.getAllCategeries()
    },
    data() {
        return {
            showModal: false,
            categories: [],
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
        searchCategories() {
            // alert(this.textSearch)
            if (this.textSearch != '') {
                CategoryService.search(this.textSearch).then(rs => {
                    if (rs.leght == 0) {
                        this.categories = []
                        this.textSearch = ''
                    }
                    else {
                        this.categories = rs.data
                        this.textSearch = ''
                    }
                })
            }
            else{
                this.getAllCategeries()
            }
        },
        openModal() {
            this.idEdit = null
            this.showModal = true
        },
        closeModal() {
            this.showModal = false
        },
        saveCategory(item) {
            if (item.CategoryId) {
                CategoryService.update(item).then(rs => {
                    this.AlertSuccess('Cập nhật thành công')
                    this.showLoadingDialog = true
                    this.closeModal()
                    this.getAllCategeries()
                }).catch(ex => {
                    this.AlertError(ex.message)
                })
            }
            else {
                CategoryService.post(item).then(rs => {
                    this.AlertSuccess('Thêm thành công')
                    this.showLoadingDialog = true
                    this.closeModal()
                    this.getAllCategeries()
                }).catch(ex => {
                    this.AlertError(ex.message)
                })
            }
        },
        deleteCategory(item) {
            CategoryService.delete(item).then(rs => {
                this.AlertSuccess('Xóa thành công')
                this.showLoadingDialog = true
                setTimeout(() =>
                    (this.getAllCategeries())
                    , 500)
            }).catch(ex => {
                this.AlertError(ex.message)
            })
        },
        getAllCategeries() {
            CategoryService.getAll(this.page).then(rs => {
                this.categories = rs.data
                this.showLoadingDialog = false
                // if(this.categories.length===0)
                // {
                //     this.page=this.page-1
                //     this.AlertError("Đã hết")
                // }
            }).catch(ex => {
                this.AlertError(ex.message)
            })
        },
        editCategory(item) {
            this.showModal = true
            this.idEdit = item.CategoryId
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
        }
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
            this.getAllCategeries()
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