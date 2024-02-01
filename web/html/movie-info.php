<?php
$pageName = 'Movie Details';
include 'includes/header.php';

// get movie ID
$mid = $_GET['id'] ?? 1;
// sanitize id
$mid = intval($mid);

if($mid !== 0){

// query
$query = "SELECT m.MovieID, m.MovieName, m.ReleaseDate, m.Overview, GROUP_CONCAT(DISTINCT g.Name SEPARATOR ', ') AS Category, 
                    c.Name AS Company, m.Runtime,
                    m.PosterPath
            FROM Movies m
            LEFT JOIN MovieGenre mg
            ON m.MovieID = mg.MovieID
            LEFT JOIN Genres g
            ON mg.GenreID = g.GenreID
            LEFT JOIN ProductionCompanies c
            ON c.CompanyID = m.CompanyID
            GROUP BY m.MovieName
            HAVING m.MovieID = $mid";
$crewQ = "SELECT m.MovieName, CONCAT(p.FirstName, ' ', p.LastName) AS FullName, r.RoleName, cr.CharacterName
            FROM Movies m 
            LEFT JOIN MovieCredits cr ON m.MovieID = cr.MovieID
            LEFT JOIN People p ON cr.PersonID = p.PersonID 
            LEFT JOIN Roles r ON cr.RoleID = r.RoleID
            WHERE RoleName not like 'Actor' AND m.MovieID = $mid";
$castQ = "SELECT m.MovieName, CONCAT(p.FirstName, ' ', p.LastName) AS FullName, r.RoleName, cr.CharacterName
            FROM Movies m 
            LEFT JOIN MovieCredits cr ON m.MovieID = cr.MovieID
            LEFT JOIN People p ON cr.PersonID = p.PersonID 
            LEFT JOIN Roles r ON cr.RoleID = r.RoleID
            WHERE RoleName = 'Actor' AND m.MovieID = $mid";

$result = @mysqli_query($db, $query) or die('Error loading details.');
$crewR = @mysqli_query($db, $crewQ) or die('Error loading crew.');
$castR = @mysqli_query($db, $castQ) or die('Error loading cast.');
$movie = mysqli_fetch_array($result, MYSQLI_ASSOC);

if(!empty($movie)){

if(isset($_SESSION['authUser']) and $_SESSION['authUser']):
?>
<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2><?= $pageName ?? 'Default Name' ?></h2>
            <ol>
                <li><a href="index.php" style="text-decoration: none; color: #E4D806;">Home</a></li>
                <li><a href="movies.php" style="text-decoration: none; color: #E4D806;">All Movies</a></li>
                <li>Movie Details</li>
            </ol>
        </div>
    </div>
</section>

<div class="container mt-5 movie_page">
    <div class="row">
        <div class="col-sm-4">
            <img width="90%" height="90%" src="<?= $movie['PosterPath'] ?>">
        </div>
        <div class="col-sm-7">
            <h1><?= $movie['MovieName'] ?></h1>
            <?php if($_SESSION['authUser']['role'] == 'Admin'): ?>
            <form method="get">
                <a href="editMovie.php?id=<?= $mid ?>" class="btn btn-outline-warning"><i class="far fa-edit"></i> Edit</a>
                <a href="deleteMovie.php?id=<?= $mid ?>" class="btn btn-outline-danger">
                    <i class="far fa-trash-alt"></i> Delete
                </a>
                <!--<a href="#deleteConfirmation" class="btn btn-outline-danger trigger-btn" data-toggle="modal">
                    <i class="far fa-trash-alt"></i> Delete
                </a>-->
            </form><br>
            <!-- Modal -->
            <!--<div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Are you sure?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>-->
            <?php endif; ?>
            <p><strong class="info_header">Release Date: </strong><?= date_format(date_create($movie['ReleaseDate']), 'F d, Y') ?></p>
            <?php
            if(!empty($movie['Category'])){
                echo "<p><strong class='info_header'>Category: </strong>{$movie['Category']}</p>";
            }
            ?>
            <p><strong class="info_header">Runtime: </strong><?= convertRuntime($movie['Runtime']) ?></p>
            <?php
            if(!empty($movie['Company'])){
                echo "<p><strong class='info_header'>Production Company: </strong>{$movie['Company']}</p>";
            }
            ?>
            <h5 class="info_header">Overview</h5>
            <p class="text-start">
                <?= $movie['Overview'] ?>
            </p>
        </div>
    </div>

    <div class="container">
        <h4 class="info_header">Cast and Crew</h4>
        <div class="container text-start">
            <strong class="info_header">Crew</strong>
            <ul>
                <?php
                while($row = mysqli_fetch_array($crewR, MYSQLI_ASSOC)){
                    echo "<li>{$row['RoleName']}: {$row['FullName']}</li>";
                }
                ?>
            </ul>
        </div>
        <div class="container text-start">
            <strong class="info_header">Cast</strong>
            <ul>
                <?php
                while($row = mysqli_fetch_array($castR, MYSQLI_ASSOC)){
                    ?>
                    <li><?= $row['FullName']." AS ".$row['CharacterName'] ?></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<?php else: ?>
<div class="container">
    <h1>Access Denied</h1>
    <div class="alert alert-danger">Please <a href="login.php">login</a>.</div>
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
include 'includes/footer.php';
?>
