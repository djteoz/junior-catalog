<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="w-full max-w-md bg-white p-6 rounded shadow">
            <h1 class="text-xl font-semibold mb-4">Login</h1>
            <el-form @submit.prevent.native="login">
                <el-form-item label="Email">
                    <el-input v-model="form.email" type="email"></el-input>
                </el-form-item>
                <el-form-item label="Password">
                    <el-input
                        v-model="form.password"
                        type="password"
                    ></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="login">Login</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import axios from "axios";

const form = reactive({ email: "admin@example.com", password: "password" });

const login = async () => {
    const res = await axios.post("/api/login", form);
    localStorage.setItem("token", res.data.token);
    axios.defaults.headers.common["Authorization"] = `Bearer ${res.data.token}`;
    window.location = "/admin/products";
};
</script>
