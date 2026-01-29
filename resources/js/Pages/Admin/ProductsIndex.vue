<template>
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Admin — Products</h1>
            <inertia-link
                href="/admin/products/create"
                class="el-button el-button--primary"
                >Add Product</inertia-link
            >
        </div>

        <el-table :data="products.data" style="width: 100%">
            <el-table-column prop="name" label="Name"></el-table-column>
            <el-table-column prop="category.name" label="Category">
                <template #default="{ row }">{{ row.category?.name }}</template>
            </el-table-column>
            <el-table-column prop="price" label="Price"></el-table-column>
            <el-table-column label="Actions">
                <template #default="{ row }">
                    <inertia-link
                        :href="`/admin/products/${row.id}/edit`"
                        class="el-button el-button--success"
                        >Edit</inertia-link
                    >
                    <el-button
                        type="danger"
                        size="small"
                        @click="remove(row.id)"
                        >Delete</el-button
                    >
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { ElMessageBox, ElMessage } from "element-plus";

const products = ref({ data: [] });

const fetch = async () => {
    const res = await axios.get("/api/products?per_page=50");
    products.value = res.data;
};

const remove = async (id) => {
    try {
        await ElMessageBox.confirm(
            "Are you sure you want to delete this product?",
            "Confirm",
            {
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                type: "warning",
            },
        );

        await axios.delete(`/api/products/${id}`);
        ElMessage({ type: "success", message: "Product deleted" });
        fetch();
    } catch (e) {
        // cancelled or failed
    }
};

onMounted(fetch);
</script>
