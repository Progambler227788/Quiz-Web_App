
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
<nav class="navbar navbar-expand-lg bg-body-tertiary mt-5 ms-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <p id="quiz" class="mb-0 display-5">Quiz</p>
            <p id="zone" class="mb-0 ms-1 display-5 text-info">Zone</p>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navigation items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link item-nav" href="category.html">Quiz</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link item-nav" href="history.php">History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link item-nav" href="leaderboard.php">Leaderboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link item-nav" href="about.php">About Us</a>
                </li>
            <!-- Here : in below is opening tag of if and ? ending, in this way, I can write html without echo -->
            <?php if ($isLoggedIn): ?>
            <li class="nav-item">
          
            <!-- Profile dropdown menu -->
            <div class="dropdown ms-auto">
                <a href="#" class="dropdown-toggle" id="profileDropdown" role="button" aria-expanded="false" style="text-decoration: none;" >
                  <img src="Images/man.png" alt="Profile Picture" class="rounded-circle" style="width: 70px;">
                  <span class="ms-2"><?php  echo '<span style="font-size: 1.25rem; color: #000; font-weight: bold;">' . htmlspecialchars($username) . '</span>'; ?> </span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="profileDropdown" id="dropdownMenu">
                    <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
            </li>
            <?php else: ?>


            <li class="nav-item">
            <button class="btn btn-outline-info ms-5 btn-lg me-4" onclick="moveToLogin()">Login</button>
            </li>
            <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

</body>
</html>