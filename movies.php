<?php
$page_title = "Ohodnoť film! - Filmy";
include('includes/header.php');


#region načtení zboží pro výpis
$stmt = $db->prepare("SELECT * FROM film ORDER BY film_id DESC");
$stmt->execute();

$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>



<main>

    <div class="container movies">
        <div>
            <h1>Procházej filmy</h1>
        </div>
        <div class="movies-container">

             <?php foreach($movies as $movie){ ?>
            <!-- MOVIE BOX-->
        <div class="box">
            <a href="moviedetails.php?id=<?php echo $movie['film_id']; ?>">
            <div class="box-img">
            <img src="<?php echo $movie['img']; ?>" alt="<?php echo $movie['nazev']; ?>">
        </div>
            </a>
            <a href="moviedetails.php?id=<?php echo $movie['film_id']; ?>">
            <h3><?php echo $movie['nazev']; ?></h3>
            </a>
            <p><?php echo $movie['stopaz'] . " min";?></p>
            <p>
                <?php
                $stmt = $db->prepare('SELECT film.film_id as film_id, zanr.nazev as nazev FROM film,zanr, film_zanr WHERE film.film_id = :film_id AND film.film_id = film_zanr.film_id AND zanr.zanr_id = film_zanr.zanr_id; ');

                $stmt->execute([
                    ':film_id' => $movie['film_id']
                ]);

                $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($genres as $genre){
                    if ($genre === end($genres)) {
                        echo $genre["nazev"];
                        break;
                    }
                    echo $genre["nazev"] . " | ";
                }
                ?>
            </p>
        </div>
            <!-- MOVIE BOX-->
             <?php } ?>




        </div>
    </div>






<?php
include('includes/footer.php');