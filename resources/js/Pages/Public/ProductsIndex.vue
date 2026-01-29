<template>
    <div class="p-6">
        <h1 class="text-2xl mb-4">Products</h1>
        <div class="mb-4">
            <select v-model="categoryId" @change="fetchProducts">
                <option :value="null">All categories</option>
                <option v-for="c in categories" :key="c.id" :value="c.id">
                    {{ c.name }}
                </option>
            </select>
        </div>

        <ul>
            <li
                v-for="product in products.data"
                :key="product.id"
                class="mb-4 border p-3"
            >
                <h2>{{ product.name }} — {{ product.price }}</h2>
                <div>{{ product.category?.name }}</div>
                <p>{{ product.description }}</p>
                <inertia-link :href="`/product/${product.id}`"
                    >View</inertia-link
                >
            </li>
        </ul>

        <div class="mt-4">
            <button
                :disabled="!products.prev_page_url"
                @click="loadPage(products.current_page - 1)"
            >
                Prev
            </button>
            <span>Page {{ products.current_page }}</span>
            <button
                :disabled="!products.next_page_url"
                @click="loadPage(products.current_page + 1)"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";

const products = ref({ data: [], current_page: 1 });
const categories = ref([]);
const categoryId = ref(null);

const fetchProducts = async (page = 1) => {
    const params = { page, per_page: 12 };
    if (categoryId.value) params.category_id = categoryId.value;
    const res = await axios.get("/api/products", { params });
    products.value = res.data;
};

const loadPage = (page) => fetchProducts(page);

onMounted(async () => {
    const c = await axios.get("/api/categories");
    categories.value = c.data;
    await fetchProducts();
});
</script>
