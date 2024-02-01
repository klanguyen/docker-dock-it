<?php
// start the session
session_name('nnguyen1_final');
session_start();
// to delete everything in the session
//session_destroy();

// remember, it's relative to the note.php (or any file that includes this file)
require_once "includes/database.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/4ee835f775.js" crossorigin="anonymous"></script>
    <link href="css/login.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <title>Funflix | Signup</title>
</head>
<body>
<?php
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $errorMsg = '';
    $formIsValid = true;
    if(isset($_POST['signup'])){
        if(strpos($email, '@') === false){
            $errorMsg = 'Please enter a valid email.';
            $formIsValid = false;
        }
        if(empty($email) OR empty($password)){
            $errorMsg = 'Email or password was not provided.';
            $formIsValid = false;
        }
    }
?>
<div class="container" style="padding: 100px 0">
    <div class="row text-center mb-2">
        <div class="col-md-12" style="font-size: 200%; font-weight: bold;">
            <a href="index.php" style="text-decoration: none; color: #E4D806;"><i class="bi bi-camera-reels-fill"></i> Funflix</a>
        </div>
    </div>
    <div class="row text-center">
    <div class="col-md-6 offset-md-3">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header mt-3">
                <h3><b>Sign Up</b></h3>
            </div>
            <?php
            $accountCreated = false;

            if(isset($_POST['signup']) AND $formIsValid){
                // get form values
                $email = $_POST['email'];
                $password = $_POST['password'];

                // encrypt password (after validation)
                // don't use md5(), sha1()
                $password = password_hash($password, PASSWORD_DEFAULT);

                // add user to database
                $query = "INSERT INTO `AuthUsers` (`UserID`, `Email`, `Password`, `Role`) 
                        VALUES (NULL, ?, ?, 'user');";

                // prepare, bind, exec the query
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, "ss", $email, $password);
                mysqli_stmt_execute($stmt);

                // check if record was created
                if(mysqli_stmt_insert_id($stmt)){
                    $accountCreated = true;
                    echo '<div class="alert alert-success">
                          <b>Account created!</b><br>Please <a href="login.php">login</a>.
                        </div>';

                }else{
                    echo '<div class="alert alert-danger">
                          <b>Error creating account!</b><br> Email is already used.
                        </div>';

                    // for debugging only
                    //echo mysqli_stmt_error($stmt);
                }
            }elseif(isset($_POST['signup']) AND !$formIsValid){
                echo "<div class='alert alert-danger'>
                          <b>$errorMsg</b>
                        </div>";
            }
            ?>
            <div class="card-body">
            <?php if(!$accountCreated): ?>
                <form method="post">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="email" name="email" class="form-control" placeholder="Your Email *" value="<?= $email ?>">

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Your Password *" value="">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="signup" value="Sign Up" class="btn float-right login_btn">
                    </div>
                </form>
            <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>
</body>
</html>

<?php
// close db connection (usually in a footer.php)
@mysqli_close($db);
?>