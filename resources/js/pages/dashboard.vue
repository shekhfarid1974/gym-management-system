<template>
    <div>
        <h2>Admin Dashboard</h2>
        
        <!-- Trainer Management -->
        <h3>Trainers</h3>
        <button @click="showTrainerForm = !showTrainerForm">Create Trainer</button>

        <div v-if="showTrainerForm">
            <h4>Add Trainer</h4>
            <form @submit.prevent="createTrainer">
                <input v-model="newTrainer.name" placeholder="Name" required />
                <input v-model="newTrainer.email" type="email" placeholder="Email" required />
                <input v-model="newTrainer.expertise" placeholder="Expertise" required />
                <input v-model="newTrainer.availability" type="datetime-local" required />
                <span v-if="availabilityError" style="color:red;">{{ availabilityError }}</span>
                <button type="submit">Submit</button>
            </form>
        </div>

        <ul v-if="trainers.length">
            <li v-for="trainer in trainers" :key="trainer.id">
                {{ trainer.name }} ({{ trainer.expertise }})
                <button @click="updateTrainer(trainer.id)">Update</button>
                <button @click="deleteTrainer(trainer.id)">Delete</button>
            </li>
        </ul>
        <p v-else>No trainers available.</p>

        <!-- Class Management -->
        <h3>Classes</h3>
        <button @click="showClassForm = !showClassForm">Create Class</button>

        <div v-if="showClassForm">
            <h4>Add Class</h4>
            <form @submit.prevent="createClass">
                <select v-model="newClass.trainer_id" required>
                    <option value="" disabled>Select Trainer</option>
                    <option v-for="trainer in trainers" :key="trainer.id" :value="trainer.id">
                        (Name:{{ trainer.name }})---(Expertise:{{trainer.expertise}})---(Available date and time:{{trainer.availability}})
                    </option>
                </select>
                <input v-model="newClass.class_time" type="datetime-local" required />
                <input v-model="newClass.capacity" type="number" placeholder="Capacity" required />
                <button type="submit">Submit</button>
            </form>
        </div>

        <ul v-if="classes.length">
            <li v-for="gymClass in classes" :key="gymClass.id">
                {{ gymClass.name }} ({{ gymClass.class_time }}) - Capacity: {{ gymClass.capacity }}
            </li>
        </ul>
        <p v-else>No classes available.</p>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const trainers = ref([]);
const classes = ref([]);
const showTrainerForm = ref(false);
const showClassForm = ref(false);
const availabilityError = ref('');

// Add your JWT token here
const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzI3OTgyMDUwLCJleHAiOjE3Mjc5ODU2NTAsIm5iZiI6MTcyNzk4MjA1MCwianRpIjoiMENVTEQ2T2dDcnpET3NzTyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.besUlTau2wF0diEqQ6czFfbqAHWrPgq2Rsc1Uudgud8';

// Set up Axios default headers
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

const newTrainer = ref({
    name: '',
    email: '',
    expertise: '',
    availability: ''
});

const newClass = ref({
    trainer_id: '', // Add trainer_id to newClass
    class_time: '',
    capacity: ''
});

// Validate availability input
const validateAvailability = (availability) => {
    const regex = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$/; // Regex for Y-m-d\TH:i:s format
    return regex.test(availability);
};

// Fetch Trainers from the API
const fetchTrainers = () => {
    axios.get('/api/admin/trainers')
        .then(response => {
            trainers.value = response.data;
        })
        .catch(error => {
            console.error('Error fetching trainers:', error);
        });
};

// Fetch Classes from the API
const fetchClasses = () => {
    axios.get('/api/admin/classes')
        .then(response => {
            classes.value = response.data;
        })
        .catch(error => {
            console.error('Error fetching classes:', error);
        });
};

// Create Trainer
const createTrainer = () => {
    availabilityError.value = ''; // Clear any previous error
    const trainerData = {
        name: newTrainer.value.name,
        email: newTrainer.value.email,
        expertise: newTrainer.value.expertise,
        availability: newTrainer.value.availability
    };
    
    axios.post('/api/admin/trainers', trainerData)
        .then(response => {
            alert('Trainer created successfully!');
            fetchTrainers(); // Refresh the trainers list
            resetTrainerForm(); // Reset the form
        })
        .catch(error => {
            console.error('Error creating trainer:', error);
        });
};

// Reset the trainer form
const resetTrainerForm = () => {
    newTrainer.value = {
        name: '',
        email: '',
        expertise: '',
        availability: ''
    };
    showTrainerForm.value = false; // Hide the form after submission
};

// Update Trainer
const updateTrainer = (id) => {
    const updatedTrainer = {
        name: 'Jane Doe',  // New values for the trainer
        expertise: 'Pilates',
        availability: 'Tuesday to Saturday'
    };
    axios.put(`/api/admin/trainers/${id}`, updatedTrainer)
        .then(response => {
            alert('Trainer updated successfully!');
            fetchTrainers(); // Refresh the trainers list
        })
        .catch(error => {
            console.error('Error updating trainer:', error);
        });
};

// Delete Trainer
const deleteTrainer = (id) => {
    if (confirm('Are you sure you want to delete this trainer?')) {
        axios.delete(`/api/admin/trainers/${id}`)
            .then(response => {
                alert('Trainer deleted successfully!');
                fetchTrainers(); // Refresh the trainers list
            })
            .catch(error => {
                console.error('Error deleting trainer:', error);
            });
    }
};

// Create Class
const createClass = () => {
    const classData = {
        trainer_id: newClass.value.trainer_id,
        class_time: newClass.value.class_time,
        capacity: newClass.value.capacity
    };
    
    axios.post('/api/admin/classes', classData)
        .then(response => {
            alert('Class created successfully!');
            fetchClasses(); // Refresh the classes list
            resetClassForm(); // Reset the form
        })
        .catch(error => {
            console.error('Error creating class:', error);
        });
};

// Reset the class form
const resetClassForm = () => {
    newClass.value = {
        trainer_id: '', // Reset trainer_id
        class_time: '',
        capacity: ''
    };
    showClassForm.value = false; // Hide the form after submission
};

// Fetch data when component is mounted
onMounted(() => {
    fetchTrainers();
    fetchClasses();
});
</script>

<style scoped>
h2, h3, h4 {
    font-size: 24px;
    margin-bottom: 10px;
}

button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 10px;
}

button:hover {
    background-color: #0056b3;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    margin: 5px 0;
}

p {
    font-size: 16px;
    color: #555;
}

form {
    margin-bottom: 20px;
}

input, select {
    display: block;
    margin: 5px 0;
    padding: 10px;
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>
