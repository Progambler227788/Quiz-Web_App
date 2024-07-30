<?php
session_start();
$isLoggedIn = isset($_SESSION['userId']);
$username = $isLoggedIn ? $_SESSION['email'] : '';

// Check if username contains '@'
if (strpos($username, '@') !== false) {
  // Trim characters after '@', including '@' itself
  $username = strstr($username, '@', true); // Get the substring before '@'
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> About Page</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    
<!-- Header Section -->

<!--  Navigation bar -->
<!-- ms for margin start -->
<!-- mt for margin top -->
<!-- d-flex for display flex -->
<!-- primary for blue, secondary for grey color, info for light blue -->
<!-- fw for font weight-->

<?php 
include("navbar.php");
?>




<!-- Slider -->
<div id="namesMembers" class="carousel slide bg-dark mt-5">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#namesMembers" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#namesMembers" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#namesMembers" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#namesMembers" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="Images/man.png" class="d-block mx-auto" alt="Farman Ahmad">
      <div class="carousel-caption">
        <h5 class="text-dark">Farman Ahmad</h5>
      </div>
    </div>
    <div class="carousel-item">
      <img src="Images/man.png" class="d-block mx-auto" alt="talha">
      <div class="carousel-caption">
        <h5 class="text-dark">M. Talha Atif</h5>
      </div>
    </div>
    <div class="carousel-item">
      <img src="Images/woman.png" class="d-block mx-auto" alt="bhandal">
      <div class="carousel-caption">
        <h5 class="text-dark">Bhandal</h5>
      </div>
    </div>
    <div class="carousel-item">
      <img src="Images/man.png" class="d-block mx-auto" alt="abdullah">
      <div class="carousel-caption">
        <h5 class="text-dark">Abdullah CH</h5>
      </div>
    </div>
  </div>
  
  <!-- Left and right controls/icons -->
  <button class="carousel-control-prev" type="button" data-bs-target="#namesMembers" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#namesMembers" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!--  footer section of quiz web -->
<?php 
include("footer.php");
?>

<script  src="JS/script.js"></script>
<!-- Bootstrap JS -->
<script  src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.1/js/bootstrap.min.js"></script>

 
  </body>
</html>