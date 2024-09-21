import { reactive } from "vue";

const store = reactive({
    // docker
    apiUrl: '/api/v1',

    // local
    // apiUrl: 'http://localhost:8000/api/v1',
});

export default store;