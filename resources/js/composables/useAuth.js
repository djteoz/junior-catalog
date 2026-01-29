import axios from "axios";

export function useAuth() {
    const login = async (email, password) => {
        const res = await axios.post("/api/login", { email, password });
        const token = res.data.token;
        localStorage.setItem("token", token);
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        return token;
    };

    const logout = async () => {
        await axios.post("/api/logout");
        localStorage.removeItem("token");
        delete axios.defaults.headers.common["Authorization"];
    };

    const getToken = () => localStorage.getItem("token");

    return { login, logout, getToken };
}
