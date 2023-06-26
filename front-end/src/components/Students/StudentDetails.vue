<template>
  <div class="container">
    <h2>Student Details</h2>
    <div v-if="student">
      <p><strong>Code:</strong> {{ student.code }}</p>
      <p><strong>Name:</strong> {{ student.full_name }}</p>
      <p><strong>Date of Birth:</strong> {{ student.date_of_birth }}</p>
      <p><strong>Email:</strong> {{ student.email }}</p>
      <p><strong>Level:</strong> {{ student.level_id }}</p>

      <h3>Enrolled Courses</h3>
      <table class="table">
        <thead>
          <tr>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="course in student.courses" :key="course.code">
            <td>{{ course.code }}</td>
            <td>{{ course.name }}</td>
            <td>
              <button
                class="btn btn-danger"
                @click="removeStudentFromCourse(course.code)"
              >
                Remove
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <h3>Available Courses</h3>
      <table class="table">
        <thead>
          <tr>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="course in courses" :key="course.code">
            <td>{{ course.code }}</td>
            <td>{{ course.name }}</td>
            <td>
              <button
                class="btn btn-primary btn-sm float-right"
                @click="enrollStudentInCourse(course.code)"
              >
                Enroll
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else>
      <p>Loading student details...</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { BASE_URL } from "../../api";

export default {
  data() {
    return {
      student: null,
      courses: [],
    };
  },
  mounted() {
    this.fetchStudentDetails();
    this.fetchCourses();
  },
  methods: {
    fetchStudentDetails() {
      const studentCode = this.$route.params.code;
      axios
        .get(`${BASE_URL}students/${studentCode}`)
        .then((response) => {
          this.student = response.data;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    fetchCourses() {
      axios
        .get(`${BASE_URL}courses`)
        .then((response) => {
          const enrolledCourseCodes = this.student.courses.map((course) => course.code);
          this.courses = response.data.filter((course) => !enrolledCourseCodes.includes(course.code));
        })
        .catch((error) => {
          console.error(error);
        });
    },
    removeStudentFromCourse(courseCode) {
      const studentCode = this.student.code;

      if (
        confirm("Are you sure you want to remove this student from the course?")
      ) {
        axios
          .delete(`${BASE_URL}courses/${courseCode}/students/${studentCode}`)
          .then(() => {
            // Refresh the student details after successful removal
            this.fetchStudentDetails();
            this.fetchCourses();

          })
          .catch((error) => {
            console.error(error);
          });
      }
    },
    enrollStudentInCourse(courseCode) {
      const studentCode = this.student.code;

      axios
        .post(`${BASE_URL}courses/${courseCode}/students/${studentCode}`)
        .then(() => {
          // Refresh the student details after successful enrollment
          this.fetchStudentDetails();
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
