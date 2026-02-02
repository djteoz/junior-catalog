<template>
    <div class="min-h-screen bg-bg py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <div class="bg-white rounded-lg shadow-soft p-6">
                <h2 class="text-xl font-semibold mb-4">
                    {{ isEdit ? "Edit" : "Create" }} Product
                </h2>
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="product-name" class="text-sm text-gray-600"
                            >Name</label
                        >
                        <input
                            id="product-name"
                            name="name"
                            v-model="form.name"
                            required
                            class="w-full rounded-md border px-3 py-2 mt-1"
                        />
                    </div>

                    <div>
                        <label
                            for="product-category"
                            class="text-sm text-gray-600"
                            >Category</label
                        >
                        <select
                            id="product-category"
                            name="category_id"
                            v-model="form.category_id"
                            class="w-full rounded-md border px-3 py-2 mt-1"
                        >
                            <option value="">Select category</option>
                            <option
                                v-for="c in categories"
                                :key="c.id"
                                :value="c.id"
                            >
                                {{ c.name }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="product-price" class="text-sm text-gray-600"
                            >Price</label
                        >
                        <input
                            id="product-price"
                            name="price"
                            type="number"
                            v-model.number="form.price"
                            class="w-full rounded-md border px-3 py-2 mt-1"
                        />
                    </div>

                    <div>
                        <label
                            for="product-description"
                            class="text-sm text-gray-600"
                            >Description</label
                        >
                        <textarea
                            id="product-description"
                            name="description"
                            v-model="form.description"
                            class="w-full rounded-md border px-3 py-2 mt-1 h-32"
                        ></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <inertia-link
                            href="/admin/products"
                            class="px-4 py-2 rounded-md border"
                            >Cancel</inertia-link
                        >
                        <button
                            type="submit"
                            class="px-4 py-2 bg-primary text-white rounded-md"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import axios from "axios";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

const page = usePage();
const isEdit = !!page.props.value.props?.id;
const categories = ref([]);
const form = reactive({
    name: "",
    description: "",
    price: 0,
    category_id: null,
});

onMounted(async () => {
    const c = await axios.get("/api/categories");
    categories.value = c.data;
    if (isEdit) {
        const id = page.props.value.props.id;
        const res = await axios.get(`/api/products/${id}`);
        Object.assign(form, res.data.data);
    }
});

const submit = async () => {
    if (isEdit) {
        const id = page.props.value.props.id;
        await axios.put(`/api/products/${id}`, form);
    } else {
        await axios.post("/api/products", form);
    }
    Inertia.visit("/admin/products");
};
</script>
