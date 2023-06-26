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
            <th v-for="gradeItem in gradeItems" :key="gradeItem.name">
              {{ gradeItem.name }} -
              (Max: {{ gradeItem.maxGrade }})
            </th>
            <th>Total Grade</th>
            <!-- <th>Total Max Grade</th> -->
            <!-- Add a new table header for total max grade -->
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in students" :key="student.code">
            <td>{{ student.full_name }}</td>
            <td>{{ student.code }}</td>
            <td v-for="gradeItem in gradeItems" :key="gradeItem.name">
              {{ getGrade(student, gradeItem.name) }}
            </td>
            <td>{{ calculateTotalGrade(student) }} /
            {{ calculateTotalMaxGrade() }}</td>
            <!-- Display the total max grade -->
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

        return firstStudent.grades.map((grade) => {
          return {
            name: grade.grade_item_name,
            maxGrade: grade.grade_item.max_degree,
          };
        });
      }
      return [];
    },
    getGrade(student, gradeItem) {
      const grade = student.grades.find(
        (grade) => grade.grade_item_name === gradeItem
      );
      return grade ? `${grade.grade}/${grade.grade_item.max_degree}` : "--";
    },
    calculateTotalGrade(student) {
      const totalGrade = student.grades.reduce((sum, grade) => {
        return sum + grade.grade;
      }, 0);
      return totalGrade;
    },
    calculateTotalMaxGrade() {
      const totalMaxGrade = this.gradeItems.reduce((sum, gradeItem) => {
        return sum + gradeItem.maxGrade;
      }, 0);
      return totalMaxGrade;
    },
  },
};
</script>

<style>
/* Component styles */
</style>
