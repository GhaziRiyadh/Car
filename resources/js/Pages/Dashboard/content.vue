<template>
    <div class="h-[80vh] w-full overflow-auto shadow-xl sm:rounded-lg px-6">

        <!-- top -->
        <div v-if="!['APP_INFO'].includes(isType.type)" class="w-full border-b-2 my-2 py-2">
            <div class="flex w-full items-center justify-between text-sm">
                <div></div>
                <div class="flex items-center justify-around text-sm">
                    <div class="flex items-center mx-1">
                        <JetInput v-model="searchData" type="text" class="text-sm" :placeholder="`${isType.title}`" />
                    </div>
                    <SecondaryButton class="mx-1" @click="getRecords(searchData, type)">بحث</SecondaryButton>
                    <PrimaryButton v-show="!['BILL'].includes(isType.type)" @click="showForm.add = true" class="mx-1">
                        اضافة
                    </PrimaryButton>
                </div>
            </div>
        </div>

        <Bills class="h-[60vh]" v-if="isType.type === 'BILL'" @closeModel="showForm.update = false; showForm.add = false"
            :get-data="showData.data" :roles="showData.roles" :type="isType.type" :add-form="showForm.add" />

        <company class="h-[68vh]" v-if="['COMPANY', 'CONTENT'].includes(isType.type)"
            @closeModel="showForm.update = false; showForm.add = false" :get-data="showData.data"
            :roles="showData.roles" :type="isType.type" :add-form="showForm.add" />

        <Cars class="h-[68vh]" v-if="isType.type === 'CARS'" @closeModel="showForm.update = false; showForm.add = false"
            :get-data="showData.data" :roles="showData.roles" :type="isType.type" :add-form="showForm.add" />

        <Product class="h-[68vh]" v-if="isType.type === 'PRODUCT'" :getData="showData.data" :addForm="showForm.add"
            :updateForm="showForm.update" :roles="showData.roles"
            @closeModel="showForm.update = false; showForm.add = false" />

    </div>
</template>

<script>
import PrimaryButton from '../../Jetstream/PrimaryButton.vue'
import SecondaryButton from '../../Jetstream/SecondaryButton.vue'
import JetInput from '../../Jetstream/Input.vue'
import Bills from "../components/content/bills";
import Cars from "../components/content/cars";
import Company from "../components/content/company";
import Product from '../components/content/product.vue';

export default {
    components: {
        Company,
        Cars,
        Bills,
        PrimaryButton,
        SecondaryButton,
        JetInput,
        Product
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
