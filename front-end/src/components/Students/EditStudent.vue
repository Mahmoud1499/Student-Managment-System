<template>
  <div class="container">
    <h2>Edit Student</h2>

    <form @submit.prevent="updateStudent">
      <!-- Display validation errors if any -->
      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="error in errors" :key="error">{{ error }}</li>
        </ul>
      </div>

      <div class="form-group">
        <label for="code">Code:</label>
        <input
          type="text"
          id="code"
          v-model="student.code"
          class="form-control"
          required
        />
      </div>

      <div class="form-group">
        <label for="full_name">full_name:</label>
        <input
          type="text"
          id="full_name"
          v-model="student.full_name"
          class="form-control"
          required
        />
      </div>

      <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input
          type="date"
          id="dob"
          v-model="student.date_of_birth"
          class="form-control"
          required
        />
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input
          type="email"
          id="email"
          v-model="student.email"
          class="form-control"
          required
        />
      </div>

      <div class="form-group">
        <label for="level">Level ID:</label>
        <input
          type="text"
          id="level"
          v-model="student.level_id"
          class="form-control"
          required
        />
      </div>

      <button type="submit" class="btn btn-primary">Update Student</button>
    </form>

    <!-- Confirmation message -->
    <div v-if="showConfirmation" class="alert alert-success">
      Student updated successfully!
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { BASE_URL } from "../../api";

export default {
  data() {
    return {
      student: {
        code: "",
        full_name: "",
        date_of_birth: "",
        email: "",
        level_id: "",
      },
      errors: [], // Validation errors
      showConfirmation: false, // Confirmation message flag
    };
  },
  mounted() {
    // Fetch student data and populate the form
    this.fetchStudent();
  },
  methods: {
    fetchStudent() {
      const studentId = this.$route.params.id; // Assuming you have the student ID in the route parameter
      axios
        .get(`${BASE_URL}students/${studentId}`) // Use BASE_URL constant here
        .then((response) => {
          const studentData = response.data;
          this.student = {
            code: studentData.code,
            full_name: studentData.full_name,
            date_of_birth: studentData.date_of_birth,
            email: studentData.email,
            level_id: studentData.level_id,
          };
        })
        .catch((error) => {
          console.error(error);
        });
    },
    updateStudent() {
      // Reset errors and confirmation message
      this.errors = [];
      this.showConfirmation = false;

      // Perform validation
      if (!this.validateForm()) {
        return;
      }

      // Make API call to update the student
      const studentCode = this.$route.params.id; // Assuming you have the student code in the route parameter
      axios
        .put(`${BASE_URL}students/${studentCode}`, this.student) // Use BASE_URL constant here
        .then(() => {
          // Show confirmation message
          this.showConfirmation = true;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    validateForm() {
      // Reset errors
      this.errors = [];

      // Perform validation
      if (!this.student.code) {
        this.errors.push("Code is required.");
      }

      if (!this.student.full_name) {
        this.errors.push("full_name is required.");
      }

      if (!this.student.date_of_birth) {
        this.errors.push("Date of Birth is required.");
      }

      if (!this.student.email) {
        this.errors.push("Email is required.");
      }

      if (!this.student.level_id) {
        this.errors.push("Level ID is required.");
      }

      return this.errors.length === 0;
    },
  },
};
</script>

<style>
/* Add any custom styles here */
</style>
