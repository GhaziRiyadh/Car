<template>
    <AppLayout :title="type.title" :get-records="setType">
        <template #header>
            <h2 class="font-semibold text-xl text-primary leading-tight">
                {{ type.title }}
            </h2>
        </template>

        <div class="relative bg-white w-[75vw] h-[80vh] overflow-auto shadow-xl sm:rounded-lg">
            <div v-if="showLoading"
                class="absolute w-full h-full top-0 right-0 left-0 flex items-center justify-center">
                <!-- <fold :loading="showLoading"></fold> -->
            </div>

            <!-- <Welcome v-if="type.type === 'DASHBOARD'"/> -->
            <div v-if="type.type === 'DASHBOARD'" class="w-full h-full flex items-center justify-center">
                <div>
                    <img src="/logo.jpg" class="w-32 " alt="logo" />
                    <h1 class="py-2 text-secondary text-3xl">Auto Experts</h1>
                </div>
            </div>

            <content v-if="['CONTENT', 'BILL', 'PRODUCT', 'CARS', 'COMPANY'].includes(type.type)"
                :get-records="getRecords" :get-data="mainData" :type="type" />

            <app_management v-if="['APP_INFO', 'APP_MANAGEMENT', 'APP_USERS'].includes(type.type)"
                :get-records="getRecords" :get-data="mainData" :type="type" />

            <users v-if="['USER', 'PERMISSION', 'ROLE', 'USERS'].includes(type.type)" :get-data="mainData.data"
                :roles="mainData.roles" :type="type" :get-records="getRecords" />
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '../Layouts/AppLayout.vue';
import Welcome from '../Jetstream/Welcome.vue';
import Users from "./Dashboard/users";
import Content from './Dashboard/content.vue';
import App_management from "./Dashboard/app_management";

export default {
    components: {
        App_management,
        Users,
        AppLayout,
        Welcome,
        Content,
    },
    data() {
        return {
            type: {},
            mainData: {},
            showLoading: false,
        };
    },
    created() {
    },
    methods: {
        async setType(v) {
            await this.getRecords('', v)
            this.type = v
        },
        getRecords(name, type) {
            this.showLoading = true
            axios.post(route('main.getRecords'), {
                name: name,
                type: type.type
            }).then(r => {
                this.mainData = r.data
                this.showLoading = false
                console.log('get', r.data)
            }).catch(er => {
                console.log(er)
            })

        }
    }
}

</script>
