<template>
    <app-layout :title="isType">
        <template #header>
            <h2 class="font-semibold text-xl text-primary leading-tight">
                {{ isType }}
            </h2>
        </template>
        <div class="bg-white h-[80vh] min-w-[80vw] overflow-auto shadow-xl sm:rounded-lg px-6">
            <!-- top -->
            <div class="w-full border-b-2 h-1/5 mt-2">
                <div v-if="isType !== 'معلومات التطبيق'" class="flex w-full items-center justify-between text-sm">
                    <div class="flex items-center justify-center">
                        <div class="flex items-center mx-1">
                            <JetInput v-model="searchData" type="text" class="text-sm" :placeholder="`${isType}`" />
                        </div>
                        <secondary-button class="mx-1" @click="getRecords">بحث</secondary-button>
                    </div>
                </div>
                <div class="flex items-center text-sm mt-2 w-full">
                    <div v-for="item in type" @click="active(item.title)" :key="item"
                        :class="`mx-2 border-t border-r border-l text-sm rounded-t-md cursor-pointer px-4 py-1 ${item.title == isType ? 'bg-secondary text-white' : ''}`">
                        {{ item.title }}
                    </div>
                </div>
            </div>

            <report :getData="showData.data" />
        </div>

    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import SecondaryButton from "../../Jetstream/SecondaryButton";
import PrimaryButton from "../../Jetstream/PrimaryButton";
import Report from "../components/reports/report";
import JetInput from "../../Jetstream/Input";

export default {
    name: "reports",
    components: { Report, PrimaryButton, SecondaryButton, AppLayout, JetInput },
    props: {
        getData: [],
    },
    mounted() {
        this.isType = this.type[0].title
    },
    data() {
        return {
            type: [
                { title: 'الدعم النفسي', url: 'psychology_aids.' },
                { title: 'اصدقاء مرضى السرطان', url: 'patient_friends.' },
            ],
            isType: '',
            searchData: '',
            showData: {},
        };
    },
    created() {
        this.showData['data'] = this.getData
    },
    methods: {
        getRecords() {
            axios.post(route('reports.getRecords'), {
                name: this.searchData,
                type: this.isType
            }).then(r => {
                this.showData = r.data
                console.log(r.data)
            }).catch(er => {

            })
        },
        active(title) {
            this.isType = title
            this.getRecords()
        },
    },
}
</script>

<style scoped>
</style>
