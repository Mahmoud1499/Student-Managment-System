<template>
  <div class="container">
    <h2>Add Student</h2>

    <form @submit.prevent="createStudent">
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
        <label for="name">Name:</label>
        <input
          type="text"
          id="name"
          v-model="student.name"
          class="form-control"
          required
        />
      </div>

      <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input
          type="date"
          id="dob"
          v-model="student.dateOfBirth"
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
          v-model="student.levelId"
          class="form-control"
          required
        />
      </div>

      <button type="submit" class="btn btn-primary">Create Student</button>
    </form>

    <!-- Confirmation message -->
    <div v-if="showConfirmation" class="alert alert-success">
      Student created successfully!
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
        name: "",
        dateOfBirth: "",
        email: "",
        levelId: "",
      },
      errors: [], // Validation errors
      showConfirmation: false, // Confirmation message flag
    };
  },
  methods: {
    createStudent() {
      // Reset errors and confirmation message
      this.errors = [];
      this.showConfirmation = false;

      // Perform validation
      if (!this.validateForm()) {
        return;
      }

      // Make API call to create the student
      axios
        .post(`${BASE_URL}students`, this.student) // Use BASE_URL constant here
        .then(() => {
          // Show confirmation message
          this.showConfirmation = true;

          // Reset form fields
          this.student.code = "";
          this.student.name = "";
          this.student.dateOfBirth = "";
          this.student.email = "";
          this.student.levelId = "";
        })
        .catch((error) => {
          // Handle API error and display error message
          console.error(error);
          this.errors.push("Failed to create student. Please try again later.");
        });
    },
    validateForm() {
      // Perform form validation
      this.errors = [];

      if (!this.student.code) {
        this.errors.push("Code is required.");
      }

      if (!this.student.name) {
        this.errors.push("Name is required.");
      }

      if (!this.student.dateOfBirth) {
        this.errors.push("Date of Birth is required.");
      }

      if (!this.student.email) {
        this.errors.push("Email is required.");
      }

      if (!this.student.levelId) {
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
