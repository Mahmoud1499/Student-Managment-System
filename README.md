# Students' Information Management System

This project is a Students' Information Management System that allows users to manage student information, enroll students in courses, and perform grading for specific courses.

## Features

- CRUD operations for managing students' information.
- Filter and search functionality for students based on levels and specific data.
- Listing and searching courses by course name and code.
- Enrolling and removing students from courses.
- Grading functionality for courses, including multiple grade items.

## Technologies Used

- Frontend: [Vue.js](https://vuejs.org/) (Single Page Application)
- Backend: [PHP Laravel](https://laravel.com/) (API Services)
- Database: MySQL

## Installation and Setup

1. Clone the repository:

   ```bash
   git clone https://github.com/Mahmoud1499/Student-Managment-System/commits/main
   ```

2. Navigate to the project Front End directory and install dependency and run front end:

  ```bash
    cd Student-Managment-System/front-end
    npm install
    npm run serve
   ```

3. Navigate to the project Back End directory  and install dependency and run front end:

  ```bash
    cd Student-Managment-System/front-end
    composer install 
    php artisan migrate --seed
    php artisan serve

   ```

4. Access the application:
5. 
Open your web browser and visit <http://localhost:8080> to access the Students' Information Management System

Database Schema
The database schema for the project is as follows:

