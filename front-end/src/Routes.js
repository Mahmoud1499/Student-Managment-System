import Home from "./components/welcomeComponent.vue";
import ListAllStudents from "./components/Students/ListAllStudents.vue";
import StudentDetails from "./components/Students/StudentDetails.vue";
import AddStudent from "./components/Students/AddStudent.vue";
import EditStudent from "./components/Students/EditStudent.vue";

import ListAllCourses from "./components/Courses/ListAllCourses";
import CourseDetails from "./components/Courses/CourseDetails";
import AddCourse from "./components/Courses/AddCourse";
import EditCourse from "./components/Courses/EditCourse";

// import Contact from "./components/Contact.vue";

const routes = [
  { path: "/", component: Home },
  // Students
  { path: "/students", component: ListAllStudents },
  {
    path: "/students/:code",
    component: StudentDetails,
  },
  {
    path: "/add-student",
    name: "AddStudent",
    component: AddStudent,
  },
  {
    path: "/students/:id/edit",
    name: "EditStudent",
    component: EditStudent,
  },
  { path: "/courses", component: ListAllCourses },
  { path: "/courses/:code", component: CourseDetails },
  { path: "/add-course", name: "AddCourse", component: AddCourse },
  { path: "/courses/:code/edit", name: "EditCourse", component: EditCourse },
  // Courses
];

export default routes;
