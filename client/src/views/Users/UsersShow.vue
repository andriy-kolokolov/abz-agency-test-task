<script
    setup
    lang="ts"
>
import { reactive } from "vue";
import axios from "axios";
import store from "@/store";
import { notification } from "ant-design-vue";
/*
 'id'                     => $this->id,
            'name'                   => $this->name,
            'email'                  => $this->email,
            'phone'                  => $this->phone,
            'position'               => $this->position->name,
            'position_id'            => $this->position_id,
            'photo'                  => $this->photo,
 */

interface UserData {
    success: boolean,
    user: {
        id: string,
        name: string,
        email: string,
        phone: string,
        position: string,
        position_id: number,
        photo: string,
    }
}
const state = reactive({
    fetching: false,
    userId: null,
    userData: null as UserData | null,
});

const getUser = async () => {
    state.fetching = true;
    if (!state.userId) {
        notification.error({
            message: "User id cannot be null",
        });
        return;
    }

    axios.get(`${ store.apiUrl }/users/${ state.userId }`, {}).then((res) => {
        state.userData = res.data;
    }).catch((err) => {
        notification.error({
            message: err.response.data.message,
        });
    }).finally(() => {
        state.fetching = false;
    });
};

</script>

<template>

    <a-flex
        gap="small"
        :style="{margin: '20px 20px'}"
    >
        <a-button @click="getUser">
            Get user by Id
        </a-button>

        <a-form-item label="USER ID">
            <a-input-number
                style="width: 300px"
                v-model:value="state.userId"
            />
        </a-form-item>
    </a-flex>

    <template v-if="state.userData">
        <a-descriptions bordered>
            <a-descriptions-item
                :span="3"
                label="ID"
            >
                {{ state.userData.user.id }}
            </a-descriptions-item>
            <a-descriptions-item
                :span="3"
                label="Name"
            >
                {{ state.userData.user.name }}
            </a-descriptions-item>
            <a-descriptions-item
                :span="3"
                label="Email"
            >
                {{ state.userData.user.email }}
            </a-descriptions-item>
            <a-descriptions-item
                :span="3"
                label="Position"
            >
                {{ state.userData.user.position }}
            </a-descriptions-item>
            <a-descriptions-item
                :span="3"
                label="Phone"
            >
                {{ state.userData.user.phone }}
            </a-descriptions-item>
            <a-descriptions-item
                :span="3"
                label="Position Id"
            >
                {{ state.userData.user.position_id }}
            </a-descriptions-item>
            <a-descriptions-item
                :span="3"
                label="Position Id"
            >
                {{ state.userData.user.photo }}
            </a-descriptions-item>
        </a-descriptions>
    </template>
</template>

<style>

</style>