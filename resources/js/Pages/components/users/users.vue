<template>
    <div>
        <!-- tables -->
        <div class="w-full h-[60vh]">

            <div class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-xs whitespace-nowrap shadow-lg my-2 hover:bg-primary hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <span v-text="'#' + item.id" class="mx-auto w-1/6 "></span>
                    <span v-text="'الايميل: '+item.email" class="mx-auto w-1/6 "></span>
                    <span v-text="'الاسم:'+item.name" class="mx-auto w-1/6 "></span>
                    <span class="mx-auto w-2/6 flex items-center justify-center">
                        النوع:
                        <span class="px-2 mx-2 py-1 rounded-md bg-secondary bg-opacity-25"
                            v-for="(type, i) in item.type" :key="i" v-text="type"></span>
                    </span>
                    <span class="mx-auto w-2/6 flex items-center justify-center">
                        <span>الصلاحيات:</span>
                        <span class="flex items-center justify-center" v-for="(permission, i) in item.permissions"
                            :key="i">
                            <span class="rounded-md px-2 mx-2 py-1 bg-secondary bg-opacity-25"
                                v-for="(item, i) in permission" :key="i" v-text="item"></span>
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <!-- add from -->
        <MyForm show-btn-classes="w-full" :show="showForm.add">
            <!-- show-button -->
            <template #show>
                <!-- for loop from classes -->

            </template>
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-primary" v-text="editData.name"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الاسم" />

                        <JetInput v-model="addData.name" type="text" class="mt-1 block w-full" placeholder="الاسم" />

                        <JetInputError :message="addDataError.name[0]" class="mt-2" />
                    </div>

                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الايميل" />

                        <JetInput v-model="addData.email" type="email" class="mt-1 block w-full"
                            placeholder="الايميل" />

                        <JetInputError :message="addDataError.email[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="كلمة المرور" />

                        <JetInput v-model="addData.password" type="password" class="mt-1 block w-full"
                            placeholder="كلمة المرور" />

                        <JetInputError :message="addDataError.password[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="النوع" />

                        <div class="w-full bg-white h-20 overflow-auto">
                            <JetLabel class="mb-2 w-full flex items-center" v-for="(item, i) in roles" :key="i">
                                <div class="flex items-center">
                                    <input v-model="addData.roles[item.id]" type="checkbox"
                                        class="mx-1 block rounded-md " />
                                    <span>{{ item.name }}</span>
                                </div>
                            </JetLabel>
                        </div>

                        <JetInputError  :message="addDataError.roles[0]" class="mt-2" />
                    </div>
                </div>

            </template>
            <template #model-footer>
                <div dir="rtl" class="w-full flex items-center justify-between">
                    <JetPrimaryButton @click="store">
                        حفظ
                    </JetPrimaryButton>
                    <JetSecondaryButton @click="$emit('closeModel')">
                        الغاء
                    </JetSecondaryButton>
                </div>
            </template>
        </MyForm>

        <!-- edit from -->
        <MyForm show-btn-classes="w-full" :show="showForm.update">
            <!-- show-button -->
            <template #show>
                <!-- for loop from classes -->

            </template>
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-primary" v-text="editData.name"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الاسم" />

                        <JetInput v-model="editData.name" type="text" class="mt-1 block w-full" placeholder="الاسم" />

                        <JetInputError :message="editDataError.name[0]" class="mt-2" />
                    </div>

                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الايميل" />

                        <JetInput v-model="editData.email" type="text" class="mt-1 block w-full"
                            placeholder="الايميل" />

                        <JetInputError :message="editDataError.email[0]" class="mt-2" />
                    </div>

                     <div v-if="editData.id !== 1" dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="النوع" />

                        <div class="w-full bg-white h-20 overflow-auto">
                            <JetLabel class="mb-2 w-full flex items-center" v-for="(item, i) in roles" :key="i">
                                <div class="flex items-center">
                                    <input v-model="checkRole[item.id]" type="checkbox"
                                        class="mx-1 block rounded-md " />
                                    <span>{{ item.name }}</span>
                                </div>
                            </JetLabel>
                        </div>

                        <JetInputError :message="editDataError.roles[0]" class="mt-2" />
                    </div>
                </div>
            </template>
            <template #model-footer>
                <div dir="rtl" class="w-full flex items-center justify-between">
                    <div>
                        <JetPrimaryButton @click="update" class="mx-5">
                            حفظ
                        </JetPrimaryButton>
                        <JetDangButton v-if="editData.id !== 1" @click="deleteFun" class="mx-5">
                            حذف
                        </JetDangButton>
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
import AppLayoutVue from '../../../Layouts/AppLayout.vue'
import MyForm from '../../components/my_form.vue'
import JetInput from '../../../Jetstream/Input.vue'
import JetInputError from '../../../Jetstream/InputError.vue'
import JetPrimaryButton from '../../../Jetstream/PrimaryButton.vue'
import JetDangButton from '../../../Jetstream/DangerButton.vue'
import JetSecondaryButton from '../../../Jetstream/SecondaryButton.vue'
import JetLabel from '../../../Jetstream/Label.vue'
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
        JetLabel,
    },
    props: {
        getData: {
            type: Array,
            default: [{
                id: 1,
                name: 'root',
                email: 'email@gmail.com',
                type: 'admin',
                permissions: [
                    'reed',
                    'write'
                ]
            }]
        },
        roles: {},
        addForm: false,
        updateForm: false,

    },
    data() {
        return {
            permission: [],
            showForm: {
                add: this.addForm,
                update: this.updateForm
            },
            editDataError: {
                name: [''],
                email: [''],
                password: [''],
                roles: [''],
            },
            editData: {
                name: '',
                email: '',
                password: '',
                roles: [],
            },
            addData: {
                name: '',
                email: '',
                password: '',
                roles: [],
            },
            addDataError: {
                name: [''],
                email: [''],
                password: [''],
                roles: [''],
            },
            showData: this.getData,
            checkRole: [],
            showLevel: false,
        }
    },
    watch: {
        addForm: function (nv, ov) {
            this.showForm.add = nv
        },
        updateForm: function (nv, ov) {
            this.showForm.update = nv
        },
        getData: function (nv, ov) {
            this.showData = nv
        },
    },
    methods: {
        editForm(id) {
            for (const item of this.showData) {
                if (item.id === id) {
                    this.editData = {
                        id: item.id,
                        name: item.name,
                        email: item.email,
                        roles: item.type,
                    }
                    break;
                }
            }
            for (const role of this.roles) {
                this.checkRole[role.id] = this.editData.roles.includes(role.name)
            }
            this.showForm.update = true
        },
        store() {
            axios.post(route('user.store'), {
                name: this.addData.name,
                roles: this.addData.roles,
                email: this.addData.email,
                password: this.addData.password,

            }).then(r => {
                this.showData.push(r.data[0])
                this.$emit('closeModel')
                this.addData = {
                    name: '',
                    email: '',
                    password: '',
                    roles: [],
                }
                this.addDataError = {
                    name: [''],
                    email: [''],
                    password: [''],
                    roles: [''],
                }
                this.$notify({
                    title: 'تم',
                    text: 'كل شيئ على مايرام',
                    type: 'success',
                })
            }).catch(er => {
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn',
                });
            })
        },
        update() {
            axios.post(route('user.update', { id: this.editData.id }), {
                name: this.editData.name,
                roles: this.checkRole,
                email: this.editData.email,
            }).then(r => {
                this.showData = this.showData.map(v => {
                    if (v.id === this.editData.id) v = r.data[0]
                    return v
                })
                this.showForm.update = false;
                this.editData = {
                    name: '',
                    email: '',
                    password: '',
                    roles: [],
                }
                this.editDataError = {
                    name: [''],
                    email: [''],
                    password: [''],
                    roles: [''],
                }
                this.$notify({
                    title: 'تم',
                    text: 'كل شيئ على مايرام',
                    type: 'success',
                })
            }).catch(er => {
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn',
                });
            })
        },
        deleteFun() {
            axios.get(route('user.delete', { id: this.editData.id })).then(r => {
                this.showData = this.showData.filter(v => v.id !== this.editData.id)
                this.showForm.update = false;
                this.editData = {
                    name: '',
                    email: '',
                    password: '',
                    roles: [],
                }
                this.editDataError = {
                    name: [''],
                    email: [''],
                    password: [''],
                    roles: [''],
                }
                this.$notify({
                    title: 'تم',
                    text: 'كل شيئ على مايرام',
                    type: 'success',
                })
            }).catch(er => {
                console.log(er)
                this.$notify({
                    title: 'Error',
                    text: 'حدث خطاء ما!',
                    type: 'warn',
                });
            })
        }
    }

}
</script>

<style>
</style>
