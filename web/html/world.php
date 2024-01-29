<?php
    require_once 'includes/database.php'; // gives us $db variable to run queries
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The World</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body class="p-3">
<h1>The World</h1>
<?php
    // get sort parameters
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'Name';
    $dir = isset($_GET['dir']) ? $_GET['dir'] : 'ASC';

    // build query, test in phpMyAdmin first
    $query = "SELECT 
                Code, Country.Name AS CountryName, Continent, Population 
                FROM `Country` 
                ORDER BY $sort $dir";

    // run query, this is where most errors occur, but are reported later
    $result = mysqli_query($db, $query)
        //or die('Error in query.'); // do in production
	    or die('Error in query: ' . mysqli_error($db)); // only for debugging

    // get number of rows
    $count = mysqli_num_rows($result);
    echo "<p>$count countries found.";

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <?php
            // setting up sort links to include the ability to reverse direction
            // set the sort direction for population to be the opposite of what is currently displayed
            $populationDir = ($sort == 'Population' && $dir == 'ASC') ? 'DESC' : 'ASC';
            $populationArr = '';
            if($sort == 'Population'){
                // if sorting by population asc, use a down arrow, else use an up arrow
                $populationArr = $dir == 'ASC' ? '&darr;' : '&uarr;';
            }
        ?>

        <tr>
            <th><a href="world.php?sort=Name">Name</a></th>
            <th><a href="?sort=Continent">Continent</a></th>
            <th><a href="?sort=Population&dir=<?= $populationDir ?>">Population</a> <?= $populationArr ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        // loop through all the records
        $total = 0;
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $total += $row['Population'];
            // use the primary key as data being passed through the URL
            echo "<tr>
                   <td><a href=\"country.php?id={$row['Code']}\">{$row['CountryName']}</a></td>
                   <td>{$row['Continent']}</td>
                   <td>{$row['Population']}</td>
            </tr>";
        }
        ?>


    </tbody>
</table>
<p>Total Population: <?= number_format($total); ?></p>
</body>
</html>


<?php
// close database connection (usually do this in a footer)
mysqli_close($db);
