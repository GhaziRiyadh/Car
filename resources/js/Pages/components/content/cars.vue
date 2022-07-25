<template>
    <div>
        <!-- tables -->
        <div class="w-full h-full ">
            <div class="h-full overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-xs shadow-lg my-2 hover:bg-secondary hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto ">#{{ item.id }}</span>
                    <span class="mx-auto w-2/6 whitespace-nowrap overflow-auto ">اسم السيارة: {{ item.name }}</span>
                    <span class="mx-auto w-2/6 whitespace-nowrap overflow-auto ">اسم الشركة: {{ item.company }}</span>
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto ">العام: {{ item.year }}</span>
                    <span class="mx-auto w-2/6 whitespace-nowrap overflow-auto ">الموديل: {{ item.model }}</span>
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
                <div class="grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="اسم السيارة" />

                        <JetInput v-model="addData.name" type="text" class="mt-1 block w-full"
                            placeholder="اسم السيارة" />

                        <JetInputError :message="addDataError.name[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الموديل" />

                        <JetInput v-model="addData.model" type="number" class="mt-1 block w-full"
                            placeholder="الموديل" />

                        <JetInputError :message="addDataError.model[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="العام" />

                        <input v-model="addData.year" type="number" min="1940"
                            class="mt-1 block w-full border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full"
                            placeholder="العام" />

                        <JetInputError :message="addDataError.year[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="اللون" />

                        <JetInput v-model="addData.color" type="color" class="mt-1 block w-full" placeholder="اللون" />

                        <JetInputError :message="addDataError.color[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الشركة" />

                        <select v-model="addData.company"
                            class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm"
                                v-for="(item, index) in showRoles.company" :key="index" :value="item.id"
                                v-text="item.name"></option>
                        </select>

                        <JetInputError :message="addDataError.company[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="نوع المحرك" />

                        <select v-model="addData.motor_type"
                            class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm" v-for="(item, index) in motor_type"
                                :key="index" :value="item" v-text="item"></option>
                        </select>

                        <JetInputError :message="addDataError.motor_type[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="نوع الوقود" />

                        <select v-model="addData.oil_type"
                            class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm" v-for="(item, index) in oil_type"
                                :key="index" :value="item" v-text="item"></option>
                        </select>

                        <JetInputError :message="addDataError.oil_type[0]" class="mt-2" />
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
                <div class="grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="اسم السيارة" />

                        <JetInput v-model="editData.name" type="text" class="mt-1 block w-full"
                            placeholder="اسم السيارة" />

                        <JetInputError :message="editDataError.name[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الموديل" />

                        <JetInput v-model="editData.model" type="number" class="mt-1 block w-full"
                            placeholder="الموديل" />

                        <JetInputError :message="editDataError.model[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="العام" />

                        <input v-model="editData.year" type="number" min="1940"
                            class="mt-1 block w-full border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full"
                            placeholder="العام" />

                        <JetInputError :message="editDataError.year[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="اللون" />

                        <JetInput v-model="editData.color" type="color" class="mt-1 block w-full" placeholder="اللون" />

                        <JetInputError :message="editDataError.color[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الشركة" />

                        <select v-model="editData.company"
                            class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm"
                                v-for="(item, index) in showRoles.company" :key="index" :value="item.id"
                                v-text="item.name"></option>
                        </select>

                        <JetInputError :message="editDataError.company[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="نوع المحرك" />

                        <select v-model="editData.motor_type"
                            class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm" v-for="(item, index) in motor_type"
                                :key="index" :value="item" v-text="item"></option>
                        </select>

                        <JetInputError :message="editDataError.motor_type[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="نوع الوقود" />

                        <select v-model="editData.oil_type"
                            class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm" v-for="(item, index) in oil_type"
                                :key="index" :value="item" v-text="item"></option>
                        </select>

                        <JetInputError :message="editDataError.oil_type[0]" class="mt-2" />
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
                company: [''],
                model: [''],
                color: [''],
                oil_type: [''],
                motor_type: [''],
                year: [''],
            },
            editData: {
                name: '',
                company: '',
                model: '',
                color: '',
                oil_type: 'ديزل',
                motor_type: 6,
                year: 2000,
            },
            addData: {
                name: '',
                company: '',
                model: '',
                color: '',
                oil_type: 'ديزل',
                motor_type: 6,
                year: 2000,
            },
            addDataError: {
                name: [''],
                company: [''],
                model: [''],
                color: [''],
                oil_type: [''],
                motor_type: [''],
                year: [''],
            },
            oil_type: ['بترول', 'ديزل'],
            motor_type: [6, 4, 12, 8],
            showData: this.getData,
            showRoles: this.roles,
            isType: this.type,
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
            axios.post(route('car.store'), {
                name: this.addData.name,
                company_id: this.addData.company,
                model: this.addData.model,
                color: this.addData.color,
                year: this.addData.year,
                oil_type: this.addData.oil_type,
                motor_type: this.addData.motor_type,
            }).then(r => {
                this.showData.push(r.data[0])
                this.$emit('closeModel')
                this.addData = {
                    name: '',
                    company: '',
                    model: '',
                    color: '',
                    oil_type: 'ديزل',
                    motor_type: 6,
                    year: 2000,
                }
                this.addDataError = {
                    name: [''],
                    company: [''],
                    model: [''],
                    color: [''],
                    oil_type: [''],
                    motor_type: [''],
                    year: [''],
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
                        company: er.response.data.errors.company ? er.response.data.errors.company : [''],
                        model: er.response.data.errors.model ? er.response.data.errors.model : [''],
                        year: er.response.data.errors.year ? er.response.data.errors.year : [''],
                        oil_type: er.response.data.errors.oil_type ? er.response.data.errors.oil_type : [''],
                        color: er.response.data.errors.color ? er.response.data.errors.color : [''],
                        motor_type: er.response.data.errors.motor_type ? er.response.data.errors.motor_type : [''],
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
                        company: this.showRoles.company.find(val => val.name === item.company).id,
                        model: item.model,
                        color: item.color,
                        year: item.year,
                        oil_type: item.oil_type,
                        motor_type: item.motor_type,
                    }
                    break;
                }
            }
            this.showForm.update = true
        },
        update() {
            axios.post(route('car.update', { car: this.editData.id }), {
                name: this.editData.name,
                company_id: this.editData.company,
                model: this.editData.model,
                color: this.editData.color,
                year: this.editData.year,
                oil_type: this.editData.oil_type,
                motor_type: this.editData.motor_type,
            }).then(r => {
                this.showData = this.showData.map(v => {
                    if (v.id === this.editData.id) v = r.data[0]
                    return v
                })
                this.showForm.update = false;
                this.editData = {
                    name: '',
                    company: '',
                    model: '',
                    color: '',
                    oil_type: 'ديزل',
                    motor_type: 6,
                    year: 2000,
                }
                this.editDataError = {
                    name: [''],
                    company: [''],
                    model: [''],
                    color: [''],
                    oil_type: [''],
                    motor_type: [''],
                    year: [''],
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
                        company: er.response.data.errors.company ? er.response.data.errors.company : [''],
                        model: er.response.data.errors.model ? er.response.data.errors.model : [''],
                        year: er.response.data.errors.year ? er.response.data.errors.year : [''],
                        oil_type: er.response.data.errors.oil_type ? er.response.data.errors.oil_type : [''],
                        color: er.response.data.errors.color ? er.response.data.errors.color : [''],
                        motor_type: er.response.data.errors.motor_type ? er.response.data.errors.motor_type : [''],
                    }
                }
                console.log(er)
            })
        },
        deleteFun() {
            axios.get(route('car.delete', { car: this.editData.id })).then(r => {
                this.showData = this.showData.filter(v => v.id !== this.editData.id)
                this.showForm.update = false;
                this.addData = {
                    name: '',
                    company: '',
                    model: '',
                    color: '',
                    oil_type: 'ديزل',
                    motor_type: 6,
                    year: 2000,
                }
                this.addDataError = {
                    name: [''],
                    company: [''],
                    model: [''],
                    color: [''],
                    oil_type: [''],
                    motor_type: [''],
                    year: [''],
                }
                this.editData = {
                    name: '',
                    company: '',
                    model: '',
                    color: '',
                    oil_type: 'ديزل',
                    motor_type: 6,
                    year: 2000,
                }
                this.editDataError = {
                    name: [''],
                    company: [''],
                    model: [''],
                    color: [''],
                    oil_type: [''],
                    motor_type: [''],
                    year: [''],
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
    }
}
</script>
