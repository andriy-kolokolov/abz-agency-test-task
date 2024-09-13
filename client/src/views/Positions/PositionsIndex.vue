<script
    setup
    lang="ts"
>

import axios from "axios";
import store from "@/store";
import { reactive } from "vue";
import { SearchOutlined } from "@ant-design/icons-vue";

const state = reactive({
    positions: [],
    fetching: false,
});

const columns = [
    {
        dataIndex: "id",
        title: "ID",
    },
    {
        dataIndex: "name",
        title: "Position Name",
    },
];

const getPositions = () => {
    state.fetching = true;

    axios.get(`${ store.apiUrl }/positions`)
         .then((res) => {
             state.positions = res.data.positions;
         })
         .finally(() => {
             state.fetching = false;
         });
};

</script>

<template>
    <a-card>
        <template #title>
            <a-button
                @click="getPositions"
                type="primary"
                :loading="state.fetching"
            >
                <template #icon>
                    <SearchOutlined />
                </template>
                FETCH POSITIONS
            </a-button>
        </template>
    </a-card>

    <a-table
        size="small"
        :loading="state.fetching"
        :columns="columns"
        :data-source="state.positions"
        :pagination="false"
    />
</template>

<style scoped>

</style>