<template>
    <nav>
      <!-- Your other nav links -->
      <button @click="logout">Logout</button>
    </nav>
  </template>
  
  <script setup>
  import { useRouter } from 'vue-router';
  const router = useRouter();
  
  const logout = () => {
    // Remove the token and user data from localStorage
    localStorage.removeItem('token');
    localStorage.removeItem('user');
  
    // Redirect to the login page
    router.push('/login');
  };
  </script>
  
  <style scoped>
  /* Navbar styles */
  </style>
  