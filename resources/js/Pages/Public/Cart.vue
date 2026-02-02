<template>
    <div class="min-h-screen flex flex-col bg-bg">
        <AppHeader :cartCount="cartCount" />

        <main class="flex-1 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold mb-6">Корзина</h1>

                <div v-if="cart.length === 0" class="text-center py-12">
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
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                        />
                    </svg>
                    <p class="mt-4 text-gray-500">Корзина пуста</p>
                    <inertia-link
                        href="/"
                        class="mt-4 inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition"
                    >
                        Перейти к покупкам
                    </inertia-link>
                </div>

                <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Список товаров -->
                    <div class="lg:col-span-2 space-y-4">
                        <div
                            v-for="item in cart"
                            :key="item.id"
                            class="bg-white rounded-lg shadow-sm p-4 flex gap-4"
                        >
                            <img
                                :src="item.image"
                                :alt="item.name"
                                class="w-24 h-24 object-contain rounded bg-gray-50"
                            />
                            <div class="flex-1">
                                <h3 class="font-semibold">{{ item.name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ item.category?.name }}
                                </p>
                                <div class="mt-2 flex items-center gap-3">
                                    <button
                                        @click="decreaseQuantity(item)"
                                        class="w-8 h-8 rounded border hover:bg-gray-50"
                                    >
                                        −
                                    </button>
                                    <span class="font-medium">{{
                                        item.quantity
                                    }}</span>
                                    <button
                                        @click="increaseQuantity(item)"
                                        class="w-8 h-8 rounded border hover:bg-gray-50"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-primary">
                                    {{
                                        formatPrice(item.price * item.quantity)
                                    }}
                                </div>
                                <button
                                    @click="removeItem(item)"
                                    class="mt-2 text-red-600 text-sm hover:text-red-700"
                                >
                                    Удалить
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Итого -->
                    <div class="lg:col-span-1">
                        <div
                            class="bg-white rounded-lg shadow-sm p-6 sticky top-4"
                        >
                            <h3 class="text-xl font-bold mb-4">Итого</h3>
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600"
                                        >Товары ({{ totalItems }})</span
                                    >
                                    <span>{{ formatPrice(totalPrice) }}</span>
                                </div>
                                <div
                                    class="flex justify-between font-bold text-lg pt-2 border-t"
                                >
                                    <span>Итого:</span>
                                    <span class="text-primary">{{
                                        formatPrice(totalPrice)
                                    }}</span>
                                </div>
                            </div>
                            <button
                                class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary/90 transition"
                            >
                                Оформить заказ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <AppFooter />
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import AppHeader from "../../Components/AppHeader.vue";
import AppFooter from "../../Components/AppFooter.vue";
import { ElNotification } from "element-plus";

const cart = ref([]);
const cartCount = ref(0);

const formatPrice = (p) =>
    p == null ? "" : `${Number(p).toLocaleString("ru-RU")} ₽`;

const totalItems = computed(() =>
    cart.value.reduce((sum, item) => sum + item.quantity, 0),
);
const totalPrice = computed(() =>
    cart.value.reduce((sum, item) => sum + item.price * item.quantity, 0),
);

const loadCart = () => {
    cart.value = JSON.parse(localStorage.getItem("cart") || "[]");
    cartCount.value = cart.value.reduce((sum, item) => sum + item.quantity, 0);
};

const saveCart = () => {
    localStorage.setItem("cart", JSON.stringify(cart.value));
    cartCount.value = cart.value.reduce((sum, item) => sum + item.quantity, 0);
};

const increaseQuantity = (item) => {
    item.quantity++;
    saveCart();
};

const decreaseQuantity = (item) => {
    if (item.quantity > 1) {
        item.quantity--;
        saveCart();
    }
};

const removeItem = (item) => {
    cart.value = cart.value.filter((i) => i.id !== item.id);
    saveCart();
    ElNotification({
        title: "Удалено",
        message: `${item.name} удалён из корзины`,
        type: "info",
        duration: 2000,
    });
};

onMounted(() => {
    loadCart();
});
</script>
