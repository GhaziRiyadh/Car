<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    status: {
        type: Boolean,
        default: false
    }
});
</script>

<template>

    <button :disabled="status" :type="type"
        class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">
        <div v-if="status" class="flex items-center justify-center">
            <div class=" animate-spin border-2 border-green-100 border-r-red-600 mx-1 rounded-full h-8 w-8"></div>
        </div>
        <slot v-else />
    </button>

</template>
