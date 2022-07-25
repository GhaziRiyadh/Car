<template>
    <div class=" h-[80vh] w-full overflow-auto shadow-xl sm:rounded-lg px-6">

        <!-- top -->
        <div v-if="!['APP_INFO'].includes(isType.type)" class="w-full border-b-2 py-4 mt-2">
            <div class="flex w-full items-center justify-between text-sm">
                <div></div>
                <div class="flex items-center justify-around text-sm">
                    <div class="flex items-center mx-1">
                        <JetInput v-model="searchData" type="text" class="text-sm" :placeholder="`${isType.title}`" />
                    </div>
                    <SecondaryButton class="mx-1" @click="getRecords(searchData, type)">بحث</SecondaryButton>
                    <PrimaryButton v-show="!['APP_MANAGEMENT', 'APP_USERS'].includes(isType.type)"
                        @click="showForm.add = true" class="mx-1">
                        اضافة</PrimaryButton>
                </div>
            </div>
        </div>

        <app_users v-if="['APP_MANAGEMENT', 'APP_USERS'].includes(isType.type)" :get-data="showData.data"
            :roles="showData.roles" :type="isType.type" :add-form="showForm.add" />

        <app_info v-if="isType.type === 'APP_INFO'" :getData="showData.data" :updateForm="showForm.update"
            @closeModel="showForm.update = false; showForm.add = false" />
    </div>
</template>

<script>
import PrimaryButton from '../../Jetstream/PrimaryButton.vue'
import SecondaryButton from '../../Jetstream/SecondaryButton.vue'
import JetInput from '../../Jetstream/Input.vue'
import App_info from "../components/app/app_info";
import App_users from "../components/app/app_users";

export default {
    components: {
        App_users,
        App_info,
        PrimaryButton,
        SecondaryButton,
        JetInput,
    },
    created() {

    },
    props: {
        getData: {},
        type: {},
        getRecords: () => {
        }
    },
    data() {
        return {
            searchData: '',
            showData: this.getData,
            showForm: {
                add: false,
                update: false
            },
            isType: this.type,
            editData: {},
        }
    },
    watch: {
        type: function (nv, ov) {
            this.isType = nv
        },
        getData: function (nv, ov) {
            this.showData = nv
        },
    },
}
</script>

<style>
</style>
