<template>
    <div class="min-h-screen flex bg-bg">
        <!-- Sidebar -->
        <aside
            class="hidden lg:flex lg:flex-col w-64 bg-slate-900 text-white p-6"
        >
            <div class="mb-6">
                <div class="text-xl font-semibold">Admin</div>
            </div>
            <nav class="space-y-1">
                <a
                    class="flex items-center gap-3 px-3 py-2 rounded-md bg-slate-800"
                >
                    <span>Products</span>
                </a>
                <form method="POST" action="/logout">
                    <button
                        type="submit"
                        class="w-full text-left flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800"
                    >
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main -->
        <main class="flex-1 p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold">Admin — Products</h1>
                <inertia-link
                    href="/admin/products/create"
                    class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md"
                    >Add Product</inertia-link
                >
            </div>

            <div class="bg-white rounded-lg shadow-soft overflow-hidden">
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-sm text-gray-500">
                                <tr>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Category</th>
                                    <th class="px-4 py-3">Price</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-700">
                                <tr
                                    class="border-t"
                                    v-for="row in products.data"
                                    :key="row.id"
                                >
                                    <td class="px-4 py-3">{{ row.name }}</td>
                                    <td class="px-4 py-3">
                                        {{ row.category?.name }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ formatPrice(row.price) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <inertia-link
                                            :href="`/admin/products/${row.id}/edit`"
                                            class="inline-flex items-center px-3 py-1.5 bg-emerald-500 text-white rounded-md mr-2"
                                            >Edit</inertia-link
                                        >
                                        <button
                                            @click="confirmDelete(row.id)"
                                            class="inline-flex items-center px-3 py-1.5 bg-rose-500 text-white rounded-md"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { ElMessage, ElMessageBox } from "element-plus";

const products = ref({ data: [] });

const fetch = async () => {
    const res = await axios.get("/api/products?per_page=50");
    products.value = res.data;
};

const confirmDelete = async (id) => {
    try {
        await ElMessageBox.confirm(
            "Это действие нельзя будет отменить. Продолжить?",
            "Удалить товар?",
            {
                confirmButtonText: "Удалить",
                cancelButtonText: "Отмена",
                type: "warning",
                confirmButtonClass: "el-button--danger",
            },
        );

        await axios.delete(`/api/products/${id}`);
        fetch();
        ElMessage({ type: "success", message: "Товар удалён" });
    } catch (e) {
        // Пользователь отменил или произошла ошибка
        if (e !== "cancel") {
            ElMessage({ type: "error", message: "Ошибка при удалении" });
        }
    }
};

const formatPrice = (p) =>
    p == null ? "" : `${Number(p).toLocaleString("ru-RU")} ₽`;

onMounted(fetch);
</script>
