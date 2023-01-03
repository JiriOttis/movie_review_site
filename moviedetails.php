<?php
$page_title = "Ohodnoť film! - Filmy";
include('includes/header.php');


//ziskani filmu
$stmt = $db->prepare('SELECT * FROM film WHERE film_id=:id LIMIT 1');
$stmt->execute([':id'=>@$_REQUEST['id']]);


$movie = $stmt->fetch(PDO::FETCH_ASSOC);
if (empty($movie)) {
    echo "<a href='movies.php'>Vrátit se zpět na přehled filmů</a></br>";
    die("Error: Chyba v zadání id filmu");
}

//ziskani zanru filmu
$stmt = $db->prepare('SELECT film.film_id as film_id, zanr.nazev as nazev FROM film,zanr, film_zanr WHERE film.film_id = :film_id AND film.film_id = film_zanr.film_id AND zanr.zanr_id = film_zanr.zanr_id; ');

$stmt->execute([
    ':film_id' => @$_REQUEST['id']
]);

$genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

//ulozeni recenze do databaze
if (!empty($_POST)) {
    $query = $db->prepare('INSERT INTO recenze (text, hodnoceni, film_id, user_id) VALUES (:text, :hodnoceni, :film_id, :user_id);');
    $query->execute([
        ':text' => trim(@$_POST['text']),
        ':hodnoceni' => @$_POST['rating'],
        ':film_id' => @$_REQUEST['id'],
        ':user_id' => $_SESSION['user_id']
    ]);
}

//nacteni recenze od konkretniho uzivateel
if ((!empty($_SESSION))) {
$userQuery=$db->prepare('SELECT * FROM recenze WHERE recenze.user_id=:user_id AND recenze.film_id=:film_id LIMIT 1;');
$userQuery->execute([
    ':user_id'=>$_SESSION['user_id'],
    ':film_id'=>$_REQUEST['id']
]);

$userReview = $userQuery->fetch(PDO::FETCH_ASSOC);
}

//nacteni vsech recenzi k filmu
$stmt=$db->prepare('SELECT recenze.*, film.nazev, uzivatel.vid_jmeno FROM recenze INNER JOIN film ON film.film_id = recenze.film_id INNER JOIN uzivatel ON uzivatel.user_id = recenze.user_id WHERE recenze.film_id=:film_id;');
$stmt->execute([
    ':film_id'=>$_REQUEST['id']
]);

$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

//ziskani celkoveho hodnoceni
$numberOfReviews = count($reviews);
$final_rating = 0;
if ($numberOfReviews > 0){
$rating_sum = 0;
foreach ($reviews as $review) {
    $rating_sum += $review["hodnoceni"];
}
$final_rating = round($rating_sum / $numberOfReviews, 2);
}



?>

<main>

    <div class="container">
        <div class="movie-info d-flex justify-content-between align-items-center">
            <div>
                <h2><?php echo $movie['nazev'] . " (" . $movie['rok_vydani'] . ")"; ?></h2>
                <p><?php echo $movie['stopaz'] . " min"; ?> </p>
                <p><?php
                    foreach ($genres as $genre){
                        if ($genre === end($genres)) {
                            echo $genre["nazev"];
                            break;
                        }
                        echo $genre["nazev"] . " | ";

                    }


                ?> </p>
                <p><?php echo $movie['zeme_vyroby']; ?> </p>
            </div>
            <div>
                <span class="fs-5">Hodnocení uživatelů: <?php echo $final_rating; ?><i class="fa fa-star star" style="color: darkorange"></i>/ 5</span>
            </div>
        </div>

        <div class="row movie-details">
            <div class="col-4">
                <div class="box-img">
                    <img src="<?php echo $movie['img']; ?>" alt="<?php echo $movie['nazev']; ?>">
                </div>
            </div>
            <div class="col-8">
                <h3>Ohodnoť tento film a napiš recenzi!</h3>
                <div class="review-form text-center">
<?php
//uzivatel neni prihlasen
if (empty($_SESSION['user_id'])):
    ?>
        <p class="login-info">
            Pokud chcete hodnotit filmy a psát recenze musíte se nejprve <a href="login.php">přihlásit</a> nebo <a href="registration.php">zaregistrovat</a>.
        </p>


