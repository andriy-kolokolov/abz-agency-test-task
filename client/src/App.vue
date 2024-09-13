<script
    setup
    lang="ts"
>
import { RouterLink, RouterView } from "vue-router";
import { ref } from "vue";

const selectedKeys1 = ref<string[]>(["1"]);

</script>


<template>
    <a-layout :style="{display: 'flex', flexDirection: 'vertical'}">
        <a-layout-header>
            <a-menu
                v-model:selectedKeys="selectedKeys1"
                theme="dark"
                mode="horizontal"
            >
                <a-menu-item key="1">
                    <RouterLink to="/">HOME</RouterLink>
                </a-menu-item>
                <a-menu-item key="2">
                    <RouterLink to="/register">REGISTRATION</RouterLink>
                </a-menu-item>
                <a-menu-item key="3">
                    <RouterLink to="/positions">POSITIONS</RouterLink>
                </a-menu-item>
                <a-menu-item key="4">
                    <RouterLink to="/users">USERS</RouterLink>
                </a-menu-item>
                <a-menu-item key="5">
                    <RouterLink to="/users-show">USERS GET BY ID</RouterLink>
                </a-menu-item>
            </a-menu>
        </a-layout-header>

        <a-layout-content>
            <RouterView />
        </a-layout-content>
    </a-layout>

</template>

<style>

</style>
