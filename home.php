<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Home Page</title>
        <link href="css/css.css" rel="stylesheet" type="text/css"/>
        <link href="css/Style.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </head>
    <body>
        <?php
            include ('header.html');
        ?>
        
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/book.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/bottle.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/cap.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
        
        <section class="page-section clearfix">
            <div class="container">
                <div class="intro">
                    <!--<img class="intro-img img-fluid mb-3 mb-lg-0 rounded" src="assets/img/intro.jpg" alt="..." />-->
                   
                    <div class="intro-text left-0 text-center bg-faded p-5 rounded">
                        <h2 class="section-heading mb-4">
                            <span class="section-heading-upper">Expertise Gaming Worth For Joy</span>
                        </h2>
                        <p>
               Welcome to <b style="font-family: Lucida Console, Courier New, monospace">TARUMT University!</b>
               <br><br>As graduation season approaches, we're your one-stop destination for all things celebratory and commemorative. 
               <br><br>From elegant regalia to personalized keepsakes, we have everything you need to make your graduation experience unforgettable. 
               <br><br>With a dedicated team and a commitment to excellence, we're here to ensure your special day is as seamless and memorable as possible. 
            </p> 
                        <!--<div class="intro-button mx-auto"><a class="btn btn-primary btn-xl" href="#!">Visit Us Today!</a></div>-->
                    </div>
                </div>
            </div>
        </section>
        <section class="page-section cta">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 mx-auto">
                        <div class="cta-inner bg-faded text-center rounded">
                            <h2 class="section-heading mb-4">
                                <span class="section-heading-upper">Congratulations!!!</span>
                            </h2>
                            <p class="mb-0">On reaching this milestone, and let us help you celebrate in style at TARUMT University's Graduation Emporium.</p>
</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
            include ('footer.php');
        ?>
    </body>
</html>