<template>
    <v-dialog width="400px">
        <v-container>
            <v-card>
                <v-card-title class="text-center mb-2">
                    {{ this.idEdit != null ? 'Sửa loại sản phẩm' : 'Thêm loại sản phẩm' }}
                </v-card-title>
                <v-card-text>
                    <v-sheet width="300" class="mx-auto">
                        <v-form fast-fail @submit.prevent="save()">
                            <v-text-field v-model="this.formData.CategoryName" label="Loại sản phẩm"></v-text-field>
                            <v-btn color="black" type="submit" block class="mt-2">{{ this.idEdit != null ? 'Cập nhật' : 'Thêm' }}</v-btn>
                        </v-form>
                    </v-sheet>
                </v-card-text>
            </v-card>
        </v-container>
    </v-dialog>
</template>

<script>
import CategoryService from '@/Service/CategoryService'
export default {
    props:{
        idEdit: null
    },
    data() {
        return {
            formData: {
                CategoryId: '',
                CategoryName: '',
            }
        }
    },
    methods: {
        save() {
            this.$emit("save", this.formData);
            // this.$emit("reset-form"); // Gửi sự kiện reset-form khi thêm thành công
            this.emtyForm()
        },
        closeDialog() {
            this.$emit("close")
        },
        emtyForm() {
            this.formData.CategoryId='',
            this.formData.CategoryName=''
        }
    },
    watch:{
        idEdit(newValue)
        {
            if(newValue==null)
            {
                this.emtyForm()
            }
            else
            {
                CategoryService.getById(newValue).then(rs=>
                {
                    this.formData=rs.data
                }).catch(ex=>{
                    alert("Lỗi"+ex)
                })
            }
        }
    }
}
</script>

<style></style>
