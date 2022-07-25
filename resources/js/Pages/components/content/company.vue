<template>
    <div>
        <!-- tables -->
        <div class="w-full h-full">
            <div class="h-full overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-xs shadow-lg my-2 hover:bg-secondary hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <span class="mx-auto w-2/6 whitespace-nowrap overflow-auto ">#{{ item.id }}</span>
                    <span class="mx-auto w-4/6 whitespace-nowrap overflow-auto ">اسم الشركة: {{ item.name }}</span>
                </div>
            </div>
        </div>

        <!-- add from -->
        <MyForm :show="showForm.add">
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-primary" v-text="'اظافة'"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class=" my-2">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="اسم الشركة" />

                        <JetInput v-model="addData.name" type="text" class="mt-1 block w-full"
                            placeholder="اسم الشركة" />

                        <JetInputError :message="addDataError.name[0]" class="mt-2" />
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
        <MyForm :show="showForm.update">
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-primary" v-text="editData.date"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="w-full my-2">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="اسم الشركة" />

                        <JetInput v-model="editData.name" type="text" class="mt-1 block w-full"
                            placeholder="اسم الشركة" />

                        <JetInputError :message="editDataError.name[0]" class="mt-2" />
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
import AppLayoutVue from '../../../Layouts/AppLayout.vue'
import MyForm from '../my_form.vue'
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
        getData: {},
        roles: {},
        addForm: false,
        updateForm: false,
        type: '',
    },
    data() {
        return {
            showForm: {
                add: this.addForm,
                update: this.updateForm
            },
            editDataError: {
                name: [''],

            },
            editData: {
                name: '',

            },
            addData: {
                name: '',
            },
            addDataError: {
                name: [''],
            },
            showData: this.getData,
            showRoles: this.roles,
            checkRole: [],
            isType: this.type,
            showReason: false,
            student: [{}],
            checkStudent: [],
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
        roles: function (nv, ov) {
            this.showRoles = nv
        },
        type: function (nv, ov) {
            this.isType = nv
        }
    },
    methods: {
        store() {
            axios.post(route('company.store'), {
                name: this.addData.name,
            }).then(r => {
                this.showData.push(r.data[0])
                this.$emit('closeModel')
                this.addData = {
                    name: '',
                }
                this.addDataError = {
                    name: [''],
                }

                this.showForm.add = false
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
                console.log(er.response)
                if (er.response) {
                    this.addDataError = {
                        name: er.response.data.errors.name ? er.response.data.errors.name : [''],
                    }
                }
            })
        },
        editForm(id) {
            for (const item of this.showData) {
                if (item.id === id) {
                    this.editData = {
                        id: item.id,
                        name: item.name,
                    }
                    break;
                }
            }
            this.showForm.update = true
        },
        update() {
            axios.post(route('company.update', { company: this.editData.id }), {
                name: this.editData.name,
            }).then(r => {
                this.showData = this.showData.map(v => {
                    if (v.id === this.editData.id) v = r.data[0]
                    return v
                })
                this.showForm.update = false;
                this.editData = {
                    name: '',
                }
                this.editDataError = {
                    name: [''],
                }
                return this.$notify({
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
                if (er.response) {
                    this.editDataError = {
                        name: er.response.data.errors.name ? er.response.data.errors.name : [''],
                    }
                }
                console.log(er)
            })
        },
        deleteFun() {
            axios.get(route('company.delete', { company: this.editData.id })).then(r => {
                this.showData = this.showData.filter(v => v.id !== this.editData.id)
                this.showForm.update = false;
                this.addData = {
                    name: '',
                }
                this.addDataError = {
                    name: [''],
                }
                this.editData = {
                    name: '',
                }
                this.editDataError = {
                    name: [''],
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
        },
        getStudents(id = null) {
            let url;
            if (id)
                url = '/get-students/' + id
            else
                url = '/get-students'

            axios.get(url).then(r => {
                if (id)
                    this.checkStudent = r.data
                else
                    this.student = r.data
            }).catch(er => {
                console.log(er)
            })
        }
    }
}
</script>
