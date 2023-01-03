<?php
$page_title = "Ohodnoť film!";
include('includes/header.php');
?>

<main>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/img/DS_MoM.jpg" class="d-block w-100 mx-auto" alt="Doctor Strange in the Multiverse of Madness">
                <div class="carousel-caption d-none d-md-block">
                    <h4>Horká novinka</h4>
                    <p>Doktor Strange v mnohovesmíru šílenství</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/pulp-fiction.jpg" class="d-block w-100 mx-auto" alt="Pulp Ficiton">
                <div class="carousel-caption d-none d-md-block">
                    <h4>Stará dobrá klasika</h4>
                    <p>Pulp Fiction</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/babovresky.jpg" class="d-block mx-auto" alt="Babovřesky">
                <div class="carousel-caption d-none d-md-block">
                    <h4>Česká komedie</h4>
                    <p>Babovřesky</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container marketing">
        <div class="row">
            <div class="col-lg-4">
                <i class="fa-solid fa-user-plus fa-6x"></i>

                <h2>Vytvoř si účet</h2>
                <p>
                    Vytvoř si účet, abys mohl hodnotit filmy a psát recenze.
                </p>
                <p><a class="btn btn-secondary" href="registration.php">Registrace »</a></p>
            </div>
            <div class="col-lg-4">
                <i class="fa-solid fa-clapperboard fa-6x"></i>

                <h2>Procházej filmy</h2>
                <p>
                    Procházej filmy v naší databázi a vyber si ten, který chceš ohodnotit.
                </p>
                <p><a class="btn btn-secondary" href="movies.php">Zobrazit filmy »</a></p>
            </div>

            <div class="col-lg-4">
                <i class="fa-solid fa-star fa-6x"></i>

                <h2>Prozkoumej recenze</h2>
                <p>
                    Prozkoumej všechny recenze od ostatních uživatelů.
                </p>
                <p><a class="btn btn-secondary" href="reviews.php">Zobrazit recenze »</a></p>
            </div>
        </div>
    </div>

<?php
include('includes/footer.php');
