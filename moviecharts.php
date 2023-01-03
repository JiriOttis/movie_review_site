<?php
$page_title = "Ohodnoť film! - Recenze";
include('includes/header.php');

if (!empty($_GET["poradi"])){
    if ($_GET["poradi"] == "nejlepsi") {
        $stmt = $db->prepare('SELECT film.film_id, film.nazev, AVG(recenze.hodnoceni) as final_rating FROM film INNER JOIN recenze ON recenze.film_id = film.film_id GROUP BY film.nazev ORDER BY final_rating DESC LIMIT 50; ');
        $stmt->execute();
    }
    elseif ($_GET["poradi"] == "nejhorsi"){
        $stmt = $db->prepare('SELECT film.film_id, film.nazev, AVG(recenze.hodnoceni) as final_rating FROM film INNER JOIN recenze ON recenze.film_id = film.film_id GROUP BY film.nazev ORDER BY final_rating ASC LIMIT 50; ');
        $stmt->execute();
    }
    else
     {
        header('Location: moviecharts.php');
        exit();
    }
}else{
    $stmt = $db->prepare('SELECT film.film_id, film.nazev, AVG(recenze.hodnoceni) as final_rating FROM film INNER JOIN recenze ON recenze.film_id = film.film_id GROUP BY film.nazev ORDER BY final_rating DESC LIMIT 50; ');
    $stmt->execute();
}





$movies= $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main>

    <div class="container">

        <h1>Žebříček filmů</h1>
        <div class="container text-center d-flex justify-content-around w-50">
            <a role="button" href="moviecharts.php?poradi=nejlepsi"  class="btn btn-primary">
                Zobrazit nejlepší filmy
            </a>
            <a role="button" href="moviecharts.php?poradi=nejhorsi"  class="btn btn-primary">
                Zobrazit nejhorší filmy
            </a>
        </div>

        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th scope="col">Umístění</th>
                    <th scope="col">Název</th>
                    <th scope="col">Hodnocení</th>
                </tr>
            </thead>
<?php
$index = 0;
foreach ($movies as $movie){
    $index++;
    ?>
            <tr>
                <th scope="row"><?php echo $index ?></th>
                <td>
                    <a href="moviedetails.php?id=<?php echo $movie['film_id'] ?>">
                    <?php echo $movie['nazev'] ?>
                    </a>
                </td>
                <td><?php echo round($movie['final_rating'], 2) ?>
                    <i class="fa fa-star star" style="color: darkorange"></i>
                </td>
            </tr>
     <?php } ?>
        </table>
    </div>

<?php
include('includes/footer.php');
