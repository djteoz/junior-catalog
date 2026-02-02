<template>
    <div class="min-h-screen flex flex-col bg-bg">
        <AppHeader />

        <main class="flex-1 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div v-if="loading" class="text-center py-12">
                    <div class="text-gray-500">Загрузка...</div>
                </div>

                <div v-else>
                    <!-- Хлебные крошки -->
                    <nav class="mb-6 text-sm text-gray-600">
                        <inertia-link href="/" class="hover:text-primary"
                            >Главная</inertia-link
                        >
                        <span class="mx-2">/</span>
                        <span>{{ product.category?.name }}</span>
                        <span class="mx-2">/</span>
                        <span class="text-gray-900">{{ product.name }}</span>
                    </nav>

                    <!-- Основная карточка товара -->
                    <div class="bg-white rounded-lg shadow-sm p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Изображение товара -->
                            <div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <img
                                        v-if="product.image && !imageError"
                                        :src="product.image"
                                        :alt="product.name"
                                        class="w-full h-[500px] object-contain"
                                        @error="imageError = true"
                                    />
                                    <div
                                        v-else
                                        class="w-full h-[500px] flex items-center justify-center bg-gray-100 rounded"
                                    >
                                        <div class="text-center">
                                            <svg
                                                class="mx-auto h-12 w-12 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                />
                                            </svg>
                                            <p
                                                class="mt-2 text-sm text-gray-500"
                                            >
                                                Изображение недоступно
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Информация о товаре -->
                            <div>
                                <h1
                                    class="text-3xl font-bold text-gray-900 mb-2"
                                >
                                    {{ product.name }}
                                </h1>

                                <div class="flex items-center gap-4 mb-6">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary/10 text-primary"
                                    >
                                        {{ product.category?.name }}
                                    </span>
                                    <span class="text-sm text-gray-500"
                                        >ID: {{ product.id }}</span
                                    >
                                </div>

                                <!-- Цена -->
                                <div class="mb-6 p-6 bg-gray-50 rounded-lg">
                                    <div
                                        class="text-4xl font-bold text-primary mb-2"
                                    >
                                        {{ formatPrice(product.price) }}
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        В наличии
                                    </p>
                                </div>

                                <!-- Кнопки действий -->
                                <div class="space-y-3 mb-8">
                                    <button
                                        @click="addToCart"
                                        class="w-full bg-primary text-white py-4 px-6 rounded-lg font-semibold hover:bg-primary/90 transition flex items-center justify-center gap-2"
                                    >
                                        <svg
                                            class="w-5 h-5"
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
                                        Добавить в корзину
                                    </button>
                                    <button
                                        @click="toggleFavorite"
                                        :class="[
                                            'w-full py-4 px-6 rounded-lg font-semibold transition flex items-center justify-center gap-2',
                                            isFavorite
                                                ? 'bg-red-500 text-white hover:bg-red-600'
                                                : 'bg-gray-100 text-gray-900 hover:bg-gray-200',
                                        ]"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            :fill="
                                                isFavorite
                                                    ? 'currentColor'
                                                    : 'none'
                                            "
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
                                        {{
                                            isFavorite
                                                ? "В избранном"
                                                : "В избранное"
                                        }}
                                    </button>
                                </div>

                                <!-- Характеристики -->
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-semibold mb-4">
                                        Характеристики
                                    </h3>
                                    <dl class="space-y-3">
                                        <div
                                            class="flex justify-between py-2 border-b"
                                        >
                                            <dt class="text-gray-600">
                                                Категория
                                            </dt>
                                            <dd class="font-medium">
                                                {{ product.category?.name }}
                                            </dd>
                                        </div>
                                        <div
                                            class="flex justify-between py-2 border-b"
                                        >
                                            <dt class="text-gray-600">
                                                Артикул
                                            </dt>
                                            <dd class="font-medium">
                                                {{ product.id }}
                                            </dd>
                                        </div>
                                        <div
                                            class="flex justify-between py-2 border-b"
                                        >
                                            <dt class="text-gray-600">
                                                Наличие
                                            </dt>
                                            <dd
                                                class="font-medium text-green-600"
                                            >
                                                В наличии
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Описание -->
                        <div class="mt-12 border-t pt-8">
                            <h2 class="text-2xl font-bold mb-4">Описание</h2>
                            <p class="text-gray-700 leading-relaxed text-lg">
                                {{ product.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Рекомендуемые товары -->
                    <div v-if="recommendedProducts.length > 0" class="mt-12">
                        <h2 class="text-2xl font-bold mb-6">Похожие товары</h2>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                        >
                            <ProductCard
                                v-for="p in recommendedProducts"
                                :key="p.id"
                                :product="p"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <AppFooter />
    </div>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import axios from "axios";
import { usePage } from "@inertiajs/inertia-vue3";
import AppHeader from "../../Components/AppHeader.vue";
import AppFooter from "../../Components/AppFooter.vue";
import ProductCard from "../../Components/ProductCard.vue";
import { ElNotification } from "element-plus";

const page = usePage();
const props = defineProps({
    id: {
        type: [String, Number],
        required: true,
    },
});

const product = ref({});
const recommendedProducts = ref([]);
const loading = ref(true);
const imageError = ref(false);
const isFavorite = ref(false);

const formatPrice = (p) =>
    p == null ? "" : `${Number(p).toLocaleString("ru-RU")} ₽`;

const addToCart = () => {
    const cart = JSON.parse(localStorage.getItem("cart") || "[]");
    const existingItem = cart.find((item) => item.id === product.value.id);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ ...product.value, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));

    // Триггерим событие для обновления счетчика в header
    window.dispatchEvent(new Event("cart-updated"));

    ElNotification({
        title: "Добавлено в корзину",
        message: `${product.value.name}`,
        type: "success",
        duration: 2000,
    });
};

