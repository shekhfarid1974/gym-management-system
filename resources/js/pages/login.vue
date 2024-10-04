<template>
    <div class="login-container">
      <h2>Login</h2>
      <form @submit.prevent="login">
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Password" required />
        <button type="submit">Login</button>
      </form>
      <p v-if="errorMessage">{{ errorMessage }}</p>
    </div>
    <router-link :to="{ name: 'admin' }">Go to About Page</router-link>
  </template>
  
  <script setup>
  import { RouterLink, RouterView } from 'vue-router';
  import { ref } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  const email = ref('');
  const password = ref('');
  const errorMessage = ref('');
  const router = useRouter();
  
  const login = () => {
  axios.post('/api/login', { email: email.value, password: password.value })
    .then(response => {
      const user = response.data.user;
      const token = response.data.token;
      
      // Save token to localStorage
      localStorage.setItem('token', token);
      localStorage.setItem('user', JSON.stringify(user));
      
      // Redirect to the appropriate dashboard
      if (user.role === 'Admin') {
        router.push('/admin/dashboard');
      } else if (user.role === 'Trainer') {
        router.push('/trainer/dashboard');
      } else if (user.role === 'Trainee') {
        router.push('/trainee/dashboard');
      }
    })
    .catch(error => {
      errorMessage.value = "Invalid credentials. Please try again.";
    });
};

  </script>
  
  <style scoped>
  .login-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
  }
  form {
    display: flex;
    flex-direction: column;
  }
  input {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
  }
  button {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
  }
  button:hover {
    background-color: #45a049;
  }
  </style>
  