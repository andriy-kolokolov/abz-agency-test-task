<script
    setup
    lang="ts"
>
import { h, reactive } from "vue";
import axios from "axios";
import store from "@/store";
import { SearchOutlined } from "@ant-design/icons-vue";
import { notification, Image } from "ant-design-vue";

interface UsersResource {
    id: number,
    name: string,
    email: string,
    phone: string,
    position: string,
    registration_timestamp: number,
    photo: string,
}

interface UsersData {
    success: boolean,
    page: number,
    total_pages: number,
    total_users: number,
    count: number,
    links: {
        next_url: string,
        prev_url: string,
    },
    users: UsersResource[],
}

const columns = [
    {
        title: "ID",
        dataIndex: "id",
    },
    {
        title: "Name",
        dataIndex: "name",
    },
    {
        title: "Email",
        dataIndex: "email",
    },
    {
        title: "Phone",
        dataIndex: "phone",
    },
    {
        title: "Position",
        dataIndex: "position",
    },
    {
        title: "Registration Timestamp",
        dataIndex: "registration_timestamp",
    },
    {
        title: "Photo",
        dataIndex: "photo",
        customRender: ({ record }: { record: any }) => {
            const url = record.photo;

            return h(Image, {
                src: url,
                alt: "User Photo",
                style: {
                    width: "70px",
                    height: "70px",
                    borderRadius: "50%",
                },
            });
        },
    },
];

const state = reactive({
    fetching: false,
    usersData: {} as UsersData,
});

const pagination = reactive({
    current: 1,
    pageSize: 10,
});

const getUsers = async () => {
    state.fetching = true;

    axios.get(`${ store.apiUrl }/users`, {
        params: {
            count: pagination.pageSize,
            page: pagination.current,
        },
    }).then((res) => {
        state.usersData = res.data as UsersData;
    }).catch((err) => {
        notification.error({
            message: err.response.data.message,
        });
    }).finally(() => {
        state.fetching = false;
    });
};

const onPaginationChange = (page: number, pageSize: number) => {
    pagination.current = page;
    pagination.pageSize = pageSize;

    getUsers();
};


</script>

<template>
    <a-card>
        <a-flex gap="small">
            <a-button
                @click="getUsers"
                type="primary"
                :loading="state.fetching"
            >
                <template #icon>
                    <SearchOutlined />
                </template>
                FETCH USERS
            </a-button>
        </a-flex>
    </a-card>

    <a-table
        size="small"
        :loading=" state.fetching"
        :columns="columns"
        :data-source="state.usersData.users"
        rowKey="id"
        :pagination="{
                current: state.usersData.page,
                pageSize: state.usersData.count,
                total:state.usersData.total_users,
                showSizeChanger: true,
                size: 'default',
                showTotal(total:number, range:[number, number]) {
                    return `${ range[0] }-${ range[1] } of ${ total } items`;
                },
                onChange: onPaginationChange,
            }"
    />
</template>

<style scoped>

</style>