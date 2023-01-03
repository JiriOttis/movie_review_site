<?php
$page_title = "Ohodnoť film! - Recenze";
include('includes/header.php');

//nacteni poslednich 10 recenzi
$stmt=$db->prepare('SELECT recenze.*, film.nazev, uzivatel.vid_jmeno FROM recenze INNER JOIN film ON film.film_id = recenze.film_id INNER JOIN uzivatel ON uzivatel.user_id = recenze.user_id WHERE text <> "" ORDER BY datum_pridani DESC LIMIT 10;');
$stmt->execute();

$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main>
    <div class="container">
        <h1>Podvívej se na poslední přidané recenze!</h1>

        <div class="reviews">
            <hr>
            <h3>Posledních 10 napsaných recenzí</h3>

            <div class="reviews-box">
                <?php foreach($reviews as $review){ ?>
                <div class="review">
                    <div class="d-flex justify-content-between align-items-center me-5">
                    <span class="fs-4"><?php echo $review["vid_jmeno"]; ?> hodnotí film <a href="moviedetails.php?id=<?php echo $review['film_id']; ?>"><?php echo $review["nazev"]; ?></a></span>
                    <p "fs-5"><?php echo $review["hodnoceni"]; ?> <i class="fa fa-star star" style="color: darkorange"></i></p>
                    </div>
                    <p><?php echo $review["text"]; ?></p>
                    <p><?php echo date("d. m. Y - H:i",strtotime($review["datum_pridani"]))?></p>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>


<?php
include('includes/footer.php');