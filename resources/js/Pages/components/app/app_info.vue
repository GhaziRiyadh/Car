<template>
    <div>
        <!-- tables -->
        <div class="w-full h-full">
            <div class="flex items-center h-10 text-sm text-center border-b border-gray-500 my-2">
                <span v-text="'id'" class="mx-auto w-1/5 text-gray-600"></span>
                <span v-text="'عنا'" class="mx-auto w-1/5 text-gray-600"></span>
                <span v-text="'رقم الهاتف'" class="mx-auto w-1/5 text-gray-600"></span>
                <span v-text="'العنوان'" class="mx-auto w-1/5 text-gray-600"></span>
                <span v-text="'الايميل'" class="mx-auto w-1/5 text-gray-600"></span>
            </div>
            <div @click="showForm.update = true" class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div
                    class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-sm shadow-lg my-2 hover:bg-secondary hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <span v-text="'#' + item.id" class="mx-auto  w-1/5  "></span>
                    <span v-text="item.aboutUs" class="mx-auto w-1/5 "></span>
                    <span v-text="item.phone" class="mx-auto w-1/5 overflow-auto"></span>
                    <span v-text="item.address" class="mx-auto w-1/5 overflow-auto"></span>
                    <span v-text="item.email" class="mx-auto w-1/5 overflow-auto"></span>
                </div>
            </div>
        </div>

        <!-- edit from -->
        <MyForm :show="showForm.update">
            <!-- show-button -->
            <template #show>
                <!-- for loop from classes -->

            </template>
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-gray-900" v-text="editData.date"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="my-2 w-full">
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="الايميل"/>

                        <JetInput v-model="editData.email" type="email" class="mt-1 w-full block" placeholder="الايميل"/>

                        <JetInputError :message="editDataError.email[0]" class="mt-2"/>
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="العنوان"/>

                        <JetInput v-model="editData.address" type="text" class="mt-1 w-full block" placeholder="العنوان"/>

                        <JetInputError :message="editDataError.address[0]" class="mt-2"/>
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="التلفون"/>

                        <JetInput v-model="editData.phone" type="text" class="mt-1 w-full block" placeholder="التلفون"/>

                        <JetInputError :message="editDataError.phone[0]" class="mt-2"/>
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="عنا"/>

                        <textarea v-model="editData.aboutUs"
                                  class="border-gray-300 w-full h-32 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                  placeholder="عنا"/>

                        <JetInputError :message="editDataError.aboutUs[0]" class="mt-2"/>
                    </div>
                </div>
            </template>
            <template #model-footer>
                <div dir="rtl" class="w-full flex items-center justify-between">
                    <div>
                        <JetPrimaryButton @click="update" class="mx-5">
                            حفظ
                        </JetPrimaryButton>
                    </div>
                    <JetSecondaryButton @click="showForm.update = false">
                        الغاء
                    </JetSecondaryButton>
                </div>
            </template>
        </MyForm>
    </div>
</template>

<script>
import AppLayoutVue from '@/Layouts/AppLayout.vue'
import MyForm from '../my_form.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetPrimaryButton from '@/Jetstream/PrimaryButton.vue'
import JetDangButton from '@/Jetstream/DangerButton.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetLable from '@/Jetstream/Label.vue'
import axios from 'axios'

export default {
    components: {
        AppLayoutVue,
        MyForm,
        JetInput,
        JetInputError,
        JetPrimaryButton,
        JetSecondaryButton,
        JetDangButton,
        JetLable,
    },
    props: {
        getData: {
            type: Array,
            default: [{
                id: 1,
                phone: '',
                aboutUs: 'root',
                address: 'root',
                email: 'root',
            }]
        },
        updateForm: false,
    },
    data() {
        return {
            showForm: {
                update: this.updateForm
            },
            editDataError: {
                email: [''],
                address: [''],
                phone: [''],
                aboutUs: [''],
            },
            editData: {
                email: [''],
                address: [''],
                phone: [''],
                aboutUs: [''],
            },
            showData: this.getData,
        }
    },
    watch: {
        updateForm: function (nv, ov) {
            this.showForm.update = nv
        },
        getData: function (nv, ov) {
            this.showData = nv
        },
    },
    methods: {
        editForm(id) {
            this.editData = this.showData.find(item => item.id === id)
            this.showForm.update = true
        },
        update() {

            axios.post(route('app_info.update', {appInfo: this.editData.id}), {
                email: this.editData.email,
                address: this.editData.address,
                phone: this.editData.phone,
                aboutUs: this.editData.aboutUs,
            }).then(r => {
                this.showData = this.showData.map(v => {
                    if (v.id === this.editData.id) v = r.data[0]
                    return v
                })
                this.showForm.update = false;
                this.editData = {
                    email: '',
                    address: '',
                    phone: '',
                    aboutUs: '',
                }
                this.editDataError = {
                    email: [''],
                    address: [''],
                    phone: [''],
                    aboutUs: [''],
                }
                this.iamge = ''
            }).catch(er => {
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn',
                });
                this.editDataError = er.response.data.errors
            })
        },
    }

}
</script>

<style>
</style>
