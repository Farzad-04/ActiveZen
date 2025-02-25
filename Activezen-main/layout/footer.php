<footer class="py-5" style="background-color:#eef0f2">
  <!-- Footer section with padding of 5 and a light gray background -->
  
  <div class="container">
    <!-- Container to center and structure the content within the footer -->
    
    <div class="row">
      <!-- Row for organizing content in a responsive grid layout -->
      
      <div class="col text-center">
        <!-- Single column centered content within the row -->
        
        <!-- Logo displayed at the top of the footer -->
        <img class="mb-2" src="images/Logo.jpg" alt="Company Logo" width="50" height="50">
        
        <!-- Copyright text with dynamic year -->
        <small class="d-block text-muted">&copy; 2024-<?= date("Y") ?></small>
        <!-- Dynamically displays the current year using PHP -->
      </div>
    </div>
  </div>
</footer>

<!-- Bootstrap JavaScript Bundle for enabling interactive features -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
  crossorigin="anonymous">
</script>
