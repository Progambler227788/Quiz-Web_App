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
    <title>Quiz Web</title>
    <link rel="icon" type="image/icon" href="">
    <link rel="stylesheet" href="CSS/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

<!-- Textual area of home screen -->

    <section class="py-5 bg-light">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6">
              <h1 id="discover" class="display-4 fw-bold text-dark">Discover<br>new concepts<br>with each question</h1>
              <button id="start" class="btn btn-outline-dark mt-4">Start Solving!</button>
            </div>
            <div class="col-md-6">
              <!-- Idea image -->
              <img src="Images/ideas.png" alt="Ideas Image" class="img-fluid">
            </div>
          </div>
        </div>
      </section>

<?php 
include("footer.php");
?>

<!-- JS of page -->
<script  src="JS/script.js"></script>
<!-- Bootstrap JS -->
<script  src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.1/js/bootstrap.min.js"></script>
 
  </body>
</html>