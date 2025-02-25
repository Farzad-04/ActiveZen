<?php  
include "layout/header.php";
if (!isset($_SESSION["User_id"])) {
    header("location: /Data_Management_Project/login.php");
    exit;
}
?>


<div class="container mt-5">
  <!-- Page Title -->
  <h1 class="text-center">Exercise Tutorials</h1>
  <p class="text-center">Learn how to perform exercises correctly and safely to maximize your results.</p>


  <!-- Exercise 1: Push-Ups -->
  <section class="mt-5 row align-items-center">
    <div class="col-md-6">
      <h2>Push-Ups</h2>
      <p><strong>Targeted Muscles:</strong> Chest, triceps, shoulders, and core.</p>
      <p><strong>Steps:</strong></p>
      <ol>
        <li>Start in a high plank position with your hands slightly wider than shoulder-width apart.</li>
        <li>Keep your back straight, core tight, and body aligned from head to heels.</li>
        <li>Lower your chest to the floor by bending your elbows, keeping them close to your body.</li>
        <li>Push back up to the starting position.</li>
        <li>Repeat for 10-15 repetitions.</li>
      </ol>
      <p><strong>Tips:</strong> Avoid sagging your hips or arching your back to maintain proper form.</p>
    </div>
    <div class="col-md-6 text-center">
      <img src="images/pushups.jpg" alt="Push-Ups" class="img-fluid rounded">
    </div>
  </section>


  <!-- Exercise 2: Squats -->
  <section class="mt-5 row align-items-center">
    <div class="col-md-6">
      <h2>Squats</h2>
      <p><strong>Targeted Muscles:</strong> Quadriceps, hamstrings, glutes, and core.</p>
      <p><strong>Steps:</strong></p>
      <ol>
        <li>Stand with your feet shoulder-width apart, toes slightly pointed outward.</li>
        <li>Engage your core and lower your body by bending your knees and pushing your hips back.</li>
        <li>Go as low as you can while keeping your back straight and knees aligned with your toes.</li>
        <li>Push through your heels to return to the starting position.</li>
        <li>Repeat for 12-15 repetitions.</li>
      </ol>
      <p><strong>Tips:</strong> Keep your chest up and avoid letting your knees collapse inward.</p>
    </div>
    <div class="col-md-6 text-center">
      <img src="images/squats.jpg" alt="Squats" class="img-fluid rounded">
    </div>
  </section>


  <!-- Exercise 3: Plank -->
  <section class="mt-5 row align-items-center">
    <div class="col-md-6">
      <h2>Plank</h2>
      <p><strong>Targeted Muscles:</strong> Core, shoulders, and back.</p>
      <p><strong>Steps:</strong></p>
      <ol>
        <li>Start in a forearm plank position with your elbows directly under your shoulders.</li>
        <li>Keep your body in a straight line from head to heels.</li>
        <li>Engage your core and hold the position for 20-60 seconds.</li>
        <li>Rest and repeat 2-3 times.</li>
      </ol>
      <p><strong>Tips:</strong> Avoid sagging your hips or raising them too high to maintain proper alignment.</p>
    </div>
    <div class="col-md-6 text-center">
      <img src="images/planks.png" alt="Plank" class="img-fluid rounded">
    </div>
  </section>


  <!-- Exercise 4: Deadlifts -->
  <section class="mt-5 row align-items-center">
    <div class="col-md-6">
      <h2>Deadlifts</h2>
      <p><strong>Targeted Muscles:</strong> Hamstrings, glutes, lower back, and core.</p>
      <p><strong>Steps:</strong></p>
      <ol>
        <li>Stand with your feet hip-width apart, barbell in front of you.</li>
        <li>Hinge at your hips and bend your knees to grab the barbell with both hands.</li>
        <li>Keep your back straight and shoulders retracted.</li>
        <li>Push through your heels and lift the barbell while straightening your legs and hips.</li>
        <li>Lower the barbell slowly back to the starting position.</li>
        <li>Repeat for 8-10 repetitions.</li>
      </ol>
      <p><strong>Tips:</strong> Avoid rounding your back to prevent injury.</p>
    </div>
    <div class="col-md-6 text-center">
      <img src="images/deadlift.png" alt="Deadlifts" class="img-fluid rounded">
    </div>
  </section>


  <!-- Exercise 5: Bicep Curls -->
  <section class="mt-5 row align-items-center">
    <div class="col-md-6">
      <h2>Bicep Curls</h2>
      <p><strong>Targeted Muscles:</strong> Biceps.</p>
      <p><strong>Steps:</strong></p>
      <ol>
        <li>Hold a dumbbell in each hand with your palms facing forward.</li>
        <li>Keep your elbows close to your torso and curl the weights up to shoulder height.</li>
        <li>Slowly lower the weights back to the starting position.</li>
        <li>Repeat for 12-15 repetitions.</li>
      </ol>
      <p><strong>Tips:</strong> Avoid swinging the weights for proper isolation.</p>
    </div>
    <div class="col-md-6 text-center">
      <img src="images/bicepcurls.jpg" alt="Bicep Curls" class="img-fluid rounded">
    </div>
  </section>


  <!-- Exercise 6: Pull-Ups -->
  <section class="mt-5 row align-items-center">
    <div class="col-md-6">
      <h2>Pull-Ups</h2>
      <p><strong>Targeted Muscles:</strong> Back, biceps, and shoulders.</p>
      <p><strong>Steps:</strong></p>
      <ol>
        <li>Grab a pull-up bar with an overhand grip, hands slightly wider than shoulder-width apart.</li>
        <li>Engage your core and pull your chest toward the bar.</li>
        <li>Lower yourself back to the starting position in a controlled motion.</li>
        <li>Repeat for 8-10 repetitions.</li>
      </ol>
      <p><strong>Tips:</strong> Avoid swinging your body; focus on controlled movements.</p>
    </div>
    <div class="col-md-6 text-center">
      <img src="images/pullups.png" alt="Pull-Ups" class="img-fluid rounded">
    </div>
  </section>


  <!-- Exercise 7: Tricep Dips -->
  <section class="mt-5 row align-items-center">
    <div class="col-md-6">
      <h2>Tricep Dips</h2>
      <p><strong>Targeted Muscles:</strong> Triceps and shoulders.</p>
      <p><strong>Steps:</strong></p>
      <ol>
        <li>Position your hands on the edge of a sturdy surface like a chair or bench.</li>
        <li>Extend your legs out straight or bend them slightly.</li>
        <li>Lower your body by bending your elbows until your upper arms are parallel to the ground.</li>
        <li>Push back up to the starting position.</li>
        <li>Repeat for 10-12 repetitions.</li>
      </ol>
      <p><strong>Tips:</strong> Avoid shrugging your shoulders; keep your movements controlled.</p>
    </div>
    <div class="col-md-6 text-center">
      <img src="images/tricepdips.png" alt="Tricep Dips" class="img-fluid rounded">
    </div>
  </section>


  <!-- Exercise 8: Side Plank -->
  <section class="mt-5 row align-items-center">
    <div class="col-md-6">
      <h2>Side Plank</h2>
      <p><strong>Targeted Muscles:</strong> Obliques, core, and shoulders.</p>
      <p><strong>Steps:</strong></p>
      <ol>
        <li>Lie on your side with your legs straight and stacked on top of each other.</li>
        <li>Place your elbow directly under your shoulder.</li>
        <li>Lift your hips off the ground and hold the position for 20-40 seconds.</li>
        <li>Switch sides and repeat.</li>
      </ol>
      <p><strong>Tips:</strong> Keep your body in a straight line and avoid letting your hips sag.</p>
    </div>
    <div class="col-md-6 text-center">
    <img src="images/sideplank.png" alt="Side Plank" class="img-fluid rounded">
</div>
</section>


