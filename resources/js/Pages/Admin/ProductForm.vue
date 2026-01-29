<template>
    <div class="p-6">
        <h1>{{ isEdit ? "Edit" : "Create" }} Product</h1>
        <form @submit.prevent="submit">
            <el-form :model="form" label-width="120px">
                <el-form-item label="Name">
                    <el-input v-model="form.name" required></el-input>
                </el-form-item>

                <el-form-item label="Category">
                    <el-select
                        v-model="form.category_id"
                        placeholder="Select category"
                    >
                        <el-option
                            v-for="c in categories"
                            :key="c.id"
                            :label="c.name"
                            :value="c.id"
                        ></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="Price">
                    <el-input
                        v-model.number="form.price"
                        type="number"
                    ></el-input>
                </el-form-item>

                <el-form-item label="Description">
                    <el-input
                        type="textarea"
                        v-model="form.description"
                    ></el-input>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="submit">Save</el-button>
                    <inertia-link href="/admin/products" class="el-button"
                        >Cancel</inertia-link
                    >
                </el-form-item>
            </el-form>
        </form>
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
