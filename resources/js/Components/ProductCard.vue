<template>
    <article
        class="bg-white rounded-lg shadow-soft overflow-hidden hover:shadow-lg transition-shadow duration-200 flex flex-col h-full"
    >
        <inertia-link :href="`/product/${product.id}`" class="block">
            <div class="bg-gray-50 h-48 flex items-center justify-center">
                <img
                    :src="product.image || '/images/placeholder.png'"
                    alt=""
                    class="object-contain w-full h-full p-2"
                />
            </div>
        </inertia-link>
        <div class="p-4 flex flex-col flex-1">
            <div class="flex items-start justify-between gap-2 mb-2">
                <inertia-link :href="`/product/${product.id}`" class="flex-1">
                    <h3
                        class="text-sm font-medium text-gray-900 hover:text-primary transition line-clamp-2"
                    >
                        {{ product.name }}
                    </h3>
                </inertia-link>
                <span
                    class="text-xs font-semibold text-primary bg-primary/10 px-2 py-1 rounded-full whitespace-nowrap"
                    >{{ product.category?.name || "—" }}</span
                >
            </div>
            <p class="text-sm text-gray-500 line-clamp-2 mb-3">
                {{ product.description }}
            </p>
            <div class="mt-auto space-y-2">
                <div class="text-xl font-bold text-primary">
                    {{ formatPrice(product.price) }}
                </div>
                <div class="flex gap-2">
                    <button
                        @click.prevent="$emit('add-to-cart', product)"
                        class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 bg-primary text-white rounded-md text-sm hover:bg-primary/90 transition"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                        В корзину
                    </button>
                    <inertia-link
                        :href="`/product/${product.id}`"
                        class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-900 rounded-md text-sm hover:bg-gray-200 transition"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                            />
                        </svg>
                    </inertia-link>
                </div>
            </div>
        </div>
    </article>
</template>

<script setup>
import { computed } from "vue";
const props = defineProps({ product: Object });
const formatPrice = (p) => {
    if (p === null || p === undefined) return "";
    return `${Number(p).toLocaleString("ru-RU")} ₽`;
};
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
