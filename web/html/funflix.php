<?php
$pageName = 'Home';
include 'includes/header.php';

?>

<div id="myCarouselIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#myCarouselIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#myCarouselIndicators" data-slide-to="1"></li>
        <li data-target="#myCarouselIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100 carousel-img" src="images/banner-1.jpeg" alt="First slide">
            <div class="carousel-caption d-none-d-md-block">
                <h5>COMING UP</h5>
                <a href="https://www.youtube.com/watch?v=gmRKv7n2If8" class="ghost-button">Watch Trailer</a>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100 carousel-img" src="images/banner-2.jpeg" alt="Second slide">
            <div class="carousel-caption d-none-d-md-block">
                <h5>COMING UP</h5>
                <a href="https://www.youtube.com/watch?v=BpdDN9d9Jio" class="ghost-button">Watch Trailer</a>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100 carousel-img" src="images/banner-3.jpeg" alt="Third slide">
            <div class="carousel-caption d-none-d-md-block">
                <h5>COMING UP</h5>
                <a href="https://www.youtube.com/watch?v=h9Q4zZS2v1k" class="ghost-button">Watch Trailer</a>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#myCarouselIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarouselIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="index-style">
    <div class="container mt-2">
        <div class="row">
            <div class="col-sm-8 mt-5">
                <h2>JOIN TODAY</h2><br>
                <p>Get access to maintain your own <i>custom personal lists,
                        track what you've seen</i> and search and filter for <i>what to
                        watch next</i>—regardless if it's in theatres, on TV or
                    available on popular streaming services like Acorn TV,
                    Kocowa, Peacock Premium, and DOCSVILLE.</p>
                <a href="signup.php" class="btn btn-warning">Sign Up</a>
            </div>
            <div class="col-sm-4 mt-5">
                <ul>
                    <li>Enjoy FunFlix ad free</li>
                    <li>Maintain a personal watchlist</li>
                    <li>Filter by your subscribed streaming services and find something to watch</li>
                    <li>Log the movies and TV shows you've seen</li>
                    <li>Build custom lists</li>
                </ul>
            </div>
        </div>
    </div><br>
</div>

<?php
include 'includes/footer.php';
?>

