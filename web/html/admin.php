<?php
$pageName = 'Admin | Home';
include "includes/header.php";
?>

<section id="breadcrumbs" class="breadcrumbs" style="background-color: white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2><?= $pageName ?? 'Default Name' ?></h2>
            <ol>
                <li><a href="index.php">Home</a></li>
                <li>Library</li>
            </ol>
        </div>
    </div>
</section>

<div class="container" style="background-color: white">
    <div class="justify-content-center">
        <h3>Movie List</h3>
        <hr>
    </div>
</div>

<?php
// get sort column from the url
$sortField = $_GET['sort'] ?? 'MovieName';
$dir = $_GET['dir'] ?? 'ASC';
// number of record per page
$display = 20;
$searchKey = $_GET['searchKey'] ?? '';
$searchString = "'%$searchKey%'";

// build query, test in phpAdmin first
if(empty($searchKey)){
    $query = "SELECT *
            FROM Movies
            ORDER BY $sortField $dir;";
}else {

    $query = "SELECT *
        FROM Movies
        WHERE MovieName LIKE $searchString
        ORDER BY $sortField $dir";
}
// run the query
$result = mysqli_query($db, $query)
or die('Error in query.'); // do this in production
// or die('Error in query: '.mysqli_error($db)); // used for debugging

// get number of rows
$count = mysqli_num_rows($result);
//echo "<p>$count albums found.</p>";

// sort
/*$albumDir = ($sortField == 'Title' && $dir == 'ASC') ? 'DESC' : 'ASC';
$albumArrow = '';
if($sortField == 'Title'){
    $albumArrow = $dir == 'ASC' ? '&darr;' : '&uarr;';
}
$artistDir = ($sortField == 'Name' && $dir == 'ASC') ? 'DESC' : 'ASC';
$artistArrow = '';
if($sortField == 'Name'){
    $artistArrow = $dir == 'ASC' ? '&darr;' : '&uarr;';
}
$genreDir = ($sortField == 'GenreName' && $dir == 'ASC') ? 'DESC' : 'ASC';
$genreArrow = '';
if($sortField == 'GenreName'){
    $genreArrow = $dir == 'ASC' ? '&darr;' : '&uarr;';
}*/

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
$start = ($current_page - 1)*$display;

// define the query
if(empty($searchKey)){
    $q = "SELECT MovieID, MovieName, ReleaseDate, Overview, Runtime
        FROM Movies
        ORDER BY $sortField $dir 
        LIMIT $start, $display;";
}else {
    $q = "SELECT MovieID, MovieName, ReleaseDate, Overview, Runtime
        FROM Movies
        WHERE MovieName LIKE $searchString
        ORDER BY $sortField $dir
        LIMIT $start, $display;";
}
$r = @mysqli_query($db, $q) or die('Error in query.');

// only do validation if the user submitted the form
$searchError = '';
$formIsValid = true;
if(isset($_GET['submit'])) {
    if(empty($searchKey)){
        $searchError = "Search key is required.";
        $formIsValid = false;
    }
}
?>
<form action="" method="get">
    <div class="container">
        <div class="input-group justify-content-end">
            <div><span style="color: red; font-weight: bold;"><?= $searchError ?></span><br></div>
            <div class="form-outline">
                <input id="searchKey" name="searchKey" type="text" class="form-control" placeholder="Type in keyword..." />
            </div>
            <input type="submit" name="submit" value="Search" class="btn btn-danger">
        </div>
    </div>
</form><br>
<div class="container">
    <a class="btn btn-danger" href="addMovie.php">Add New Movie</a>
</div>
<?php
if($formIsValid && isset($_GET['submit'])){
    // define the query
    $q = "SELECT MovieID, MovieName, ReleaseDate, Overview, Runtime
        FROM Movies
        WHERE MovieName LIKE $searchString
        ORDER BY $sortField $dir 
        LIMIT $start, $display;";
    $r = @mysqli_query($db, $q) or die('Error in query.');
}
?>
<div class="container" style="background-color: white">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <th><a href="?sort=MovieName&searchKey=<?= $searchKey ?>">Movie Name</a></th>
        <th>Release Date</th>
        <th>Overview</th>
        <th>Runtime</th>
        </thead>
        <tbody>
        <?php
        // loop through the results
        while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
            ?>
            <tr>
                <!-- When trying to load a particular record, always use the PK -->
                <td><?= $row['MovieName'] ?></td>
                <td><?= $row['ReleaseDate'] ?></td>
                <td><?= $row['Overview'] ?></td>
                <td><?= $row['Runtime'] ?></td>
            </tr>

            <?php
        }
        ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="pagination">
        <ul class="pagination justify-content-center" id="pagination">

            <?php
            // Make the links to other page, if necessary
            if($pages > 1){

                // If it's not the first page, make a Previous link:
                if($current_page != 1) {
                    echo "<li class='page-item'>";
                    echo "  <a class='page-link' href='?searchKey=$searchKey&sort=$sortField&dir=$dir&page=".($current_page - 1)."'>Previous</a>";
                    echo "</li>";
                }

                // Make all the numbered pages:
                for($i = 1; $i <= $pages; $i++){
                    if($i != $current_page){
                        echo "<li class='page-item'>";
                        echo "<a class='page-link' href='?searchKey=$searchKey&sort=$sortField&dir=$dir&page=$i'>$i</a>";
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
                    echo "<a class='page-link' href='?searchKey=$searchKey&sort=$sortField&dir=$dir&page=".($current_page + 1)."'>Next</a>";
                    echo "</li>";
                }
            }
            ?>

        </ul>
    </nav> <!-- End pagination -->

    <!--<script type="text/javascript">
    $(function () {
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: <?php echo $pages ?>,
            visiblePages: 5,
            onPageClick: function (event, page) {

            }
        }).on('page', function (event, page) {
            console.info(page + ' (from event listening)');
            window.history.pushState('', '', 'products.php?sort=<?php echo $sortField ?>&dir=<?php echo $dir ?>&page=' + page);
        });
    });
</script>-->
</div>
<?php
include "includes/footer.php";
?>
