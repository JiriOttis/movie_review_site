<?php
$page_title = "Ohodnoť film! - Upravit film";
include('includes/header.php');
require 'includes/admin_required.php';

$stmt = $db->prepare("SELECT * FROM film WHERE film_id=:film_id");
$stmt->execute([
    ':film_id'=>$_GET['id']
]);

$movie = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT * FROM zanr");
$stmt->execute();

$genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT film_zanr.*,zanr.nazev FROM film_zanr INNER JOIN zanr ON film_zanr.zanr_id = zanr.zanr_id WHERE film_id=:film_id");
$stmt->execute([
    ':film_id'=>$_GET['id']
]);

$movieGenres = $stmt->fetchAll(PDO::FETCH_ASSOC);


//********************

$errors=[];

if (!empty($_POST)) {
    //NAME**************************************
    $name = trim(@$_POST['name']);
    if (empty($name)){
        $errors['name']='Musíte zadat název filmu.';
    }
    //releaseDate**************************************
    $releaseDate = trim(@$_POST['releaseDate']);
    if (empty($releaseDate)){
        $errors['releaseDate']='Musíte zadat rok vydání filmu.';
    } elseif (!preg_match("/^\d{4}$/", $releaseDate)) {
        $errors['releaseDate']='Musíte zadat platný rok.';
    }
    //movieLength**************************************
    $movieLength = trim(@$_POST['movieLength']);
    if (empty($movieLength)){
        $errors['movieLength']='Musíte zadat stopáž filmu.';
    }elseif (!preg_match("/^\d{2,3}$/", $movieLength)) {
        $errors['movieLength']='Musíte zadat platnou stopáž pouze jako číslo v minutách (např. 126).';
    }
    //country**************************************
    $country = trim(@$_POST['country']);
    if (empty($country)){
        $errors['country']='Musíte zadat zemi výroby filmu.';
    }

    //GENRES************************************
    $selectedGenres = [$_POST['genre1'],$_POST['genre2'], $_POST['genre3']];
    if(!array_filter($selectedGenres)) {
        $errors['genres']='Musíte vybrat alespoň jeden žánr.';
    }
    for ($i = 0; $i <= 2; $i++) {
        $changedGenre = $selectedGenres[$i];
        if (!empty($selectedGenres[$i])) {
                if ($movieGenres[$i]["zanr_id"] != $selectedGenres[$i]) {
                    $changedGenre = $movieGenres[$i]["zanr_id"];
            }
            echo "<p> Zmena z " . $changedGenre . " na " . $selectedGenres[$i] . "</p>";
        }

    }

    if (empty($errors)) {
        //do databaze UPDATE
        $query = $db->prepare('UPDATE film SET nazev=:nazev, rok_vydani=:rok_vydani, stopaz=:stopaz, zeme_vyroby=:zeme_vyroby  WHERE film_id=:film_id LIMIT 1;');
        $query->execute([
            ':nazev' => $name,
            ':rok_vydani' => $releaseDate,
            ':stopaz' => $movieLength,
            ':zeme_vyroby' => $country,
            ':film_id'=> $movie["film_id"]
        ]);

            for ($i = 0; $i <= 2; $i++) {
                $changedGenre = $selectedGenres[$i];
                if (!empty($selectedGenres[$i])) {
                    if ($movieGenres[$i]["zanr_id"] != $selectedGenres[$i]) {
                        $changedGenre = $movieGenres[$i]["zanr_id"];
                    }
                $query = $db->prepare('UPDATE film_zanr SET zanr_id=:zanr_id1 WHERE film_id=:film_id AND zanr_id=:zanr_id2 LIMIT 1;');
                $query->execute([
                    ':zanr_id1' => $selectedGenres[$i],
                    ':film_id' => $movie["film_id"],
                    ':zanr_id2'=> $changedGenre
                ]);
                }

}


        header('Location: adminaccount.php?page=2');
        exit();

    }

}
?>

