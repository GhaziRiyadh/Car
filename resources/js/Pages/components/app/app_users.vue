<template>
    <div>
        <div class="w-full h-[70vh]">
            <div class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-xs shadow-lg my-2 cursor-pointer"
                    v-for="(item, index) in showData" :key="index">
                    <span class="mx-auto w-1/6 whitespace-nowrap ">#{{ item.id }}</span>
                    <span class="mx-auto w-2/6 whitespace-nowrap ">الاسم : {{ item.name }}</span>
                    <span class="mx-auto w-2/6 whitespace-nowrap ">الايميل: {{ item.email }}</span>
                    <span class="mx-auto w-2/6 whitespace-nowrap ">التلفون: {{ item.phone }}</span>
                    <!-- <span @click="changeStatus(item.id, !item.blocked)" class="mx-auto w-1/6 whitespace-nowrap ">
                        <div v-if="status" class="flex items-center justify-center">
                            <div
                                class=" animate-spin border-2 border-green-100 border-r-red-600 mx-1 rounded-full h-8 w-8">
                            </div>
                        </div>
                        <span v-show="item.blocked && !status"
                            class="py-1 px-2 border-primary rounded-lg text-primary hover:bg-primary hover:text-white hover:shadow-lg">الغاء
                            الحظر
                        </span>
                        <span v-show="!item.blocked && !status"
                            class="py-1 px-2 border-primary rounded-lg text-primary hover:bg-primary hover:text-white hover:shadow-lg">
                            حظر
                        </span>
                    </span> -->
                </div>
            </div>
        </div>

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
            status: false,
            showData: this.getData,
            showRoles: this.roles,
            checkRole: [],
            isType: this.type,
            showReason: false,
            student: [{}],
            checkStudent: [],
            count: {},
            isUser: 'زبون',
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
        // this.getStatusAppUsersCount()
    },
    methods: {
        getStatusAppUsersCount() {
            axios.get(route('appUsers.appUsersStatusCount')).then(res => {
                this.count = res.data
            })
        },
        changeStatus(id, status) {
            this.status = true
            axios.get(route('appUsers.appUsersChangeStatus', { user: id, status: status })).then(res => {
                this.showData = res.data
                // this.getStatusAppUsersCount()
                this.getUsers()
                this.status = false
            })
        },
        getUsers() {
            axios.get(route('appUsers.getUsers', { type: this.isUser })).then(r => this.showData = r.data).catch(er => console.log(er))
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
