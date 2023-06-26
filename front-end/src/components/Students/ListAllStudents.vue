<template>
  <div class="container">
    <h2>All Students</h2>
    <div class="d-flex justify-content-end mb-3">
      <router-link to="/add-student" class="btn btn-primary">
        Add New Student
      </router-link>
    </div>
    <div class="form-group mb-2">
      <label for="search">Search:</label>
      <input
        type="text"
        class="form-control"
        id="search"
        v-model="searchTerm"
        @input="filterStudents"
      />
    </div>
    <table class="table table-striped float-right">
      <thead>
        <tr>
          <th>#</th>
          <th>Code</th>
          <th>Name</th>
          <th>Date of Birth</th>
          <th>Email</th>
          <th>Level </th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(student, index) in filteredStudents" :key="student.code">
          <td>{{ index + 1 }}</td>
          <td>{{ student.code }}</td>
          <td>{{ student.full_name }}</td>
          <td>{{ student.date_of_birth }}</td>
          <td>{{ student.email }}</td>
          <td>{{ student.level_id }}</td>
          <td>
            <router-link :to="`/students/${student.code}`" class="btn btn-info">
              Details
            </router-link>
            <router-link
              :to="`/students/${student.code}/edit`"
              class="btn btn-success mx-2"
            >
              Edit
            </router-link>

            <button
              class="btn btn-danger"
              @click="confirmDeleteStudent(student)"
            >
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteConfirmationModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Delete</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this student?</p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="cancelDeleteStudent"
            >
              Cancel
            </button>

            <button
              type="button"
              class="btn btn-danger"
              @click="deleteStudentConfirmed()"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { BASE_URL } from "../../api";

export default {
  data() {
    return {
      students: [],
      selectedStudent: null,
      filteredStudents: [],
      searchTerm: "",
    };
  },
  mounted() {
    this.fetchStudents();
  },
  methods: {
    fetchStudents() {
      axios
        .get(`${BASE_URL}students`)
        .then((response) => {
          this.students = response.data;
          this.filterStudents(); // Filter students initially
        })
        .catch((error) => {
          console.error(error);
        });
    },
    filterStudents() {
      if (this.searchTerm === "") {
        // If search term is empty, display all students
        this.filteredStudents = this.students;
      } else {
        // Perform search filtering
        const search = this.searchTerm.toLowerCase();
        this.filteredStudents = this.students.filter(
          (student) =>
            student.full_name.toLowerCase().includes(search) ||
            student.code.toLowerCase().includes(search) ||
            student.email.toLowerCase().includes(search)
        );
      }
    },
    confirmDeleteStudent(student) {
      this.selectedStudent = student;
      document.getElementById("deleteConfirmationModal").classList.add("show");
    },
    deleteStudentConfirmed() {
      if (this.selectedStudent) {
        axios
          .delete(`${BASE_URL}students/${this.selectedStudent.code}`)
          .then((response) => {
            if (response.status === 200) {
              const index = this.students.findIndex(
                (student) => student.code === this.selectedStudent.code
              );
              if (index !== -1) {
                this.students.splice(index, 1);
              }
            } else {
              console.error(response.data.error);
            }
          })
          .catch((error) => {
            console.error(error);
          });
      }
      document
        .getElementById("deleteConfirmationModal")
        .classList.remove("show");
    },
    cancelDeleteStudent() {
      document
        .getElementById("deleteConfirmationModal")
        .classList.remove("show");
    },
  },
};
</script>

<style>
/* Add any custom styles here */
.show {
  display: block;
}
</style>
