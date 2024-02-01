<?php
$pageName = 'Admin | Delete Movie';
include "includes/header.php";

// get movie id
$mid = $_GET['id'] ?? 1;
// sanitize id
$mid = intval($mid);

if($mid !== 0){

// build query
$queryMovie = "SELECT * 
                FROM Movies
                WHERE MovieID = $mid";

// execute query
$resultMovie = @mysqli_query($db, $queryMovie) or die('Error loading movie.');

// get one record from the db
$movie = mysqli_fetch_array($resultMovie, MYSQLI_ASSOC);

if(!empty($movie)){

if(isset($_SESSION['authUser']) and $_SESSION['authUser']['role'] == 'Admin'):
?>

<div class="container mt-5 delete-page">
<?php
// update database
if (isset($_POST['delete'])) {
    // get all form fields/values
    $movieID = $_POST['movieID'] ?? '';

    // convert to prepared statements
    // update record
    $query = "DELETE FROM `Movies` 
                WHERE `Movies`.`MovieID` = ?
                LIMIT 1;";
    $queryMG = "DELETE FROM `MovieGenre` 
                WHERE `MovieGenre`.`MovieID` = ?;";
    $queryMC = "DELETE FROM `MovieCredits` 
                WHERE `MovieCredits`.`MovieID` = ?;";

    // create statement
    $stmt = mysqli_prepare($db, $query) or die('Error in query: ' . mysqli_error($db));
    $stmtMG = mysqli_prepare($db, $queryMG) or die('Error in query: ' . mysqli_error($db));
    //$stmtMC = mysqli_prepare($db, $queryMC) or die('Error in query: ' . mysqli_error($db));
    // bind the values
    mysqli_stmt_bind_param($stmt, 'i', $mid);
    mysqli_stmt_bind_param($stmtMG, 'i', $mid);
    //mysqli_stmt_bind_param($stmtMC, 'i', $mid);
    // execute query
    $result = mysqli_stmt_execute($stmt) or die("Error deleting movie: " . mysqli_error($db));
    $resultMG = mysqli_stmt_execute($stmtMG) or die("Error deleting movie genre: " . mysqli_error($db));
    //$resultMC = mysqli_stmt_execute($stmtMC) or die("Error deleting movie credits: " . mysqli_error($db));

    // if record was deleted, redirect to movies page
    // mysqli_affected_rows will return how many records were deleted.
    if (mysqli_affected_rows($db)) {
        // redirect back to the city page
        header('Location: movies.php');
        die();
    } else {
        echo mysqli_error($db);
        echo "<div style='color:red'>SOMETHING WENT WRONG! " . mysqli_error($db) . " </div>";
    }
} elseif (isset($_POST['cancel'])) {
    // redirect back to the movies page
    header('Location: movie-info.php?id=' . $mid);
    die();
}
?>

    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2><?= $pageName ?? 'Default Name' ?></h2>
                <ol>
                    <li><a href="index.php" style="text-decoration: none; color: #E4D806;">Home</a></li>
                    <li><a href="movies.php" style="text-decoration: none; color: #E4D806;">All Movies</a></li>
                    <li><a href="movie-info.php?id=<?= $mid ?>" style="text-decoration: none; color: #E4D806;">Movie Details</a></li>
                    <li>Delete Movie</li>
                </ol>
            </div>
        </div>
    </section>
    <form method="post">
        <p>
            Are you sure you want to delete "<?= $movie['MovieName'] ?>"?
        </p>
        <p>
            <input type="submit" name="cancel" value="No" class="btn btn-secondary">
            <input type="submit" name="delete" value="Yes" class="btn btn-danger">
        </p>
    </form>
<div>
<?php else: ?>
<div class="container">
    <h1>Admin Area</h1>
    <div class="alert alert-danger">Access denied. Please <a href="login.php">login</a> as an admin.</div>
</div>
<?php
endif;
}else{
    echo "<div class='container mt-5'>
            <h1>Page not found</h1>
          </div>";
}
}else{
    echo "<div class='container mt-5'>
            <h1>Page not found</h1>
          </div>";
}

include "includes/footer.php";
?>

