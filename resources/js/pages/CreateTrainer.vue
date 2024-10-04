<template>
    <div>
        <h2>Create New Trainer</h2>
        <form @submit.prevent="submitForm">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" v-model="trainer.name" required />
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="trainer.email" required />
            </div>
            <div>
                <label for="expertise">Expertise:</label>
                <input type="text" id="expertise" v-model="trainer.expertise" required />
            </div>
            <div>
                <label for="availability">Availability:</label>
                <input type="text" id="availability" v-model="trainer.availability" required />
            </div>
            <button type="submit">Create Trainer</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

// Initialize form data
const trainer = ref({
    name: '',
    email: '',
    expertise: '',
    availability: ''
});

const router = useRouter();

// Form submission handler
const submitForm = () => {
    axios.post('/api/admin/trainers', trainer.value)
        .then(response => {
            alert('Trainer created successfully!');
            router.push('/admin/trainers');  // Redirect to trainer list or dashboard
        })
        .catch(error => {
            console.error('Error creating trainer:', error);
        });
};
</script>

<style scoped>
form {
    display: flex;
    flex-direction: column;
    max-width: 400px;
}

div {
    margin-bottom: 15px;
}

label {
    margin-bottom: 5px;
    font-weight: bold;
}

input {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>
