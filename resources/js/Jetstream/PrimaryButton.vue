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
        class="inline-flex items-center justify-center px-4 py-1 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary focus:outline-none focus:border-primary focus:ring focus:ring-indigo-200 active:bg-primary disabled:opacity-25 transition">
        <slot />
    </button>
</template>
