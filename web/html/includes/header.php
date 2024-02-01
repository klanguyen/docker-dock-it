<?php
// start the session
session_name('nnguyen1_final');
session_start();
// to delete everything in the session
//session_destroy();

// remember, it's relative to the note.php (or any file that includes this file)
require_once "includes/database.php";
require_once "includes/functions.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/4ee835f775.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <title>Funflix | <?= $pageName ?? 'Default' ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg p-3 text-white">
    <div class="container-fluid">
        <!-- logo -->
        <a href="index.php" class="navbar-brand d-flex align-items-center mb-2 mb-lg-0 text-decoration-none" style="color: #E4D806;">
            <i class="bi bi-camera-reels-fill"></i> Funflix
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- menu -->
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link px-2 text-white">Home</a>
                </li>
                <li class="nav-item">
                    <a href="movies.php" class="nav-link px-2 text-white">Movies</a>
                </li>
                <!--<li class="nav-item">
                    <a href="#" class="nav-link px-2 text-white">Actors</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-2 text-white">Watchlist</a>
                </li>-->
            </ul>
            <!-- search form -->
            <!--<form class="d-flex col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="text" name="searchKey" class="form-control form-control-dark me-2" placeholder="Keyword">
                <input type="submit" name="search" class="btn login_btn" value="Search">
            </form>-->
            <div class="text-end">
                <?php
                if(isset($_SESSION['authUser']) && $_SESSION['authUser']){
                    echo 'Welcome ' . $_SESSION['authUser']['email'] .
                        ' (<a class="btn btn-outline-warning me-2" href="login.php?logout"> Logout </a>)';
                }else{
                    echo '<a class="btn btn-warning me-2" href="login.php">Login</a>';
                }
                ?>
            </div>
        </div>
    </div>
</nav>

