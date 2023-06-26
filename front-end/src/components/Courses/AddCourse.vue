<template>
  <div class="container">
    <h2>Add Course</h2>

    <form @submit.prevent="createCourse">
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
          v-model="course.code"
          class="form-control"
          required
        />
      </div>

      <div class="form-group">
        <label for="name">Name:</label>
        <input
          type="text"
          id="name"
          v-model="course.name"
          class="form-control"
          required
        />
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea
          id="description"
          v-model="course.description"
          class="form-control"
          required
        ></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Add Course</button>
    </form>

    <!-- Confirmation message -->
    <div v-if="showConfirmation" class="alert alert-success">
      Course added successfully!
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { BASE_URL } from '../../api';

export default {
  data() {
    return {
      course: {
        code: '',
        name: '',
        description: ''
      },
      errors: [], // Validation errors
      showConfirmation: false // Confirmation message flag
    };
  },
  methods: {
    createCourse() {
      // Reset errors and confirmation message
      this.errors = [];
      this.showConfirmation = false;

      // Perform validation
      if (!this.validateForm()) {
        return;
      }

      // Make API call to create the course
      axios
        .post(`${BASE_URL}courses`, this.course)
        .then(() => {
          // Show confirmation message
          this.showConfirmation = true;

          // Reset the form fields
          this.course.code = '';
          this.course.name = '';
          this.course.description = '';
        })
        .catch(error => {
          console.error(error);
        });
    },
    validateForm() {
      // Reset errors
      this.errors = [];

      // Perform validation
      if (!this.course.code) {
        this.errors.push('Code is required.');
      }

      if (!this.course.name) {
        this.errors.push('Name is required.');
      }

      if (!this.course.description) {
        this.errors.push('Description is required.');
      }

      return this.errors.length === 0;
    }
  }
};
</script>

<style>
/* Component styles */
</style>
