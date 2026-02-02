<template>
    <div
        v-if="meta && meta.last_page > 1"
        class="mt-6 flex items-center justify-center gap-2"
    >
        <button
            :disabled="meta.current_page === 1"
            @click="$emit('page', meta.current_page - 1)"
            class="px-3 py-1 rounded-md bg-white shadow border disabled:opacity-40 hover:bg-gray-50 transition"
        >
            ← Назад
        </button>
        <span class="px-3 py-1 rounded-md bg-white shadow"
            >Страница {{ meta.current_page }} из {{ meta.last_page }}</span
        >
        <button
            :disabled="meta.current_page === meta.last_page"
            @click="$emit('page', meta.current_page + 1)"
            class="px-3 py-1 rounded-md bg-white shadow disabled:opacity-40 hover:bg-gray-50 transition"
        >
            Вперед →
        </button>
    </div>
</template>

<script setup>
const props = defineProps({ meta: Object });
</script>
