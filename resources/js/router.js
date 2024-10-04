import { createRouter, createWebHistory } from 'vue-router';

// Import your components
import AdminDashboard from './pages/dashboard.vue';
import Login from './pages/login.vue';
import CreateTrainer from './pages/CreateTrainer.vue';  // Import CreateTrainer component
import CreateClass from './pages/CreateClass.vue';      // Import CreateClass component

// Define your routes
const routes = [
    {
        path: '/',
        name: 'login',
        component: Login,
    },
    {
        path: '/dashboard',
        name: 'admin',
        component: AdminDashboard,
    },
    {
        path: '/create-trainer',
        name: 'CreateTrainer',
        component: CreateTrainer,   // Route for Create Trainer page
    },
    {
        path: '/create-class',
        name: 'CreateClass',
        component: CreateClass,     // Route for Create Class page
    }
];

// Create the router instance
const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
