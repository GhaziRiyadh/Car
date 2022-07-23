<template>
    <!-- tables -->
    <div class="w-full h-[70vh]">
        <div class="flex items-center h-10 text-sm text-center border-b border-secondary my-2">
            <span v-for="(value,key) in showData[0]" :key="key" v-text="key" class="mx-auto w-1/5 text-primary"></span>
        </div>
        <div class="h-4/5 overflow-auto snap-y scroll-smooth span-center bg-gray-50 p-1">
            <div
                class="flex bg-white min-h-[6vh] rounded-lg items-center text-center text-sm shadow-lg my-2 hover:bg-primary hover:text-white cursor-pointer"
                v-for="(item, index) in showData" :key="index">
                <span v-for="(value,key) in item" :key="key" v-text="key === 'id'?'#'+value:value"
                      :class="`mx-auto w-1/5 `"></span>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "report",
    props: {
        getData: []
    },
    data() {
        return {
            showData: this.getData
        };
    },
    watch: {
        getData: function(nv, ov) {
            this.showData = nv
        }
    }
}
</script>

<style scoped>

</style>