const toggleFavorite = () => {
    const favorites = JSON.parse(localStorage.getItem("favorites") || "[]");
    const index = favorites.findIndex((f) => f.id === product.value.id);

    if (index > -1) {
        favorites.splice(index, 1);
        isFavorite.value = false;
        ElNotification({
            title: "Удалено из избранного",
            message: `${product.value.name}`,
            type: "info",
            duration: 2000,
        });
    } else {
        favorites.push(product.value);
        isFavorite.value = true;
        ElNotification({
            title: "Добавлено в избранное",
            message: `${product.value.name}`,
            type: "success",
            duration: 2000,
        });
    }

    localStorage.setItem("favorites", JSON.stringify(favorites));
    window.dispatchEvent(new Event("favorites-updated"));
};

const checkFavoriteStatus = () => {
    const favorites = JSON.parse(localStorage.getItem("favorites") || "[]");
    isFavorite.value = favorites.some((f) => f.id === product.value.id);
};

onMounted(async () => {
    console.log("Product ID:", props.id);

    try {
        // Загружаем данные товара
        const res = await axios.get(`/api/products/${props.id}`);
        console.log("Product data:", res.data);
        product.value = res.data.data;

        // Проверяем статус избранного
        checkFavoriteStatus();

        // Загружаем рекомендуемые товары из той же категории
        if (product.value.category?.id) {
            const recommended = await axios.get("/api/products", {
                params: {
                    category_id: product.value.category.id,
                    per_page: 4,
                },
            });
            // Исключаем текущий товар из рекомендаций
            recommendedProducts.value = recommended.data.data
                .filter((p) => p.id !== product.value.id)
                .slice(0, 4);
        }
    } catch (error) {
        console.error("Ошибка загрузки товара:", error);
        ElNotification({
            title: "Ошибка",
            message: "Не удалось загрузить товар",
            type: "error",
            duration: 3000,
        });
    } finally {
        loading.value = false;
    }
});
</script>
