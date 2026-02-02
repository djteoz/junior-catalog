<template>
    <div class="min-h-screen flex flex-col bg-bg">
        <AppHeader />

        <main class="flex-1 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold mb-6">Избранное</h1>

                <div v-if="favorites.length === 0" class="text-center py-12">
                    <svg
                        class="mx-auto h-16 w-16 text-gray-400"
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
                    <p class="mt-4 text-gray-500">Список избранного пуст</p>
                    <inertia-link
                        href="/"
                        class="mt-4 inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition"
                    >
                        Перейти к покупкам
                    </inertia-link>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
                >
                    <ProductCard
                        v-for="product in favorites"
                        :key="product.id"
                        :product="product"
                        @add-to-cart="addToCart(product)"
                        @remove-favorite="removeFavorite(product)"
                    />
                </div>
            </div>
        </main>

        <AppFooter />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import AppHeader from "../../Components/AppHeader.vue";
import AppFooter from "../../Components/AppFooter.vue";
import ProductCard from "../../Components/ProductCard.vue";
import { ElNotification } from "element-plus";

const favorites = ref([]);

const formatPrice = (p) =>
    p == null ? "" : `${Number(p).toLocaleString("ru-RU")} ₽`;

const loadFavorites = () => {
    favorites.value = JSON.parse(localStorage.getItem("favorites") || "[]");
};

const addToCart = (product) => {
    const cart = JSON.parse(localStorage.getItem("cart") || "[]");
    const existingItem = cart.find((item) => item.id === product.id);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ ...product, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    window.dispatchEvent(new Event("cart-updated"));

    ElNotification({
        title: "Добавлено в корзину",
        message: product.name,
        type: "success",
        duration: 2000,
    });
};

const removeFavorite = (product) => {
    favorites.value = favorites.value.filter((f) => f.id !== product.id);
    localStorage.setItem("favorites", JSON.stringify(favorites.value));
    window.dispatchEvent(new Event("favorites-updated"));

    ElNotification({
        title: "Удалено из избранного",
        message: product.name,
        type: "info",
        duration: 2000,
    });
};

onMounted(() => {
    loadFavorites();

    // Слушаем обновления избранного
    const handleFavoritesUpdate = () => {
        loadFavorites();
    };

    window.addEventListener("favorites-updated", handleFavoritesUpdate);

    return () => {
        window.removeEventListener("favorites-updated", handleFavoritesUpdate);
    };
});
</script>
