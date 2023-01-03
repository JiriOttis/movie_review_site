<?php
$page_title = "Ohodnoť film! - Uživatelský účet";
include('includes/header.php');
require 'includes/admin_required.php';

$stmt = $db->prepare('SELECT film_id, nazev FROM film ORDER BY nazev ASC; ');
$stmt->execute();

$movies= $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


    <div class="container useraccount">

        <div class="row">
            <div class="side-menu col-md-2 d-flex flex-column justify-content-between">
                <div class="d-flex flex-column justify-content-start">
                    <a href="adminaccount.php?page=1" class="item-link">
                        <div class="container item d-flex justify-content-start">
                            <i class="fa-solid fa-circle-user fa-2x"></i>
                            <p>Účet</p>
                        </div>
                    </a>

                    <a href="adminaccount.php?page=2" class="item-link">
                        <div class="container item d-flex justify-content-start">
                            <i class="fa-solid fa-file-video fa-2x"></i>
                            <p>Správa filmů</p>
                        </div>
                    </a>
                </div>

                <a href="logout.php" class="item-link">
                    <div class="container item d-flex justify-content-start">
                        <i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>
                        <p>Odhlásit se</p>
                    </div>
                </a>

            </div>
            <div class="col-md-10 d-flex flex-column justify-content-start">

                <?php
                if ($_REQUEST["page"] == 1): ?>

                    <div class="d-flex flex-column justify-content-start text-center">
                        <h2>Uživatelský účet</h2>
                        <p>Zde vidíš svoje informace o účtu, může je také změnit a nebo se odhlásit z účtu!</p>
                    </div>
                    <div class="col-md-10 d-flex flex-column justify-content-start">
                        <p class="fs-5 user-info">Tvoje uživatelské jméno je <?php echo $_SESSION['user_name']; ?></p>
                        <p class="fs-5 user-info">Tvoje viditelné jméno je <?php echo $_SESSION['displayName']; ?></p>
                        <p class="fs-5 user-info">Tvůj email je <?php echo $_SESSION['email']; ?></p>

                        <a role="button" href="editUserInfo.php"  class="btn btn-primary editUserInfo">
                            Upravit uživatelské údaje
                        </a>

                    </div>
                <?php endif; ?>

                <?php
                if ($_REQUEST["page"] == 2): ?>

                    <div class="d-flex flex-column justify-content-start text-center">
                        <h2>Správa filmů</h2>
                        <p>Přidej, uprav, odstraň film!</p>
                        <a role="button" href="addMovie.php"  class="btn btn-primary add-movie">
                            Přidat film
                        </a>
                    </div>
                    <div class="d-flex justify-content-start">
                        <table class="table table-striped text-center table-movies">
                            <thead>
                            <tr>
                                <th scope="col">Název</th>
                                <th scope="col">Možnosti</th>
                            </tr>
                            </thead>
                            <?php
                            foreach ($movies as $movie){
                                ?>
                                <tr>
                                    <td>
                                            <?php echo $movie['nazev'] ?>
                                    </td>
                                    <td class="d-flex justify-content-start">
                                        <a href="editMovie.php?id=<?php echo $movie['film_id']; ?>" class="table-icon" id="edit">
                                        <i class=" fa-solid fa-pen-to-square fa-2x"></i>
                                        </a>
                                        <a href="deleteMovie.php?id=<?php echo $movie['film_id']; ?>" class="table-icon" id="delete">
                                        <i class="fa-solid fa-trash-can fa-2x"></i>
                                        </a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                    </div>
                <?php endif; ?>
<!-- -------------->
            </div>



        </div>

    </div>





<?php
include('includes/footer.php');

