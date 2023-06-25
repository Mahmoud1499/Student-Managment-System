<template>
  <footer class="footer">
    <div class="container">
      <p>Contact Info:</p>
      <ul>
        <li>Phone: {{ phone }}</li>
        <li>Email: {{ email }}</li>
        <!-- <li>Address: {{ address }}</li> -->
      </ul>
    </div>
  </footer>
</template>

<script>
export default {
  data() {
    return {
    name:'AppFooter',

      phone: '+20 1091619325',
      email: 'mahmoudmoh1499@gmail.com',
      // address: 'A, Country'
    };
  }
};
</script>

<style scoped>
/* Add any custom styles here */

.footer {
  background-color: #f8f9fa;
  padding: 20px 0;
  text-align: center;
}
</style>
