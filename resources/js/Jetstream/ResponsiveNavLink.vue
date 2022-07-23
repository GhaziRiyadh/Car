<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? 'block pl-3 pr-4 py-2 border-l-4 border-secondary text-base font-medium text-primary bg-indigo-50 focus:outline-none focus:text-primary focus:bg-indigo-100 focus:border-primary transition'
        : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-primary hover:text-primary hover:bg-gray-50 hover:border-secondary focus:outline-none focus:text-primary focus:bg-gray-50 focus:border-secondary transition';
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" :class="classes" class="w-full text-left">
            <slot />
        </button>

        <Link v-else :href="href" :class="classes">
            <slot />
        </Link>
    </div>
</template>
