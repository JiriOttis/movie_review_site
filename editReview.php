<?php
$page_title = "Ohodnoť film! - Upravit recenzi";
include('includes/header.php');

$userQuery=$db->prepare('SELECT recenze.*, film.nazev, uzivatel.vid_jmeno FROM recenze INNER JOIN film ON film.film_id = recenze.film_id INNER JOIN uzivatel ON uzivatel.user_id = recenze.user_id WHERE recenze.film_id=:film_id AND recenze.user_id=:user_id;');
$userQuery->execute([
    ':film_id'=>$_REQUEST['id'],
    ':user_id'=>$_SESSION['user_id']
]);

$userReview = $userQuery->fetch(PDO::FETCH_ASSOC);
if (empty($userReview)) {
    echo "<a href='movies.php'>Vrátit se zpět na přehled filmů</a></br>";
    die("Error: Chyba v zadání id filmu");
}


// uložení updated do DB
if (!empty($_POST)) {
    $stmt = $db->prepare('UPDATE recenze SET text=:text, hodnoceni=:hodnoceni WHERE user_id=:user_id AND film_id=:film_id LIMIT 1;');
    $stmt->execute([
        ':text' => trim(@$_POST['text']),
        ':hodnoceni' => @$_POST['rating'],
        ':user_id' => $_SESSION['user_id'],
        ':film_id' => @$_REQUEST['id']
    ]);

    header('Location: moviedetails.php?id='.$_REQUEST["id"]);
    exit();
}
?>

<main>
    <div class="container text-center">

        <h2>Upravit hodnocení pro film <?php echo $userReview['nazev']; ?></h2>

        <div class="review-form">
    <form method="post">
        <div class="star-rating">
            <h4>Kolik tomuto filmu dáš hvězd?</h4>
            <i class="fa fa-star fa-2x star-form" data-index="0"></i>
            <i class="fa fa-star fa-2x star-form" data-index="1"></i>
            <i class="fa fa-star fa-2x star-form" data-index="2"></i>
            <i class="fa fa-star fa-2x star-form" data-index="3"></i>
            <i class="fa fa-star fa-2x star-form" data-index="4"></i>
            <input type="hidden" name="rating" value="<?php echo $userReview['hodnoceni']; ?>">
        </div>

        <div class="form-row">
            <h4>Napiš své hodnocení filmu do textového pole!</h4>
            <textarea name="text" rows="3" id="textarea"><?php echo $userReview['text']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Uložit recenzi</button>
        <a role="button" href="moviedetails.php?id=<?php echo $_REQUEST['id'] ?>"  class="btn btn-danger">
            Zrušit
        </a>
    </form>
        </div>
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
    <script>
        var ratedIndex = -1;

        $(document).ready(function () {
            restartStarColors();
            setStars(parseInt($('input[name="rating"]').val()));

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

                setStars(currentIndex);
            });
            $('.star-form').mouseleave(function () {
                restartStarColors();

                if (ratedIndex != -1)
                    for (var i=0; i <= ratedIndex; i++)
                        setStars(ratedIndex);
            });

            function restartStarColors() {
                $('.star-form').css('color', 'black');
            }

            function setStars(max) {
                for (var i=0; i <= max; i++)
                    $('.star-form:eq('+i+')').css('color', 'darkorange');
            }
        });
    </script>


</div>


</main>

