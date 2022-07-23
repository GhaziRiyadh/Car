<template>
    <div>
        <!-- tables -->
        <div class="w-full h-[60vh]">
            <div class="flex items-center h-10 text-sm text-center border-b border-secondary my-2">
                <snap v-text="'id'" class="mx-auto w-1/6 text-primary"></snap>
                <snap v-text="'الاسم'" class="mx-auto w-1/6 text-primary"></snap>
                <snap v-text="'القواعد'" class="mx-auto w-4/6 text-primary"></snap>
            </div>
            <div class="h-4/5 overflow-auto snap-y scroll-smooth bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-sm shadow-lg my-2 hover:bg-primary hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <snap v-text="'#' + item.id" class="mx-auto w-1/6 "></snap>
                    <snap v-text="item.name" class="mx-auto w-1/6 "></snap>
                    <snap class="mx-auto w-4/6 flex items-center justify-center">
                        <div class="px-2 mx-2 py-1 rounded-md text-sm bg-secondary bg-opacity-25"
                            v-for="(type, i) in item.roles" :key="i">
                            <div v-for="(item, i) in type" :key="i" v-text="item"></div>
                        </div>
                    </snap>
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
                    <h2 class="text-lg mx-au font-medium text-primary" v-text="'اظافة صلاحية'"> </h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="الاسم" />

                        <JetInput v-model="addData.name" type="text" class="mt-1 block" placeholder="الاسم" />

                        <JetInputError :message="addDataError.name[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="النوع" />

                        <div class="w-full bg-white h-20 overflow-auto">
                            <JetLable class="mb-2 w-full flex items-center" v-for="(item, i) in roles" :key="i">
                                <div class="flex items-center">
                                    <input v-model="addData.roles[item.id]" type="checkbox"
                                        class="mx-1 block rounded-md " />
                                    <span>{{ item.name }}</span>
                                </div>
                            </JetLable>
                        </div>

                        <JetInputError :message="addDataError.roles[0]" class="mt-2" />
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
                    <h2 class="text-lg mx-au font-medium text-primary" v-text="editData.name"> </h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="الاسم" />

                        <JetInput v-model="editData.name" type="text" class="mt-1 block" placeholder="الاسم" />

                        <JetInputError :message="editDataError.name[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLable class="mb-2" value="النوع" />

                        <div class="w-full bg-white h-20 overflow-auto">
                            <JetLable class="mb-2 w-full flex items-center" v-for="(item, i) in roles" :key="i">
                                <div class="flex items-center">
                                    <input v-model="checkRole[item.id]" type="checkbox"
                                        class="mx-1 block rounded-md " />
                                    <span>{{ item.name }}</span>
                                </div>
                            </JetLable>
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
                        <JetDangButton @click="deleteFun" class="mx-5">
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
import AppLayoutVue from '@/Layouts/AppLayout.vue'
import MyForm from '../../components/my_form.vue'
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
                name: 'root',
            }]
        },
        roles: {},
        addForm: false,
        updateForm: false,
    },
    data() {
        return {
            promissions: [],
            showForm: {
                add: this.addForm,
                update: this.updateForm
            },
            editDataError: {
                name: [''],
                roles: ['']
            },
            editData: {
                name: [''],
                roles: ['']
            },
            addData: {
                name: [''],
                roles: ['']
            },
            addDataError: {
                name: [''],
                roles: ['']
            },
            showData: this.getData,
            checkRole: [],
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
            this.editData = this.showData.find(item => item.id === id)
            let roles = this.editData.roles.map((v, k) => {
                for (const key in v) {
                    if (Object.hasOwnProperty.call(v, key)) {
                        return v[key];
                    }
                }
            })
            console.log(roles)
            for (const role of this.roles) {
                this.checkRole[role.id] = roles.includes(role.name)
            }
            this.showForm.update = true
        },
        store() {
            axios.post(route('permission.store'), {
                name: this.addData.name,
                roles: this.addData.roles,
            }).then(r => {
                this.showData.push(r.data[0])
                this.$emit('closeModel')
                this.addData = {
                    name: [''],
                    roles: ['']
                }
                this.addDataError = {
                    name: [''],
                    roles: ['']
                }
            }).catch(er => {

            })
        },
        update() {
            axios.post(route('permission.update', { permission: this.editData.id }), {
                name: this.editData.name,
                roles: this.checkRole,
            }).then(r => {
                this.showData = this.showData.map(v => {
                    if (v.id == this.editData.id) v = r.data[0]
                    return v
                })
                this.showForm.update = false;
                this.editData = {
                    name: [''],
                    roles: ['']
                }
                this.editDataError = {
                    name: [''],
                    roles: ['']
                }
            }).catch(er => {
                console.log(er);
            })
        },
        deleteFun() {
            axios.get(route('permission.delete', { permission: this.editData.id })).then(r => {
                this.showData = this.showData.filter(v => v.id != this.editData.id)

                this.showForm.update = false;
                this.editData = {
                    name: [''],
                    roles: ['']
                }
                this.editDataError = {
                    name: [''],
                    roles: ['']
                }
            }).catch(er => {

            })
        }
    }

}
</script>

<style>
</style>
