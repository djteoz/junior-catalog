<template>
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <inertia-link href="/" class="text-2xl font-bold text-primary">
                    Каталог товаров
                </inertia-link>
                <nav class="flex items-center gap-6">
                    <inertia-link
                        href="/"
                        class="text-gray-700 hover:text-primary transition"
                    >
                        Главная
                    </inertia-link>

                    <!-- Избранное -->
                    <inertia-link
                        href="/favorites"
                        class="relative text-gray-700 hover:text-primary transition"
                    >
                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                            />
                        </svg>
                        <span
                            v-if="localFavoritesCount > 0"
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold"
                        >
                            {{ localFavoritesCount }}
                        </span>
                    </inertia-link>

                    <!-- Корзина -->
                    <inertia-link
                        href="/cart"
                        class="relative text-gray-700 hover:text-primary transition"
                    >
                        <svg
                            class="w-6 h-6"
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
                        <span
                            v-if="localCartCount > 0"
                            class="absolute -top-2 -right-2 bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold"
                        >
                            {{ localCartCount }}
                        </span>
                    </inertia-link>

                    <inertia-link
                        href="/login"
                        class="px-4 py-2 rounded-md bg-primary text-white hover:bg-primary/90 transition"
                    >
                        Войти
                    </inertia-link>
                </nav>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const props = defineProps({
    cartCount: {
        type: Number,
        default: 0,
    },
});

const localCartCount = ref(props.cartCount);
const localFavoritesCount = ref(0);

const updateCartCount = () => {
    const cart = JSON.parse(localStorage.getItem("cart") || "[]");
    localCartCount.value = cart.reduce((sum, item) => sum + item.quantity, 0);
};

const updateFavoritesCount = () => {
    const favorites = JSON.parse(localStorage.getItem("favorites") || "[]");
    localFavoritesCount.value = favorites.length;
};

onMounted(() => {
    updateCartCount();
    updateFavoritesCount();
    window.addEventListener("cart-updated", updateCartCount);
    window.addEventListener("favorites-updated", updateFavoritesCount);
});

onUnmounted(() => {
    window.removeEventListener("cart-updated", updateCartCount);
    window.removeEventListener("favorites-updated", updateFavoritesCount);
});
</script>
