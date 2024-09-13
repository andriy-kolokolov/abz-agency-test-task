import { reactive } from "vue";

const store = reactive({
    apiUrl: 'http://localhost:8000/api/v1',
});

export default store;