<main xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="text-center">
            <h2>Přidat film</h2>
        </div>
        <div class="container form">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Název filmu</label>
                    <input type="text" class="form-control <?php echo (!empty($errors['name'])?'is-invalid':''); ?>" id="name" name="name" placeholder="Batman" value="<?php if (empty($_POST)) { echo $movie['nazev']; }else {echo htmlspecialchars(@$_POST['name']); } ?>">
                    <?php
                    echo (!empty($errors['name'])?'<div class="invalid-feedback">'.$errors['name'].'</div>':'');
                    ?>
                </div>
                <div class="mb-3">
                    <label for="releaseDate" class="form-label">Rok vydani</label>
                    <input type="text" class="form-control <?php echo (!empty($errors['releaseDate'])?'is-invalid':''); ?>" id="displayName" name="releaseDate" placeholder="1984" value="<?php if (empty($_POST)) { echo $movie['rok_vydani']; }else {echo htmlspecialchars(@$_POST['releaseDate']); } ?>">
                    <?php
                    echo (!empty($errors['releaseDate'])?'<div class="invalid-feedback">'.$errors['releaseDate'].'</div>':'');
                    ?>
                </div>
                <div class="mb-3">
                    <label for="movieLength" class="form-label">Stopáž</label>
                    <input type="number" class="form-control <?php echo (!empty($errors['movieLength'])?'is-invalid':''); ?>" id="movieLength" name="movieLength" placeholder="126" value="<?php if (empty($_POST)) { echo $movie['stopaz']; }else {echo htmlspecialchars(@$_POST['movieLength']); } ?>">
                    <?php
                    echo (!empty($errors['movieLength'])?'<div class="invalid-feedback">'.$errors['movieLength'].'</div>':'');
                    ?>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">Země výroby</label>
                    <input type="text" class="form-control <?php echo (!empty($errors['country'])?'is-invalid':''); ?>" id="country" name="country" placeholder="USA / Velká Británie" value="<?php if (empty($_POST)) { echo $movie['zeme_vyroby']; }else {echo htmlspecialchars(@$_POST['country']); } ?>">
                    <?php
                    echo (!empty($errors['country'])?'<div class="invalid-feedback">'.$errors['country'].'</div>':'');
                    ?>
                </div>


                <div class="mb-3">
                    <label for="vyberZanru1">První žánr filmu</label>
                    <select class="form-control <?php echo (!empty($errors['genres'])?'is-invalid':''); ?>" id="vyberZanru1" name="genre1">
                        <option value="">---</option>
                        <?php foreach ($genres as $genre) { ?>
                            <option value="<?php echo $genre['zanr_id']; ?>"
                                <?php

                                if (!empty($_POST) and $_POST['genre1'] == $genre['zanr_id']) { echo 'selected';
                                }
                                elseif ($movieGenres[0]["zanr_id"] == $genre['zanr_id']) {
                                    echo 'selected';
                                }


                                ?>
                            >
                                <?php echo $genre['nazev']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <?php
                    echo (!empty($errors['genres'])?'<div class="invalid-feedback">'.$errors['genres'].'</div>':'');
                    ?>

                    <label for="vyberZanru2">Druhý žánr filmu</label>
                    <select class="form-control" id="vyberZanru2" name="genre2">
                        <option value="">---</option>
                        <?php foreach ($genres as $genre) { ?>
                            <option value="<?php echo $genre['zanr_id']; ?>"
                                <?php  if (!empty($_POST) and $_POST['genre2'] == $genre['zanr_id']) { echo 'selected';
                                }
                                elseif (isset($movieGenres[1]) and $movieGenres[1]["zanr_id"] == $genre['zanr_id']) {
                                    echo 'selected';
                                } ?>
                            >
                                <?php echo $genre['nazev']; ?>
                            </option>
                        <?php } ?>
                    </select>

                    <label for="vyberZanru3">Třetí žánr filmu</label>
                    <select class="form-control" id="vyberZanru3" name="genre3">
                        <option value="">---</option>
                        <?php foreach ($genres as $genre) { ?>
                            <option value="<?php echo $genre['zanr_id']; ?>"
                                <?php if (!empty($_POST) and $_POST['genre3'] == $genre['zanr_id']) { echo 'selected';
                                }
                                elseif (isset($movieGenres[2]) and $movieGenres[2]["zanr_id"] == $genre['zanr_id']) {
                                    echo 'selected';
                                } ?>
                            >
                                <?php echo $genre['nazev']; ?>
                            </option>
                        <?php } ?>
                    </select>

                </div>

                <button type="submit" class="btn btn-primary">Uložit</button>
                <a role="button" href="adminaccount.php?page=2"  class="btn btn-danger">
                    Zrušit
                </a>
            </form>

        </div>


    </div>

</main>
