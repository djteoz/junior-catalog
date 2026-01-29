<template>
    <div class="p-6">
        <h1 class="text-2xl">{{ product.name }}</h1>
        <div>{{ product.category?.name }} — {{ product.price }}</div>
        <p class="mt-4">{{ product.description }}</p>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { usePage } from "@inertiajs/inertia-vue3";

const page = usePage();
const id = page.props.value.props?.id || page.props.value.id;
const product = ref({});

onMounted(async () => {
    const res = await axios.get(`/api/products/${id}`);
    product.value = res.data.data;
});
</script>
