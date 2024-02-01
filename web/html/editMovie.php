<?php
$pageName = 'Admin | Edit Movie';
include "includes/header.php";

// generate a token if one doesn't exist
// to help prevent CSRF (Cross Site Request Forgery)
if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = uniqid();
}

// get movie ID
$mid = $_GET['id'] ?? 1;
// sanitize id
$mid = intval($mid);

if($mid !== 0){

$query = "SELECT m.MovieID, m.MovieName, m.ReleaseDate, m.Overview, GROUP_CONCAT(DISTINCT g.Name SEPARATOR ', ') AS Category, 
                    m.CompanyID, m.Runtime,
                    m.PosterPath
            FROM Movies m
            LEFT JOIN MovieGenre mg
            ON m.MovieID = mg.MovieID
            LEFT JOIN Genres g
            ON mg.GenreID = g.GenreID
            GROUP BY m.MovieName
            HAVING m.MovieID = $mid";

$result = @mysqli_query($db, $query) or die('Error loading details: ' . mysqli_error($db));
$movie = mysqli_fetch_array($result, MYSQLI_ASSOC);

if(!empty($movie)){

$name = $_POST['name'] ?? '';
$releaseDate = $_POST['releaseDate'] ?? '';
$overview = $_POST['overview'] ?? '';
$runtime = $_POST['runtime'] ?? '';
$posterPath = $_POST['posterPath'] ?? '';
$company = $_POST['company'] ?? '';
$genre = $_POST['genre'] ?? [];

$nameError = '';
$releaseDateError = '';
$formIsValid = true;
if(isset($_POST['update'])) {
    if(empty($name)){
        $nameError = 'Name is required.';
        $formIsValid = false;
    }
    if(empty($releaseDate)){
        $releaseDateError = 'Release Date is required.';
        $formIsValid = false;
    }
}

if(isset($_SESSION['authUser']) and $_SESSION['authUser']['role'] == 'Admin'):
?>
<div class="container">
    <?php
    // insert into database
    if(isset($_POST['update']) && $formIsValid){
        // validate CSRF token
        if($_SESSION['csrf_token'] !== $_POST['csrf_token']){
            die('Invalid token.');
        }

        // get all form field/values
        $name = $_POST['name'] ?? '';
        $releaseDate = date_format(date_create($_POST['releaseDate']), 'Y-m-d') ?? '';
        $overview = $_POST['overview'] ?? '';
        $runtime = $_POST['runtime'] ?? '';
        $posterPath = $_POST['posterPath'] ?? '';
        $company = $_POST['company'] ?? '';
        $genre = $_POST['genre'] ?? [];

        // validation/sanitation
        // escape HTML to prevent XSS (Cross Site Scripting) attack
        $name = htmlspecialchars($name); // generally... this happens at output
        // allow certain tags
        $overview = strip_tags($overview, '<b><i>');
        // if you allow ANY HTML tags, you have to strip out js event attributes
        $overview = str_replace(['onmouseover', 'onmouseout', 'onmousein', 'on...'], 'xxx', $overview);
        $posterPath = htmlspecialchars($posterPath);

        // update record
        $query = "UPDATE `Movies` 
                    SET `MovieName` = ?,
                        `ReleaseDate` = ?,
                        `Overview` = ?,
                        `Runtime` = ?,
                        `PosterPath` = ?,
                        `CompanyID` = ?
                    WHERE `Movies`.`MovieID` = ?
                    LIMIT 1";

        // create statement
        $stmt = mysqli_prepare($db, $query) or die('Error in query: ' . mysqli_error($db));
        // bind the values
        mysqli_stmt_bind_param($stmt, 'sssisii', $name, $releaseDate, $overview, $runtime, $posterPath, $company, $mid);

        // execute query
        $result = mysqli_stmt_execute($stmt) or die("Error updating movie.");

        if(!empty($genre)){
            $queryDeleteCurrentMovieGenre = "DELETE FROM `MovieGenre` 
                            WHERE `MovieGenre`.`MovieID` = ?;";

            // delete first
            $stmtDeleteMovieGenre = mysqli_prepare($db, $queryDeleteCurrentMovieGenre) or die('Error in query: ' . mysqli_error($db));
            mysqli_stmt_bind_param($stmtDeleteMovieGenre, 'i', $mid);
            $resultDeleteMovieGenre = mysqli_stmt_execute($stmtDeleteMovieGenre) or die("Error deleting movie genre.");

            for($i = 0; $i < count($genre); $i++) {
                $queryAddMovieGenre = "INSERT INTO `MovieGenre` (`MovieID`, `GenreID`) 
                                VALUES (?, ?);";
                // add later
                $stmtAddMovieGenre = mysqli_prepare($db, $queryAddMovieGenre) or die('Error in query: ' . mysqli_error($db));
                mysqli_stmt_bind_param($stmtAddMovieGenre, 'ii', $mid, $genre[$i]);
                // execute query
                $resultAddMovieGenre = mysqli_stmt_execute($stmtAddMovieGenre) or die("Error adding movie genre.");
            }
        }
        // if record was updated, redirect to movie page
        // mysqli_affected_rows will return how many records were changed.
        if(mysqli_affected_rows($db)){
            // redirect back to the movie page
            header('Location: movie-info.php?id=' . $mid);
            die();
        }else{
            echo "<div style='color:red'>SOMETHING WENT WRONG! " . mysqli_error($db)." </div>";
        }


    }elseif(isset($_POST['cancel'])){
        // redirect back to the city page
        header('Location: movie-info.php?id='.$mid);
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
                    <li>Edit Movie</li>
                </ol>
            </div>
        </div>
    </section>

    <div class="container add_page">
        <form method="post">
            <div class="form-outline form-white">
                <label class="form-label" for="name">Movie Name(*): <span style="color: red; font-weight: bold;"><?= $nameError ?></label>
                <input class="form-control" type="text" id="name" name="name" value="<?= $movie['MovieName'] ?? '' ?>">
            </div>
            <div class="form-outline form-white">
                <label class="form-label" for="releaseDate">Release Date(*): <span style="color: red; font-weight: bold;"><?= $nameError ?></label><br>
                <input class="form-control" type="text" id="releaseDate" name="releaseDate" value="<?= date_format(date_create($movie['ReleaseDate']), 'm/d/Y') ?? '' ?>">
            </div>
            <div  class="form-outline form-white">
                <label class="form-label" for="overview">Overview:</label><br>
                <input class="form-control" type="text" id="overview" name="overview" value="<?= $movie['Overview'] ?? '' ?>">
            </div>
            <div  class="form-outline form-white">
                <label class="form-label" for="runtime">Runtime:</label><br>
                <input class="form-control" type="number" id="runtime" name="runtime" value="<?= $movie['Runtime'] ?? '' ?>">
            </div>
            <div  class="form-outline form-white">
                <label class="form-label" for="posterPath">Poster Path:</label><br>
                <input class="form-control" type="text" id="posterPath" name="posterPath" value="<?= $movie['PosterPath'] ?? '' ?>">
            </div>
            <div class="form-outline form-white">
                <label class="form-label" for="company">Production Company: </label><br>
                <select class="form-control" id="company" name="company">
                    <?php
                    $companyQ = "SELECT CompanyID, Name FROM `ProductionCompanies`";
                    $companyR = mysqli_query($db, $companyQ) or die("Error loading production companies.");

                    // loop through the results
                    while($row = mysqli_fetch_array($companyR, MYSQLI_ASSOC)){
                        echo "<option value='{$row['CompanyID']}' ";
                        // sticky form part
                        if($movie['CompanyID'] == $row['CompanyID']){
                            echo 'selected';
                        }
                        echo ">{$row['Name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label class="form-label">Genres</label><br>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <?php
                    $genreQ = "SELECT GenreID, Name FROM `Genres`";
                    $genreR = mysqli_query($db, $genreQ) or die("Error loading production companies.");

                    // loop through the results
                    while($row = mysqli_fetch_array($genreR, MYSQLI_ASSOC)){
                    ?>
                        <label class="btn btn-outline-secondary
                            <?php
                            if(strpos($movie['Category'], $row['Name']) !== false){
                                echo 'active';
                            }
                            ?>" for="<?= $row['Name'] ?>"><?= $row['Name'] ?>
                            <input type="checkbox" value="<?= $row['GenreID'] ?>" class="btn-check" name="genre[]" id="<?= $row['Name'] ?>"
                                <?php
                                // sticky form part
                                if(strpos($movie['Category'], $row['Name']) !== false){
                                    echo 'checked';
                                }
                                ?>
                            >
                        </label>
                    <?php
                    }
                    ?>
                </div>
            </div><br>
            <div>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="submit" name="update" value="Update Movie" class="btn btn-danger">
                <input type="submit" name="cancel" value="Cancel" class="btn btn-outline-warning">
            </div>
        </form>
    </div>
</div>

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

