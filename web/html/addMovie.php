<?php
$pageName = 'Admin | Add Movie';
include "includes/header.php";

if(isset($_SESSION['authUser']) and $_SESSION['authUser']['role'] == 'Admin'):
?>
<div class="container">
    <?php
    $name = $_POST['name'] ?? '';
    $releaseDate = $_POST['releaseDate'] ?? '';
    $overview = $_POST['overview'] ?? '';
    $runtime = $_POST['runtime'] ?? null;
    $posterPath = $_POST['posterPath'] ?? '';
    $company = $_POST['company'] ?? null;
    $genre = $_POST['genre'] ?? [];

    $nameError = '';
    $releaseDateError = '';
    $formIsValid = true;
    if(isset($_POST['submit'])) {
        if (empty($name)) {
            $nameError = 'Name is required.';
            $formIsValid = false;
        }
        if (empty($releaseDate)) {
            $releaseDateError = 'Release Date is required.';
            $formIsValid = false;
        }
        // insert into database
        if (isset($_POST['submit']) && $formIsValid) {
            // get all form field/values
            $name = $_POST['name'] ?? '';
            $releaseDate = date_format(date_create($_POST['releaseDate']), 'Y-m-d') ?? '';
            $overview = $_POST['overview'] ?? '';
            $runtime = $_POST['runtime'] ?? null;
            $posterPath = $_POST['posterPath'] == '' ? 'images/updating.jpeg' : $_POST['overview'];
            $company = $_POST['company'] ?? null;
            $genre = $_POST['genre'] ?? [];

            // validation/sanitation
            $name = htmlspecialchars($name);
            $overview = strip_tags($overview, '<b><i>');
            $posterPath = htmlspecialchars($posterPath);

            // create a prepared statement to prevent SQL injection
            // use ? for value placeholders
            $query = "INSERT INTO `Movies` 
                        (`MovieID`, `MovieName`, `ReleaseDate`, `Overview`, `Runtime`, `PosterPath`, `CompanyID`) 
                      VALUES (NULL, ?, ?, ?, ?, ?, ?);";

            // create a prepared statement
            // this will check for syntax errors
            $stmt = mysqli_prepare($db, $query) or die('Error in query.');

            // binding the variables to the ? in the query
            // order needs to match the order in the query
            // i = integer, s = string, d = decimal, b = blob/binary
            mysqli_stmt_bind_param($stmt, 'sssisi', $name, $releaseDate, $overview, $runtime, $posterPath, $company);

            // execute query
            $result = mysqli_stmt_execute($stmt) or die('Error inserting record: ' . mysqli_error($db));

            // if record was added, get the id of the new movie
            if ($newId = mysqli_insert_id($db)) {
                // add new record in MovieGenre
                if (!empty($genre)) {
                    for ($i = 0; $i < count($genre); $i++) {
                        $genreAddQ = "INSERT INTO `MovieGenre` (`MovieID`, `GenreID`) 
                                VALUES (?, ?);";
                        $stmtGenre = mysqli_prepare($db, $genreAddQ) or die('Error in query.');
                        mysqli_stmt_bind_param($stmtGenre, 'ii', $newId, $genre[$i]);
                        // execute query
                        $resultGenre = mysqli_stmt_execute($stmtGenre) or die('Error inserting genre.');
                    }
                }
                // redirect back to the all movies page
                header('Location: movies.php');
            } else {
                echo "<div style='color:red'>SOMETHING WENT WRONG! " . mysqli_error($db) . " </div>";
            }

        }
    }elseif(isset($_POST['cancel'])){
        header('Location: movies.php');
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
                    <li>Add New Movie</li>
                </ol>
            </div>
        </div>
    </section>

    <div class="container add_page">
        <form method="post">
            <div class="form-outline form-white">
                <label class="form-label" for="name">Movie Name(*): <span style="color: red; font-weight: bold;"><?= $nameError ?></span></label>
                <input class="form-control" type="text" id="name" name="name" value="<?= $name ?>">
            </div>
            <div class="form-outline form-white">
                <label class="form-label" for="releaseDate">Release Date(*): <span style="color: red; font-weight: bold;"><?= $releaseDateError ?></span></label><br>
                <input class="form-control" type="date" id="releaseDate" name="releaseDate" value="<?= $releaseDate ?>">
            </div>
            <div  class="form-outline form-white">
                <label class="form-label" for="overview">Overview:</label><br>
                <input class="form-control" type="text" id="overview" name="overview" value="<?= $overview ?>">
            </div>
            <div  class="form-outline form-white">
                <label class="form-label" for="runtime">Runtime:</label><br>
                <input class="form-control" type="number" id="runtime" name="runtime" value="<?= $runtime ?>">
            </div>
            <div  class="form-outline form-white">
                <label class="form-label" for="posterPath">Poster Path:</label><br>
                <input class="form-control" type="text" id="posterPath" name="posterPath" value="<?= $posterPath ?>">
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
                        /* sticky form part
                        if($_POST['company'] == $row['CompanyID']){
                            echo 'selected';
                        }*/
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
                        <label class="btn btn-outline-secondary" for="<?= $row['Name'] ?>"><?= $row['Name'] ?>
                            <input type="checkbox" value="<?= $row['GenreID'] ?>" class="btn-check" name="genre[]" id="<?= $row['Name'] ?>" autocomplete="off">
                        </label>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <br>
            <p>
                <input type="submit" name="submit" value="Add Movie" class="btn btn-danger">
                <input type="submit" name="cancel" value="Cancel" class="btn btn-outline-warning">
            </p>
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
include "includes/footer.php";
?>

