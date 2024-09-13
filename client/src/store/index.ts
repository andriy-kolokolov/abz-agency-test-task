import { reactive } from "vue";

const store = reactive({
    apiUrl: 'http://localhost:9000/api/v1',
});

export default store;