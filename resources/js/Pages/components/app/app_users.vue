<template>
    <div>
        <div class="w-full h-10 flex items-center justify-start my-1">
            <div v-for="item in count" :key="item.name"
                 class="flex items-center justify-around border rounded-lg mx-1 cursor-pointer"
                 :class="isUser === item.name ? 'bg-primary text-gray-50' : 'hover:bg-primary hover:text-gray-50 text-gray-900' "
                 @click="isUser = item.name;getUsers()"
            >
                <span class="p-1 flex items-center text-xs justify-center text-center">{{ item.name }}</span>
                <span class="h-8 w-8 text-xs m-1 rounded-full flex items-center justify-center bg-white"
                      :class="isUser === item.name ? ' text-primary' : ' text-gray-900'"
                >
                    {{ item.count }}
                </span>
            </div>
        </div>
        <!-- tables -->
        <div class="w-full h-[60vh]">
            <div class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
                <div
                    class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-sm shadow-lg my-2 hover:bg-secondary hover:text-white cursor-pointer"
                    v-for="(item, index) in showData" :key="index" >
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto ">#{{ item.id }}</span>
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto ">الاسم : {{ item.name }}</span>
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto ">الايميل: {{ item.name }}</span>
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto ">التلفون: {{ item.name }}</span>
                    <span class="mx-auto w-1/6 whitespace-nowrap overflow-auto ">
                        <span v-show="item.blocked" class="py-1 px-2 border-primary text-primary hover:bg-primary hover:text-white file:hover:shadow-lg">الغاء الحظر</span>
                        <span v-show="!item.blocked" class="py-1 px-2 border-primary text-primary hover:bg-primary hover:text-white file:hover:shadow-lg">حظر</span>
                    </span>
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
            isUser: '',
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
        this.getStatusAppUsersCount()
    },
    methods: {
        getStatusAppUsersCount() {
            axios.get(route('appUsers.appUsersStatusCount')).then(res => {
                this.count = res.data
            })
        },
        changeStatus(id, status) {
            axios.get(route('appUsers.appUsersChangeStatus', {user: id, status: status})).then(res => {
                this.showData = res.data
                this.getStatusAppUsersCount()
            })
        },
        getUsers() {
            axios.get(route('appUsers.getUsers', {type: this.isUser})).then(r => this.showData = r.data).catch(er => console.log(er))
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
