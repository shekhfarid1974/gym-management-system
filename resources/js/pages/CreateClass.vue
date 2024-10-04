<template>
    <div>
        <h2>Create New Class</h2>
        <form @submit.prevent="submitForm">
            <div>
                <label for="name">Class Name:</label>
                <input type="text" id="name" v-model="gymClass.name" required />
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea id="description" v-model="gymClass.description" required></textarea>
            </div>
            <div>
                <label for="date">Date:</label>
                <input type="date" id="date" v-model="gymClass.date" required />
            </div>
            <div>
                <label for="start_time">Start Time:</label>
                <input type="time" id="start_time" v-model="gymClass.start_time" required />
            </div>
            <div>
                <label for="end_time">End Time:</label>
                <input type="time" id="end_time" v-model="gymClass.end_time" required />
            </div>
            <button type="submit">Create Class</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

// Initialize form data
const gymClass = ref({
    name: '',
    description: '',
    date: '',
    start_time: '',
    end_time: ''
});

const router = useRouter();

// Form submission handler
const submitForm = () => {
    axios.post('/api/admin/classes', gymClass.value)
        .then(response => {
            alert('Class created successfully!');
            router.push('/admin/classes');  // Redirect to class list or dashboard
        })
        .catch(error => {
            console.error('Error creating class:', error);
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

input, textarea {
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