<?php endif; ?>

                    <?php
//uzivatel je prihlasen a nenapsal recenzi
if (!empty($_SESSION['user_id']) and $userQuery->rowCount()!=1):
    ?>
                    <form method="post">
                    <div class="star-rating">
                        <h4>Kolik tomuto filmu dáš hvězd?</h4>
                        <i class="fa fa-star fa-2x star-form" data-index="0"></i>
                        <i class="fa fa-star fa-2x star-form" data-index="1"></i>
                        <i class="fa fa-star fa-2x star-form" data-index="2"></i>
                        <i class="fa fa-star fa-2x star-form" data-index="3"></i>
                        <i class="fa fa-star fa-2x star-form" data-index="4"></i>
                        <input type="hidden" name="rating" value="">
                    </div>

                    <div class="form-row">
                        <h4>Napiš své hodnocení filmu do textového pole!</h4>
                        <textarea name="text" rows="3" id="textarea"></textarea>
                    </div>
                        <button type="submit" class="btn btn-primary">Uložit recenzi</button>
                    </form>

    <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script>
        var ratedIndex = -1;

        $(document).ready(function () {
            restartStarColors();

            $('.star-form').on('click', function () {
                if (ratedIndex === parseInt($(this).data('index')))
                    ratedIndex = -1;
                else
                    ratedIndex = parseInt($(this).data('index'));
                $('input[name="rating"]').val(ratedIndex + 1);
            });

            $('.star-form').mouseover(function () {
                restartStarColors();

                var currentIndex = parseInt($(this).data('index'));

                for (var i=0; i <= currentIndex; i++)
                    $('.star-form:eq('+i+')').css('color', 'darkorange');
            });
            $('.star-form').mouseleave(function () {
                restartStarColors();

                if (ratedIndex != -1)
                    for (var i=0; i <= ratedIndex; i++)
                        $('.star-form:eq('+i+')').css('color', 'darkorange');
            });

            function restartStarColors() {
                $('.star-form').css('color', 'black');
            }
        });
    </script>

            <?php endif; ?>

                    <?php
                    //uzivatel je prihlasen a napsal recenzi


                    if (!empty($_SESSION['user_id']) and $userQuery->rowCount()==1):

                        ?>
                     <h4>Svoje hodnocení a recenzi na tento film jsi již napsal!</h4>
                    <p class="fs-5">Hodnocení: <?php echo $userReview["hodnoceni"]; ?><i class="fa fa-star star" style="color: darkorange"></i>z 5 </p>
                    <h4>Text recenze:</h4>
                    <textarea class="fs-5 review-text" disabled><?php echo $userReview["text"]; ?></textarea>
                        <a role="button" href="deleteReview.php?id=<?php echo $_REQUEST['id'] ?>"  class="btn btn-danger">
                            Smazat hodnocení
                        </a>

                        <a role="button" href="editReview.php?id=<?php echo $_REQUEST['id'] ?>"  class="btn btn-primary">
                            Upravit hodnocení
                        </a>
                    <?php endif; ?>
            </div>
        </div>

        <div class="reviews">
            <div class="title">
            <h3>Hodnocení filmu</h3>
                <hr>
            </div>
            <div class="reviews-box">
        <?php foreach($reviews as $review){ ?>
                <div class="review d-flex justify-content-between">
                    <div>
                    <p><?php echo $review["vid_jmeno"]; ?> dal <?php echo $review["hodnoceni"]; ?><i class="fa fa-star star" style="color: darkorange"></i> dne <?php echo date("d. m. Y",strtotime($review["datum_pridani"]))?></p>
  
                    <p><?php echo $review["text"]; ?></p>
                    </div>
                    <?php if ($_SESSION['role'] == "admin"): ?>
                    <div>
                    <a href="deleteReviewAdmin.php?id=<?php echo $review['film_id'] . "&user=" . $review["user_id"]; ?>" class="table-icon" id="delete">
                    <i class="fa-solid fa-trash-can fa-2x"></i>
                    </a>
                    </div>
                    <?php endif; ?>
                </div>
        <?php } ?>

            </div>
            </div>



    </div>



<?php
include('includes/footer.php');


