<template>
    <div>
        <!-- tables -->
        <div class="w-full h-full">
            <div class="h-full overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-xs shadow-lg my-2 hover:bg-primary hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <span class="mx-auto w-1/6 whitespace-nowrap ">#{{ item.id }}</span>
                    <span class="mx-auto w-1/6 whitespace-nowrap flex items-center ">
                        <span>الاسم:</span>
                        <span>{{ item.name }}</span>
                    </span>
                    <span class="mx-auto w-1/6 whitespace-nowrap flex items-center ">
                        <span>السعر:</span>
                        <span>{{ item.price }}</span>
                    </span>
                    <span class="mx-auto w-2/6 whitespace-nowrap flex items-center ">
                        <span>السيارة:</span>
                        <span>{{ item.car }}</span>
                    </span>
                    <span class="mx-auto w-1/6 whitespace-nowrap flex items-center ">
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
                <div class=" grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الاسم" />

                        <JetInput v-model="addData.name" type="text" class="mt-1 block w-full" placeholder="الاسم" />

                        <JetInputError :message="addDataError.name[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="السعر" />

                        <JetInput v-model="addData.price" type="text" class="mt-1 block w-full" placeholder="السعر" />

                        <JetInputError :message="addDataError.price[0]" class="mt-2" />
                    </div>

                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="السيارة" />

                        <select v-model="addData.car_id"
                            class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm" v-for="(item, index) in showRoles.car"
                                :key="index" :value="item.id" v-text="item.name"></option>
                        </select>

                        <JetInputError :message="addDataError.car_id[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الجودة" />

                        <select v-model="addData.quality_id"
                            class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm"
                                v-for="(item, index) in showRoles.quality" :key="index" :value="item.id"
                                v-text="item.name"></option>
                        </select>

                        <JetInputError :message="addDataError.quality_id[0]" class="mt-2" />
                    </div>

                </div>
                <div dir="rtl" class="w-full">
                    <JetLabel class="mb-2" value="رقم القطعة" />

                    <JetInput v-model="addData.piece_number" type="text" class="mt-1 block w-full"
                        placeholder="رقم القطعة" />

                    <JetInputError :message="addDataError.piece_number[0]" class="mt-2" />
                </div>
                <div dir="rtl" class="w-full">
                    <JetLabel class="mb-2" value="الصورة" />


                    <label
                        class=" text-sm leading-5 font-medium text-gray-700 flex h-64 bg-gray-300 rounded-lg items-center justify-center">
                        <input type="file" @change="setTo" class="hidden" />
                        <img v-if="image" :src="image" class="w-full h-64 rounded-lg" alt="" srcset="">
                        <span v-else class="ml-2">اضغط لتغيير الصورة</span>
                    </label>


                    <JetInputError :message="addDataError.image[0]" class="mt-2" />
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
                <div class=" grid grid-cols-2 gap-4 my-2">
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الاسم" />

                        <JetInput v-model="editData.name" type="text" class="mt-1 block w-full" placeholder="الاسم" />

                        <JetInputError :message="editDataError.name[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="السعر" />

                        <JetInput v-model="editData.price" type="text" class="mt-1 block w-full" placeholder="السعر" />

                        <JetInputError :message="editDataError.price[0]" class="mt-2" />
                    </div>

                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="السيارة" />

                        <select v-model="editData.car_id"
                            class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm" v-for="(item, index) in showRoles.car"
                                :key="index" :value="item.id" v-text="item.name"></option>
                        </select>

                        <JetInputError :message="editDataError.car_id[0]" class="mt-2" />
                    </div>
                    <div dir="rtl" class="w-full">
                        <JetLabel class="mb-2" value="الجودة" />

                        <select v-model="editData.quality_id"
                            class="border-secondary focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm w-full">
                            <option class="border-secondary rounded-md shadow-sm"
                                v-for="(item, index) in showRoles.quality" :key="index" :value="item.id"
                                v-text="item.name"></option>
                        </select>

                        <JetInputError :message="editDataError.quality_id[0]" class="mt-2" />
                    </div>

                </div>
                <div dir="rtl" class="w-full">
                    <JetLabel class="mb-2" value="رقم القطعة" />

                    <JetInput v-model="editData.piece_number" type="text" class="mt-1 block w-full"
                        placeholder="رقم القطعة" />

                    <JetInputError :message="editDataError.piece_number[0]" class="mt-2" />
                </div>
                <div dir="rtl" class="w-full">
                    <JetLabel class="mb-2" value="الصورة" />


                    <label
                        class=" text-sm leading-5 font-medium text-gray-700 flex h-64 bg-gray-300 rounded-lg items-center justify-center">
                        <input type="file" @change="setTo" class="hidden" />
                        <img v-if="image" :src="image" class="w-full rounded-lg h-64" alt="" srcset="">
                        <span v-else class="ml-2">اضغط لتغيير الصورة</span>
                    </label>


                    <JetInputError :message="addDataError.image[0]" class="mt-2" />
                </div>
            </template>
            <!-- model-content -->
            <template #model-footer>
                <div dir="rtl" class="w-full flex items-center justify-between">
                    <div>
                        <JetPrimaryButton @click="update(); image = ''" class="mx-5">
                            حفظ
                        </JetPrimaryButton>
                        <JetDangButton @click="deleteFun(); image = ''" class="mx-5">
                            حذف
                        </JetDangButton>
                    </div>
                    <JetSecondaryButton @click="showForm.update = false; image = ''">
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
    created() {
        console.log('products')
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
                piece_number: [''],
            },
            editData: {
                name: '',
                price: '',
                quality_id: '',
                car_id: '',
                image: '',
                piece_number: '',
            },
            addData: {
                name: '',
                price: '',
                quality_id: '',
                car_id: '',
                image: '',
                piece_number: '',
            },
            addDataError: {
                name: [''],
                price: [''],
                quality_id: [''],
                car_id: [''],
                image: [''],
                piece_number: [''],
            },
            showData: this.getData,
            showRoles: this.roles,
            isType: this.type,
            image: '',
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
            form.append('car_id', this.addData.car_id)
            form.append('piece_number', this.addData.piece_number)
            form.append('quality_id', this.addData.quality_id)
            axios.post(route('product.store'), form)
                .then(r => {
                    this.showForm.add = false;

                    this.showData.push(r.data[0])
                    console.log('data', r)
                    this.$emit('closeModel')
                    this.image = ''
                    this.addData = {
                        name: '',
                        price: '',
                        quality_id: '',
                        car_id: '',
                        image: '',
                        piece_number: '',
                    }
                    this.addDataError = {
                        name: [''],
                        price: [''],
                        quality_id: [''],
                        car_id: [''],
                        image: [''],
                        piece_number: [''],
                    }

                    this.$notify({
                        title: 'تم',
                        text: 'كل شيئ على مايرام',
                        type: 'success',
                    })
                    this.showForm.add = false;

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
                            car_id: er.response.data.errors.car_id ? er.response.data.errors.car_id : [''],
                            price: er.response.data.errors.price ? er.response.data.errors.price : [''],
                            quality_id: er.response.data.errors.quality_id ? er.response.data.errors.quality_id : [''],
                            piece_number: er.response.data.errors.piece_number ? er.response.data.errors.piece_number : [''],

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
                        price: item.price,
                        car_id: this.roles.car.find(val => val.name === item.car)?.id,
                        quality_id: this.roles.quality.find(val => val.name === item.quality)?.id,
                        piece_number: item.piece_number,
                    }
                    this.image = '/' + item.image
                    break;
                }
            }
            this.showForm.update = true
        },
        update() {
            let form = new FormData()
            form.append('name', this.editData.name)
            form.append('image', this.editData.image)
            form.append('price', this.editData.price)
            form.append('piece_number', this.editData.piece_number)
            form.append('car_id', this.editData.car_id)
            form.append('quality_id', this.editData.quality_id)
            axios.post(route('product.update', { product: this.editData.id }), form).then(r => {
                console.log(r)
                this.showData = this.showData.map(v => {
                    if (v.id === this.editData.id) v = r.data[0]
                    return v
                })
                this.showForm.update = false;
                this.image = ''
                this.editData = {
                    name: '',
                    price: '',
                    quality_id: '',
                    car_id: '',
                    image: '',
                    piece_number: '',
                }
                this.editDataError = {
                    name: [''],
                    price: [''],
                    quality_id: [''],
                    car_id: [''],
                    image: [''],
                    piece_number: [''],
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
                        piece_number: er.response.data.errors.piece_number ? er.response.data.errors.piece_number : [''],
                    }
                }
                console.log(er)
            })
        },
        deleteFun() {
            axios.get(route('product.delete', { product: this.editData.id })).then(r => {
                this.showData = this.showData.filter(v => v.id !== this.editData.id)
                this.showForm.update = false;
                this.editData = {
                    name: '',
                    price: '',
                    quality_id: '',
                    car_id: '',
                    image: '',
                    piece_number: '',
                }
                this.editDataError = {
                    name: [''],
                    price: [''],
                    quality_id: [''],
                    car_id: [''],
                    image: [''],
                    piece_number: [''],
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
            this.editData.image = e.target.files[0]
            this.addData.image = e.target.files[0]
        },
    },
}
</script>
