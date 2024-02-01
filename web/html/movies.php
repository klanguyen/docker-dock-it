<?php
$pageName = 'All Movies';
include 'includes/header.php';
$searchKey = $_GET['searchKey'] ?? '';
$searchKey = strip_tags($searchKey);
$searchString = "'%$searchKey%'";
$sortBy = $_GET['sortBy'] ?? 'MovieName ASC';
if(isset($_SESSION['authUser']) AND $_SESSION['authUser']):

// only do validation if the user submitted the form
$searchError = '';
$formIsValid = true;
if(isset($_GET['search'])) {
    if(empty($searchKey)){
        $searchError = "Search key is required.";
        $formIsValid = false;
    }
}

$movieAZChecked = $sortBy == "MovieName ASC" ? 'selected' : '';
$movieZAChecked = $sortBy == "MovieName DESC" ? 'selected' : '';
$movieLatestChecked = $sortBy == "ReleaseDate DESC" ? 'selected' : '';
$movieOldestChecked = $sortBy == "ReleaseDate ASC" ? 'selected' : '';

// sanitize sort and direction
// check if the sort/dir is in an acceptable list of values
$sortBy = in_array($sortBy, ['MovieName ASC', 'MovieName DESC', 'ReleaseDate ASC', 'ReleaseDate DESC']) ? $sortBy : 'MovieName ASC';
?>
<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2><?= $pageName ?? 'Default Name' ?></h2>
            <ol>
                <li><a href="index.php" style="text-decoration: none; color: #E4D806;">Home</a></li>
                <li>All Movies</li>
            </ol>
        </div>
    </div>
