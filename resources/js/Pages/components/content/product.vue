<template>
    <div>
        <!-- tables -->
        <div class="w-full h-[60vh]">
            <div class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div
                    class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-xs shadow-lg my-2 hover:bg-primary hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto ">#{{ item.id }}</span>
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto flex items-center justify-around">
                        <span>الاسم:</span>
                        <span>{{ item.name }}</span>
                    </span>
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto flex items-center justify-around">
                        <span>السعر:</span>
                        <span>{{ item.price }}</span>
                    </span>
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto flex items-center justify-around">
                        <span>السيارة:</span>
                        <span>{{ item.car }}</span>
                    </span>
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto flex items-center justify-around">
                        <span>الجودة:</span>
                        <span>{{ item.quality }}</span>
                    </span>
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
                <div class=" w-full my-2">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الاسم"/>

                        <JetInput v-model="addData.name" type="text" class="mt-1 block w-full" placeholder="الاسم"/>

                        <JetInputError :message="addDataError.name[0]" class="mt-2"/>
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="السعر"/>

                        <JetInput v-model="addData.price" type="text" class="mt-1 block w-full" placeholder="الاسم"/>

                        <JetInputError :message="addDataError.price[0]" class="mt-2"/>
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="النسبة"/>

                        <JetInput v-model="addData.percentage_of_sale" type="text" class="mt-1 block w-full" placeholder="الاسم"/>

                        <JetInputError :message="addDataError.percentage_of_sale[0]" class="mt-2"/>
                    </div>
                     <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الصورة" />

                        <input
                            class="w-full rounded-md file:bg-secondary file:text-white file:px-4 file:py-2 p-2 file:rounded-md border file:hover:bg-primary file:border-none file:hover:shadow-lg"
                            type="file" @change="setTo">


                        <JetInputError :message="addDataError.image[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="السيارة"/>

                        <select v-model="addData.car_id"
                                class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm"
                                    v-for="(item, index) in showRoles.car" :key="index" :value="item.id"
                                    v-text="item.name"></option>
                        </select>

                        <JetInputError :message="addDataError.car_id[0]" class="mt-2"/>
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الجودة"/>

                        <select v-model="addData.quality_id"
                                class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm"
                                    v-for="(item, index) in showRoles.quality" :key="index" :value="item.id"
                                    v-text="item.name"></option>
                        </select>

                        <JetInputError :message="addDataError.quality_id[0]" class="mt-2"/>
                    </div>
                </div>
            </template>
            <template #model-footer>
                <div dir="rtl" class="w-full flex items-center justify-between">
                    <JetPrimaryButton @click="store()">
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
            <template #model-footer>
                <div dir="rtl" class="w-full flex items-center justify-between">
                    <div>
                        <JetPrimaryButton @click="update()" class="mx-5">
                            حفظ
                        </JetPrimaryButton>
                        <JetDangButton @click="deleteFun()" class="mx-5">
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
    },
    data() {
        return {
            showForm: {
                add: this.addForm,
                update: this.updateForm
            },
            editDataError: {
                name: [''],
                price: [''],
                quality_id: [''],
                car_id: [''],
                image: [''],
                percentage_of_sale: [''],
            },
            editData: {
                name: '',
                price: '',
                quality_id: '',
                car_id: '',
                image: '',
                percentage_of_sale: '',
            },
            addData: {
                name: '',
                price: '',
                quality_id: '',
                car_id: '',
                image: '',
                percentage_of_sale: '',
            },
            addDataError: {
                name: [''],
                price: [''],
                quality_id: [''],
                car_id: [''],
                image: [''],
                percentage_of_sale: [''],
            },
            showData: this.getData,
            showRoles: this.roles,
            isType: this.type,
            image: this.getData.image[0]?.path,
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
            let form = new FormData()
            form.append('name', this.addData.name)
            form.append('image', this.addData.image)
            form.append('price', this.addData.price)
            form.append('percentage_of_sale', this.addData.percentage_of_sale)
            form.append('car_id', this.addData.car_id)
            form.append('quality_id', this.addData.quality_id)
            axios.post(route('product.store'), form).then(r => {
                this.showData.push(r.data.product[0])
                this.$emit('closeModel')
                this.addData = {
                    name: '',
                    price: '',
                    quality_id: '',
                    car_id: '',
                    image: '',
                    percentage_of_sale: '',
                }
                this.addDataError = {
                    name: [''],
                    price: [''],
                    quality_id: [''],
                    car_id: [''],
                    image: [''],
                    percentage_of_sale: [''],
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
                        image: er.response.data.errors.image ? er.response.data.errors.image : [''],
                        quality_id: er.response.data.errors.quality_id ? er.response.data.errors.quality_id : [''],
                        car_id: er.response.data.errors.car_id ? er.response.data.errors.car_id : [''],
                        price: er.response.data.errors.price ? er.response.data.errors.price : [''],
                        percentage_of_sale: er.response.data.errors.percentage_of_sale ? er.response.data.errors.percentage_of_sale : [''],
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
                        percentage_of_sale: item.percentage_of_sale,
                        price: item.price,
                        car: this.roles.car.find(val => val.name === item.car)?.id,
                        quality: this.roles.quality.find(val => val.name === item.quality)?.id,
                    }
                    break;
                }
            }
            this.showForm.update = true
        },
        update() {
            let form = new FormData()
            form.append('name', this.addData.name)
            form.append('image', this.addData.image)
            form.append('price', this.addData.price)
            form.append('percentage_of_sale', this.addData.percentage_of_sale)
            form.append('car_id', this.addData.car_id)
            form.append('quality_id', this.addData.quality_id)
            axios.post(route('product.update', {product: this.editData.id}), form).then(r => {
                this.showData = this.showData.map(v => {
                    if (v.id === this.editData.id) v = r.data.product[0]
                    return v
                })
                this.showForm.update = false;
                this.editData = {
                    name: '',
                    price: '',
                    quality_id: '',
                    car_id: '',
                    image: '',
                    percentage_of_sale: '',
                }
                this.editDataError = {
                    name: [''],
                    price: [''],
                    quality_id: [''],
                    car_id: [''],
                    image: [''],
                    percentage_of_sale: [''],
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
                        image: er.response.data.errors.image ? er.response.data.errors.image : [''],
                        quality_id: er.response.data.errors.quality_id ? er.response.data.errors.quality_id : [''],
                        car_id: er.response.data.errors.car_id ? er.response.data.errors.car_id : [''],
                        price: er.response.data.errors.price ? er.response.data.errors.price : [''],
                        percentage_of_sale: er.response.data.errors.percentage_of_sale ? er.response.data.errors.percentage_of_sale : [''],
                    }
                }
                console.log(er)
            })
        },
        deleteFun() {
            axios.get(route('product.delete', {product: this.editData.id})).then(r => {
                this.showData = this.showData.filter(v => v.id !== this.editData.id)
                this.showForm.update = false;
                this.editData = {
                    name: '',
                    price: '',
                    quality_id: '',
                    car_id: '',
                    image: '',
                    percentage_of_sale: '',
                }
                this.editDataError = {
                    name: [''],
                    price: [''],
                    quality_id: [''],
                    car_id: [''],
                    image: [''],
                    percentage_of_sale: [''],
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
        setTo(e) {
            this.image = URL.createObjectURL(e.target.files[0])
            this.editData.file = e.target.files[0]
            this.addData.file = e.target.files[0]
        }
    }
}
</script>
