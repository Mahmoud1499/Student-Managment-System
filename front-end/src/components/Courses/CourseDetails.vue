<template>
  <div class="container">
    <h2>Course Details</h2>
    <div v-if="course">
      <p><strong>Code:</strong> {{ course.code }}</p>
      <p><strong>Name:</strong> {{ course.name }}</p>
      <p><strong>Description:</strong> {{ course.description }}</p>
      <table class="table">
        <thead>
          <tr>
            <th>Student Full Name</th>
            <th>Student Code</th>
            <th v-for="gradeItem in gradeItems" :key="gradeItem">
              {{ gradeItem }}
            </th>
            <th>Total Grade</th>
            <!-- Add a new table header for total grade -->
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in students" :key="student.code">
            <td>{{ student.full_name }}</td>
            <td>{{ student.code }}</td>
            <td v-for="gradeItem in gradeItems" :key="gradeItem">
              {{ getGrade(student, gradeItem) }}
            </td>
            <td>{{ calculateTotalGrade(student) }}</td>
            <!-- Calculate and display total grade -->
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <p>Loading course details...</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { BASE_URL } from "../../api";

export default {
  data() {
    return {
      course: null,
      students: [],
      gradeItems: [],
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
        .then((response) => {
          this.course = response.data.course;
          this.students = this.course.students;
          this.gradeItems = this.getGradeItems();
        })
        .catch((error) => {
          console.error(error);
        });
    },
    getGradeItems() {
      if (this.students.length > 0) {
        const firstStudent = this.students[0];
        return firstStudent.grades.map((grade) => grade.grade_item_name);
      }
      return [];
    },
    getGrade(student, gradeItem) {
      const grade = student.grades.find(
        (grade) => grade.grade_item_name === gradeItem
      );
      return grade ? grade.grade : "--";
    },
    calculateTotalGrade(student) {
      const totalGrade = student.grades.reduce((sum, grade) => {
        return sum + grade.grade;
      }, 0);
      return totalGrade;
    },
  },
};
</script>

<style>
/* Component styles */
</style>