</section>
<div class="container mt-5">
    <form method="get">
        <div class="container row">
            <div class="col input-group justify-content-start">
                <div class="form-outline">
                    <select class="form-control" id="sortBy" name="sortBy">
                        <option value="MovieName ASC" <?= $movieAZChecked ?>>Sort by Title (A-Z)</option>
                        <option value="MovieName DESC" <?= $movieZAChecked ?>>Sort by Title (Z-A)</option>
                        <option value="ReleaseDate DESC" <?= $movieLatestChecked ?>>Sort by Latest</option>
                        <option value="ReleaseDate ASC" <?= $movieOldestChecked ?>>Sort by Oldest</option>
                    </select>
                </div>
                <input type="submit" name="sort" value="Sort" class="btn btn-warning">
            </div>
            <div class="col input-group justify-content-end">
                <div><span style="color: red; font-weight: bold;"><?= $searchError ?></span><br></div>
                <div class="form-outline">
                    <input id="searchKey" value="<?= $searchKey ?>" name="searchKey" type="text" class="form-control" placeholder="Type in keyword..." />
                </div>
                <input type="submit" name="search" value="Search" class="btn btn-warning">
            </div>
        </div>
    </form><br>
    <?php if($_SESSION['authUser']['role'] == 'Admin'): ?>
    <div class="d-flex justify-content-end">
        <a href="addMovie.php" class="btn btn-danger">Add Movie</a>"
    </div>
    <?php endif; ?>
    <?php
    // number of record per page
    $display = 12;

    $query = "SELECT MovieID, MovieName, YEAR(ReleaseDate) AS ReleaseYear, Runtime, PosterPath 
                    FROM `Movies`
                    ORDER BY $sortBy";

    if(isset($_GET['search']) && $formIsValid) {
        $searchKey = strip_tags($searchKey);
        $query = "SELECT MovieID, MovieName, YEAR(ReleaseDate) AS ReleaseYear, Runtime, PosterPath 
                    FROM `Movies`
                    WHERE MovieName LIKE $searchString
                    ORDER BY $sortBy";
    }

    // run the query
    $result = mysqli_query($db, $query) or die('Error loading movies: '.mysqli_error($db));

    // get numbers of rows
    $count = mysqli_num_rows($result);
    if($count == 0){
        echo '<h4 class="text-white">No movies found.</h4>';
    }

    // determine how many pages there are
    // Count the number of records (if not done yet)
    // Calculate the number of pages
    if($count > $display){ // More than 1 page
        $pages = ceil($count/$display);
    }else{
        $pages = 1;
    }

    // determine where in the database to start returning results
    $current_page = $_GET['page'] ?? 1;
    $current_page = intval($current_page);
    if($current_page !== 0){
    $start = ($current_page - 1)*$display;

    // define query
    $q = "SELECT m.MovieID, m.MovieName, YEAR(m.ReleaseDate) AS ReleaseYear, m.Runtime, m.PosterPath,
                    GROUP_CONCAT(DISTINCT g.Name SEPARATOR ' | ') AS Category
                    FROM `Movies` m
                    LEFT JOIN MovieGenre mg ON mg.MovieID = m.MovieID
                    LEFT JOIN Genres g ON mg.GenreID = g.GenreID
                    GROUP BY m.MovieName
                    ORDER BY m.$sortBy
                    LIMIT $start, $display;";

    if(isset($_GET['sortBy'])){
        $q = "SELECT m.MovieID, m.MovieName, YEAR(m.ReleaseDate) AS ReleaseYear, m.Runtime, m.PosterPath,
                    GROUP_CONCAT(DISTINCT g.Name SEPARATOR ' | ') AS Category
                    FROM `Movies` m
                    LEFT JOIN MovieGenre mg ON mg.MovieID = m.MovieID
                    LEFT JOIN Genres g ON mg.GenreID = g.GenreID
                    GROUP BY m.MovieName
                    ORDER BY m.$sortBy
                    LIMIT $start, $display;";
    }

    if(isset($_GET['search']) && $formIsValid) {
        $searchKey = strip_tags($searchKey);
        $q = "SELECT m.MovieID, m.MovieName, YEAR(m.ReleaseDate) AS ReleaseYear, m.Runtime, m.PosterPath,
                    GROUP_CONCAT(DISTINCT g.Name SEPARATOR ' | ') AS Category
                    FROM `Movies` m
                    LEFT JOIN MovieGenre mg ON mg.MovieID = m.MovieID
                    LEFT JOIN Genres g ON mg.GenreID = g.GenreID
                    WHERE m.MovieName LIKE $searchString
                    GROUP BY m.MovieName
                    ORDER BY m.$sortBy
                    LIMIT $start, $display;";
    }

    $r = @mysqli_query($db, $q) or die('Error in query.');
    ?>
    <div class="row justify-content-start">
        <?php
        // loop through the results
        while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
        ?>
        <div class="card movie_card">
            <img src="<?= $row['PosterPath'] ?>"
                 class="card-img-top" alt="...">
            <div class="card-body">
                <a href="movie-info.php?id=<?= $row['MovieID'] ?>"><i class="fas fa-play play_button" data-toggle="tooltip" data-placement="bottom" title="Get Info"></i></a>
                <h5 class="card-title"><a href="movie-info.php?id=<?= $row['MovieID'] ?>"><?= $row['MovieName'] ?> (<?= $row['ReleaseYear'] ?>)</a></h5>
                <span class="movie_info"><i class="far fa-clock" style="color: #E4D806"></i> <?= convertRuntime($row['Runtime']) ?></span>
                <?php if(!empty($row['Category'])): ?>
                <p class="movie_info">
                    <i class="fas fa-list-ul" style="color: #E4D806"></i> <?= $row['Category'] ?>
                </p>
                <?php endif; ?>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<!-- Pagination -->
<nav class="justify-content-center" aria-label="pagination">
    <ul class="pagination justify-content-center" id="pagination" style="text-decoration: none;">

        <?php
        // Make the links to other page, if necessary
        if($pages > 1){

            // If it's not the first page, make a Previous link:
            if($current_page != 1) {
                echo "<li class='page-item'>";
                echo "  <a class='page-link'  style='color: #17161D' href='?sortBy=$sortBy&searchKey=$searchKey&page=".($current_page - 1)."'>Previous</a>";
                echo "</li>";
            }

            // Make all the numbered pages:
            for($i = 1; $i <= $pages; $i++){
                if($i != $current_page){
                    echo "<li class='page-item'>";
                    echo "<a class='page-link'  style='color: #17161D' href='?sortBy=$sortBy&searchKey=$searchKey&page=$i'>$i</a>";
                    echo "</li>";
                }else{
                    echo "<li class='page-item disabled'>";
                    echo "<a class='page-link' href=''>$i</a>";
                    echo "</li>";
                }
            }

            // If it's not the last page, make a Next button:
            if($current_page != $pages){
                echo "<li class='page-item'>";
                echo "<a class='page-link' style='color: #17161D' href='?sortBy=$sortBy&searchKey=$searchKey&page=".($current_page + 1)."'>Next</a>";
                echo "</li>";
            }
        }
        }else{
            echo "<div class='container mt-5'>
            <h1>Page not found</h1>
          </div>";
        }
        ?>

    </ul>
</nav> <!-- End pagination -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<?php else: ?>
    <div class="container">
        <h1>Access Denied.</h1>
        <div class="alert alert-danger">Please <a href="login.php">login</a>.</div>
    </div>
<?php
endif;
include 'includes/footer.php';
?>


