<template>
  <div class="container">
    <h2>All Courses</h2>

    <div class="d-flex justify-content-end mb-3">
      <router-link to="/add-course" class="btn btn-primary">
        Add New Course
      </router-link>
    </div>

    <div class="form-group mb-2">
      <label for="search">Search:</label>
      <input
        type="text"
        class="form-control"
        id="search"
        v-model="searchTerm"
        @input="filterCourses"
      />
    </div>
    <table class="table table-striped float-right">
      <thead>
        <tr>
          <th>#</th>
          <th>Code</th>
          <th>Name</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(course, index) in filteredCourses" :key="course.code">
          <td>{{ index + 1 }}</td>
          <td>{{ course.code }}</td>
          <td>{{ course.name }}</td>
          <td>{{ course.description }}</td>
          <td>
            <router-link :to="`/courses/${course.code}`" class="btn btn-info">
             Details
            </router-link>
            <router-link
              :to="`/courses/${course.code}/edit`"
              class="btn btn-success mx-2"
            >
              Edit
            </router-link>
            <button class="btn btn-danger" @click="confirmDeleteCourse(course)">
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
            <p>Are you sure you want to delete this course?</p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="cancelDeleteCourse"
            >
              Cancel
            </button>

            <button
              type="button"
              class="btn btn-danger"
              @click="deleteCourseConfirmed()"
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
      courses: [],
      selectedCourse: null,
      filteredCourses: [],

      searchTerm: "",
    };
  },
  mounted() {
    this.fetchCourses();
  },
  methods: {
    fetchCourses() {
      axios
        .get(`${BASE_URL}courses`) // Use BASE_URL constant here
        .then((response) => {
          this.courses = response.data;
          this.filterCourses(); // Filter courses initially
        })
        .catch((error) => {
          console.error(error);
        });
    },

    filterCourses() {
      if (this.searchTerm === "") {
        // If search term is empty, display all courses
        this.filteredCourses = this.courses;
      } else {
        // Perform search filtering
        const search = this.searchTerm.toLowerCase();
        this.filteredCourses = this.courses.filter(
          (course) =>
            course.name.toLowerCase().includes(search) ||
            course.code.toLowerCase().includes(search)
        );
      }
    },

    confirmDeleteCourse(course) {
      // Set the selected course to delete
      this.selectedCourse = course;

      // Show the delete confirmation modal
      document.getElementById("deleteConfirmationModal").classList.add("show");
    },
    deleteCourseConfirmed() {
      if (this.selectedCourse) {
        // Perform the delete operation using the selectedCourse object
        axios
          .delete(`${BASE_URL}courses/${this.selectedCourse.code}`)
          .then((response) => {
            // Check the response status and handle accordingly
            if (response.status === 200) {
              // Remove the course from the list
              const index = this.courses.findIndex(
                (course) => course.code === this.selectedCourse.code
              );
              if (index !== -1) {
                this.courses.splice(index, 1);
              }
            } else {
              console.error(response.data.error); // Log the error message
            }
          })
          .catch((error) => {
            console.error(error); // Log any other errors
          });
      }

      // Hide the delete confirmation modal
      document
        .getElementById("deleteConfirmationModal")
        .classList.remove("show");
    },
    cancelDeleteCourse() {
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
