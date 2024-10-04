import { createApp } from 'vue';
import router from './router'; // Import the router
import axios from 'axios'; // Import axios

// Import the root component (if necessary)
import App from './App.vue';

// Create a Vue app and use the router
const app = createApp(App);

// Axios interceptor to add JWT token to every request
axios.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  }, error => {
    return Promise.reject(error);
  });

// Use the router
app.use(router);

// Mount the app to the DOM
app.mount('#app');
