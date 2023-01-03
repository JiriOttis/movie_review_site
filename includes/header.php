<?php
require_once 'includes/user.php'

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous"
    />

    <link href="assets/style.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/caa98a0474.js" crossorigin="anonymous"></script>

    <title><?php echo $page_title; ?></title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand mb-0 h1 fs-1">Ohodnoť film!</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav fs-5">
                    <li class="nav-item">
                        <a href="movies.php" class="nav-link">Filmy</a>
                    </li>
                    <li class="nav-item">
                        <a href="reviews.php" class="nav-link">Recenze</a>
                    </li>
                    <li class="nav-item">
                        <a href="moviecharts.php" class="nav-link">Žebříčky</a>
                    </li>
                </ul>
            </div>

<?php
//uzivatel neni prihlasen
if (empty($_SESSION['user_id'])): ?>

            <div class="btn-toolbar gap-4">
                <a role="button" href="login.php"  class="btn btn-light">
                    Přihlášení
                </a>
                <a role="button" href="registration.php"  class="btn btn-light">
                    Registrace
                </a>
            </div>
<?php endif; ?>


<?php
//uzivatel je prihlasen
            if (!empty($_SESSION['user_id'])): ?>
            <div class="d-flex gap-5">
            <p class="header-text fs-6">Jsi přihlášen jako <?php echo $_SESSION['displayName']; ?></p>
               <a href="<?php
               if ($_SESSION['role'] == "admin") {
                   echo "adminaccount.php?page=1";
               }
               else {
                   echo "useraccount.php";
               }

               ?>
"><i class="fa-solid fa-circle-user fa-3x"></i></a>
            </div>
            <?php endif; ?>



        </div>
    </nav>
</header>
