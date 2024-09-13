import { createRouter, createWebHistory } from "vue-router";
import Register from "../views/Auth/Registration.vue";
import UsersIndex from "../views/Users/UsersIndex.vue";
import UsersShow from "../views/Users/UsersShow.vue";
import PositionsIndex from "../views/Positions/PositionsIndex.vue";
import Home from "../views/Home.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "Home",
            component: Home,
        },
        {
            path: "/register",
            name: "Registration",
            component: Register,
        },
        {
            path: "/positions",
            name: "Positions",
            component: PositionsIndex,
        },
        {
            path: "/users",
            name: "Users",
            component: UsersIndex,
        },
        {
            path: "/users-show",
            name: "Users Get By id",
            component: UsersShow,
        },
    ],
});

export default router;
