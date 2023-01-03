<?php
$page_title = "Ohodnoť film! - Uživatelský účet";
include('includes/header.php');

?>


    <div class="container useraccount">

        <div class="row">
            <div class="side-menu col-md-2 d-flex flex-column justify-content-between">
                <div class="d-flex flex-column justify-content-start">
                <a href="useraccount.php" class="item-link">
                    <div class="container item d-flex justify-content-start">
                        <i class="fa-solid fa-circle-user fa-2x"></i>
                        <p>Účet</p>
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

            </div>



        </div>

    </div>





<?php
include('includes/footer.php');
