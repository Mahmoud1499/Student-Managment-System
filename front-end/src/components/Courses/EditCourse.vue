<template>
  <div class="container">
    <h2>Edit Course</h2>
    <div v-if="successMessage" class="alert alert-success mt-3">
        {{ successMessage }}
    </div>
    <form @submit.prevent="updateCourse">
      <div class="form-group">
        <label for="code">Code</label>
        <input
          type="text"
          class="form-control"
          id="code"
          v-model="course.code"
          required
        />
      </div>
      <div class="form-group">
        <label for="name">Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          v-model="course.name"
          required
        />
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea
          class="form-control"
          id="description"
          v-model="course.description"
          required
        ></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Update Course</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import { BASE_URL } from "../../api";

export default {
  data() {
    return {
      course: {
        code: "",
        name: "",
        description: "",
      },
      successMessage: "",
    };
  },
  mounted() {
    this.fetchCourseDetails();
  },
  methods: {
    fetchCourseDetails() {
      const courseId = this.$route.params.code;
      axios
        .get(`${BASE_URL}courses/${courseId}`)
        .then((response) => {
          this.course = response.data;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    updateCourse() {
      const courseId = this.$route.params.code;
      console.log(courseId);

      axios
        .put(`${BASE_URL}courses/${courseId}`, this.course)
        .then((response) => {
          // Handle successful update
          this.successMessage = "Course updated successfully.";

          console.log(response.data);
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>

<style>
/* Component styles */
</style>
