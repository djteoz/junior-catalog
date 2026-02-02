<template>
    <div class="min-h-screen flex flex-col bg-bg">
        <AppHeader :cartCount="cartCount" />

        <main class="flex-1 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Заголовок и фильтры -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold mb-6">Каталог товаров</h1>

                    <!-- Поиск и фильтры -->
                    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Поиск -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Поиск
                                </label>
                                <input
                                    v-model="searchQuery"
                                    @input="debouncedSearch"
                                    type="text"
                                    placeholder="Найти товар..."
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                                />
                            </div>

                            <!-- Категория -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Категория
                                </label>
                                <select
                                    v-model="categoryId"
                                    @change="resetAndFetch"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                                >
                                    <option :value="null">Все категории</option>
                                    <option
                                        v-for="c in categories"
                                        :key="c.id"
                                        :value="c.id"
                                    >
                                        {{ c.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Сортировка -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Сортировка
                                </label>
                                <select
                                    v-model="sortBy"
                                    @change="resetAndFetch"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                                >
                                    <option value="newest">Новинки</option>
                                    <option value="price_asc">
                                        Цена: по возрастанию
                                    </option>
                                    <option value="price_desc">
                                        Цена: по убыванию
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Диапазон цен -->
                        <div class="mt-4 pt-4 border-t">
                            <label
                                class="block text-sm font-medium text-gray-700 mb-3"
                            >
                                Цена: {{ formatPrice(priceRange[0]) }} —
                                {{ formatPrice(priceRange[1]) }}
                            </label>
                            <div class="flex items-center gap-4">
                                <input
                                    type="range"
                                    v-model.number="priceRange[0]"
                                    :min="0"
                                    :max="priceRange[1]"
                                    :step="1000"
                                    @change="resetAndFetch"
                                    class="flex-1"
                                />
                                <input
                                    type="range"
                                    v-model.number="priceRange[1]"
                                    :min="priceRange[0]"
                                    :max="200000"
                                    :step="1000"
                                    @change="resetAndFetch"
                                    class="flex-1"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Результаты -->
                    <div class="text-sm text-gray-600">
                        Найдено товаров: {{ products.meta?.total || 0 }}
                    </div>
                </div>

                <!-- Сетка товаров -->
                <div v-if="initialLoading" class="text-center py-12">
                    <div class="text-gray-500">Загрузка...</div>
                </div>

                <div
                    v-else-if="allProducts.length > 0"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
                >
                    <ProductCard
                        v-for="p in allProducts"
                        :key="p.id"
                        :product="p"
                        @add-to-cart="addToCart(p)"
                    />
                </div>

                <div v-else class="text-center py-12">
                    <p class="text-gray-500">Товары не найдены</p>
                </div>

                <!-- Индикатор загрузки следующей страницы -->
                <div
                    v-if="hasMore && !initialLoading"
                    ref="loadMoreTrigger"
                    class="text-center py-8"
                >
                    <div
                        v-if="loadingMore"
                        class="inline-flex items-center gap-2 text-primary"
                    >
                        <svg
                            class="animate-spin h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        <span>Загружаем ещё товары...</span>
                    </div>
                </div>

                <!-- Конец списка -->
                <div
                    v-if="!hasMore && allProducts.length > 0"
                    class="text-center py-8 text-gray-500"
                >
                    Все товары загружены
                </div>
            </div>
        </main>

        <AppFooter />
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from "vue";
import axios from "axios";
import ProductCard from "../../Components/ProductCard.vue";
import AppHeader from "../../Components/AppHeader.vue";
import AppFooter from "../../Components/AppFooter.vue";
import { ElNotification } from "element-plus";

const allProducts = ref([]);
const products = ref({ data: [], meta: {} });
const categories = ref([]);
const categoryId = ref(null);
const searchQuery = ref("");
const sortBy = ref("newest");
const priceRange = ref([0, 200000]);
const initialLoading = ref(false);
const loadingMore = ref(false);
const currentPage = ref(1);
const hasMore = ref(true);
const cartCount = ref(0);
const loadMoreTrigger = ref(null);
let observer = null;

let searchTimeout;

const formatPrice = (p) =>
    p == null ? "" : `${Number(p).toLocaleString("ru-RU")} ₽`;

const debouncedSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        resetAndFetch();
    }, 500);
};

const resetAndFetch = () => {
    allProducts.value = [];
    currentPage.value = 1;
    hasMore.value = true;
    fetchProducts();
};

const fetchProducts = async (isLoadMore = false) => {
    if (isLoadMore) {
        if (loadingMore.value || !hasMore.value) return;
        loadingMore.value = true;
    } else {
        if (initialLoading.value) return;
        initialLoading.value = true;
    }

    try {
        const params = { page: currentPage.value, per_page: 12 };

        if (categoryId.value) params.category_id = categoryId.value;
        if (searchQuery.value) params.search = searchQuery.value;
        if (priceRange.value[0] > 0) params.price_min = priceRange.value[0];
        if (priceRange.value[1] < 200000)
            params.price_max = priceRange.value[1];

        // Сортировка
        if (sortBy.value === "price_asc") {
            params.sort = "price";
            params.order = "asc";
        } else if (sortBy.value === "price_desc") {
            params.sort = "price";
            params.order = "desc";
        } else {
            params.sort = "id";
            params.order = "desc";
        }

        const res = await axios.get("/api/products", { params });
        products.value = res.data;

        if (isLoadMore) {
            // Добавляем товары к существующим
            allProducts.value = [...allProducts.value, ...res.data.data];
        } else {
            // Заменяем товары (первая загрузка или изменение фильтров)
            allProducts.value = res.data.data;
        }

        // Проверяем, есть ли ещё страницы
        hasMore.value = res.data.meta.current_page < res.data.meta.last_page;

        // Увеличиваем страницу только если есть ещё
        if (hasMore.value) {
            currentPage.value++;
        }
    } catch (error) {
        console.error("Ошибка загрузки товаров:", error);
    } finally {
        initialLoading.value = false;
        loadingMore.value = false;
    }
};

const setupIntersectionObserver = () => {
    observer = new IntersectionObserver(
        (entries) => {
            if (
                entries[0].isIntersecting &&
                hasMore.value &&
                !loadingMore.value
            ) {
                fetchProducts(true);
            }
        },
        {
            rootMargin: "200px",
        },
    );

    if (loadMoreTrigger.value) {
        observer.observe(loadMoreTrigger.value);
    }
};

onMounted(async () => {
    const c = await axios.get("/api/categories");
    categories.value = c.data;
    await fetchProducts();
    loadCartCount();

    await nextTick();
    setupIntersectionObserver();
});

onUnmounted(() => {
    if (observer) {
        observer.disconnect();
    }
});

const addToCart = (product) => {
    const cart = JSON.parse(localStorage.getItem("cart") || "[]");
    const existingItem = cart.find((item) => item.id === product.id);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ ...product, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    cartCount.value = cart.reduce((sum, item) => sum + item.quantity, 0);

    ElNotification({
        title: "Добавлено в корзину",
        message: `${product.name}`,
        type: "success",
        duration: 2000,
    });
};

const loadCartCount = () => {
    const cart = JSON.parse(localStorage.getItem("cart") || "[]");
    cartCount.value = cart.reduce((sum, item) => sum + item.quantity, 0);
};

onMounted(async () => {
    const c = await axios.get("/api/categories");
    categories.value = c.data;
    await fetchProducts();
    loadCartCount();
});
</script>
