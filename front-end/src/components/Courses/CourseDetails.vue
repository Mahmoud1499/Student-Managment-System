<template>
  <div class="container">
    <h2>Course Details</h2>
    <div v-if="course">
      <p><strong>Code:</strong> {{ course.code }}</p>
      <p><strong>Name:</strong> {{ course.name }}</p>
      <p><strong>Description:</strong> {{ course.description }}</p>
    </div>
    <div v-else>
      <p>Loading course details...</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { BASE_URL } from '../../api';

export default {
  data() {
    return {
      course: null
    };
  },
  mounted() {
    this.fetchCourseDetails();
  },
  methods: {
    fetchCourseDetails() {
      const courseCode = this.$route.params.code; 
      axios
        .get(`${BASE_URL}courses/${courseCode}`)
        .then(response => {
          this.course = response.data;
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
