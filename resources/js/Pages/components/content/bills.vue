<template>
    <div>
        <div class="w-full h-10 flex items-center whitespace-nowrap justify-start my-1">
            <div v-for="(item, key) in count" :key="item"
                class="flex items-center justify-around border rounded-lg mx-1 py-0.5 cursor-pointer"
                :class="isBill === key ? 'bg-primary text-gray-50' : 'hover:bg-primary hover:text-gray-50 text-gray-900'"
                @click="isBill = key; getBills()">
                <span class="px-1 flex items-center text-xs justify-center text-center">{{ key }}</span>
                <span class="h-6 w-6 text-xs mx-1 rounded-full flex items-center justify-center bg-white"
                    :class="isBill === key ? ' text-primary' : ' text-gray-900'">
                    {{ item }}
                </span>
            </div>
        </div>
        <!-- tables -->
        <div class="w-full h-full">
            <div class="h-full overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-xs shadow-lg my-2 hover:bg-secondary hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" @click="editForm(item.id)">
                    <span class="mx-auto w-1/6 whitespace-nowrap ">#{{ item.id }}</span>
                    <span class="mx-auto w-1/6 whitespace-nowrap flex items-center justify-around">
                        <span>المشتري:</span>
                        <span>{{ item.seller }}</span>
                    </span>
                    <span class="mx-auto w-1/6 whitespace-nowrap flex items-center justify-around">
                        <span>البائع:</span>
                        <span>{{ item.payer }}</span>
                    </span>
                    <span class="mx-auto w-1/6 whitespace-nowrap flex items-center justify-around">
                        <span>المجموع:</span>
                        <span>{{ item.total }}</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- edit from -->
        <MyForm :show="showForm.update">
            <template #model-title>
                <div dir="rtl" class="flex items-center ">
                    <h2 class="text-lg mx-au font-medium text-primary" v-text="editData.date"></h2>
                </div>
            </template>
            <!-- model-content -->
            <template #model-content>
                <div class="my-2 text-xs">
                    <div dir="rtl" class="w-full my-2 flex items-center justify-around">
                        <div class="border-secondary py-1 px-2 rounded-md flex items-center">
                            <span class="font-semibold">اسم المشتري:</span>
                            <span>{{ editData.seller }}</span>
                        </div>
                        <div class="border-secondary py-1 px-2 rounded-md flex items-center">
                            <span class="font-semibold">اسم البائع:</span>
                            <span>{{ editData.payer }}</span>
                        </div>
                    </div>
                    <div dir="rtl" class="w-full flex my-2 items-center justify-around">
                        <div class="border-secondary py-1 px-2 rounded-md flex items-center">
                            <span class="font-semibold">التاريخ:</span>
                            <span>{{ editData.date }}</span>
                        </div>
                        <div class="border-secondary py-1 px-2 rounded-md flex items-center">
                            <span class="font-semibold">الحالة:</span>
                            <span>{{ editData.status }}</span>
                        </div>
                    </div>
                    <div dir="rtl" class="w-full py-4 px-2 bg-gray-200 h-64 overflow-auto rounded-lg">
                        <div class="w-full my-2 rounded-lg p-2 bg-white shadow-lg flex"
                            v-for="item in editData.products" :key="item.id">
                            <span class="mx-auto w-1/6 whitespace-nowrap flex items-center justify-around">
                                <span>الاسم:</span>
                                <span>{{ item.name }}</span>
                            </span>
                            <span class="mx-auto w-1/6 whitespace-nowrap flex items-center justify-around">
                                <span>السعر:</span>
                                <span>{{ item.price }}</span>
                            </span>
                            <span class="mx-auto w-1/6 whitespace-nowrap flex items-center justify-around">
                                <span>رقم القطعة:</span>
                                <span>{{ item.piece_number }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="w-full py-4 px-2 flex">
                        <span>{{ editData.total }}</span>
                        <span>الاجمالي:</span>
                    </div>
                </div>
            </template>
            <template #model-footer>
                <div dir="rtl" class="w-full flex items-center justify-between">
                    <JetPrimaryButton v-show="showNextStatus" v-text="getNextStatus()"
                        @click="changeStatus(editData.id, getNextStatus())" class="mx-5">
                    </JetPrimaryButton>
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
            editData: {
                id: '',
                seller: '',
                payer: '',
                date: '',
                status: '',
                products: [],
                total: '',
                status_id: 0,
            },
            showData: this.getData,
            showRoles: this.roles,
            checkRole: [],
            isType: this.type,
            showReason: false,
            student: [{}],
            checkStudent: [],
            count: {},
            isBill: '',
            showNextStatus: false,
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
    created() {
        this.getStatusBillCount()
    },
    methods: {
        getStatusBillCount() {
            axios.get(route('bill.billStatusCount')).then(res => {
                this.count = res.data
            })
        },
        changeStatus(id, status) {
            axios.get(route('bill.billChangeStatus', { bill: id, state: status })).then(res => {
                this.showData = this.showData.map(v => {
                    if (v.id === res.data[0].id)
                        v = res.data[0]
                    return v
                })
                this.getStatusBillCount()
                this.getBills()
                this.showForm.update = false;
            })
        },
        getBills() {
            axios.get(route('bill.getBills', { status: this.isBill })).then(r => this.showData = r.data).catch(er => console.log(er))
        },
        getNextStatus() {
            this.showNextStatus = this.roles.status[this.roles.status.length - 1].id !== this.editData.status_id
            return this.showNextStatus ? this.roles.status.find(v => v.id === (this.editData.status_id + 1)).name : ''
        },
        editForm(id) {
            for (const item of this.showData) {
                if (item.id === id) {
                    this.editData = {
                        id: item.id,
                        seller: item.seller,
                        payer: item.payer,
                        date: item.date,
                        status: item.status,
                        products: item.products,
                        status_id: item.status_id,
                        total: item.total,
                    }
                    break;
                }
            }
            this.showForm.update = true
        },
    }
}
</script>
