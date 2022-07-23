<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type"
        class="inline-flex items-center px-4 py-1 bg-white border border-secondary rounded-md font-semibold text-xs text-primary uppercase tracking-widest shadow-sm hover:text-secondary focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-primary active:bg-gray-50 disabled:opacity-25 transition">
        <slot />
    </button>
</template>
