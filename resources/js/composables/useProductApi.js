import axios from "axios";

export function useProductApi() {
    const fetchProducts = (params = {}) =>
        axios.get("/api/products", { params });
    const fetchProduct = (id) => axios.get(`/api/products/${id}`);
    const createProduct = (data) => axios.post("/api/products", data);
    const updateProduct = (id, data) => axios.put(`/api/products/${id}`, data);
    const deleteProduct = (id) => axios.delete(`/api/products/${id}`);

    return {
        fetchProducts,
        fetchProduct,
        createProduct,
        updateProduct,
        deleteProduct,
    };
}
