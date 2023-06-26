<template>
  <div class="container">
    <h2>Student Details</h2>
    <div v-if="student">
      <p><strong>Code:</strong> {{ student.code }}</p>
      <p><strong>Name:</strong> {{ student.full_name }}</p>
      <p><strong>Date of Birth:</strong> {{ student.date_of_birth }}</p>
      <p><strong>Email:</strong> {{ student.email }}</p>
      <p><strong>Level ID:</strong> {{ student.level_id }}</p>
    </div>
    <div v-else>
      <p>Loading student details...</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { BASE_URL } from '../../api';

export default {
  data() {
    return {
      student: null
    };
  },
  mounted() {
    this.fetchStudentDetails();
  },
  methods: {
    fetchStudentDetails() {
      const studentCode = this.$route.params.code; 
      axios
        .get(`${BASE_URL}students/${studentCode}`)
        .then(response => {
          this.student = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
};
</script>

<style>
/* Component styles */
</style>
