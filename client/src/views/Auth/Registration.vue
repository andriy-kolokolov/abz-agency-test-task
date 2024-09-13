<script
    setup
    lang="ts"
>
import axios from "axios";
import store from "@/store";
import { onMounted, reactive } from "vue";
import { SearchOutlined } from "@ant-design/icons-vue";
import { notification } from "ant-design-vue";

interface State {
    fetching: boolean;
    token: string;
    positions: { id: number, name: string }[];
    errors: Errors;
}

type Errors = {
    [key in keyof Form]?: string[];
};

interface Form {
    token: string;
    name: string;
    email: string;
    phone: string;
    position_id: number | null;
}

const state = reactive<State>({
    fetching: false,
    token: "",
    positions: [],
    errors: {},
});

const form = reactive<Form>({
    token: "",
    name: "",
    email: "",
    phone: "",
    position_id: null,
});

onMounted(() => {
    state.fetching = true;

    axios.get(`${ store.apiUrl }/positions`)
         .then((res) => {
             state.positions = res.data.positions;
         })
         .catch((err) => {
             state.errors = err.response.data.errors;

             notification.error({
                 message: "Error",
                 description: Object.values(err.response.data.errors).join("\n"),
             });
         })
         .finally(() => {
             state.fetching = false;
         });
});

const getToken = () => {
    state.fetching = true;

    axios.get(`${ store.apiUrl }/token`)
         .then((res) => {
             state.token = res.data.token;
         })
         .finally(() => {
             state.fetching = false;
         });
};

const submitRegister = () => {
    state.fetching = true;

    axios.post(`${ store.apiUrl }/users`, form, {
             headers: {
                 Token: form.token,
             },
         })
         .then((res) => {
             notification.success({
                 message: "Success",
                 description: res.data.message,
             });
         })
         .catch((err) => {
             if (!err.response.data.success) {
                 notification.error({
                     message: err.response.data.message,
                 });
             }

             if (err.response.data.errors) {
                 state.errors = err.response.data.errors;

                 notification.error({
                     message: "Error",
                     description: Object.values(err.response.data.errors).join("\n"),
                 });
             }
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
                @click="getToken"
                type="primary"
                :loading="state.fetching"
            >
                <template #icon>
                    <SearchOutlined />
                </template>
                GET TOKEN
            </a-button>
        </template>
    </a-card>

    <a-flex
        justify="center"
        vertical
        align="center"
    >
        <a-typography-title :level="2">
            TOKEN:
        </a-typography-title>

        <a-typography-title
            :level="3"
            copyable
        >
            {{ state.token }}
        </a-typography-title>
    </a-flex>

    <a-divider />

    <a-form>
        <a-form-item
            :validate-status="state.errors?.token ? 'error' : ''"
            label="TOKEN"
            name="token"
        >
            <a-input v-model:value="form.token" />
        </a-form-item>

        <a-form-item
            :validate-status="state.errors?.name ? 'error' : ''"
            :help="state.errors?.name ? state.errors?.name[0] : ''"
            label="Name"
            name="name"
        >
            <a-input v-model:value="form.name" />
        </a-form-item>

        <a-form-item
            :validate-status="state.errors?.email ? 'error' : ''"
            :help="state.errors?.email ? state.errors?.email[0] : ''"
            label="Email"
            name="email"
        >
            <a-input v-model:value="form.email" />
        </a-form-item>

        <a-form-item
            :validate-status="state.errors?.phone ? 'error' : ''"
            :help="state.errors?.phone ? state.errors?.phone[0] : ''"
            label="Phone"
            name="phone"
        >
            <a-input v-model:value="form.phone" />
        </a-form-item>

        <a-form-item
            :validate-status="state.errors?.position_id ? 'error' : ''"
            :help="state.errors?.position_id ? state.errors?.position_id[0] : ''"
            label="Position"
            name="position_id"
        >
            <a-select v-model:value="form.position_id">
                <a-select-option
                    v-for="position in state.positions"
                    :key="position.id"
                    :value="position.id"
                >
                    {{ position.name }}
                </a-select-option>
            </a-select>
        </a-form-item>

        <a-form-item>
            <a-button
                type="primary"
                @click="submitRegister"
            >
                Register
            </a-button>
        </a-form-item>
    </a-form>
</template>

<style scoped>

</style>