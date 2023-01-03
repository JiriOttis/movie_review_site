<?php
$page_title = "Ohodnoť film! - Filmy";
include('includes/header.php');


$errors=[];

if (!empty($_POST)) {

//USERNAME**************************************
$username = trim(@$_POST['username']);
if (empty($username)){
    $errors['username']='Musíte zadat uživatelské jméno.';
}

//DISPLAY NAME**************************************
$displayName = trim(@$_POST['displayName']);
if (empty($displayName)){
    $displayName = $username;
}
//EMAIL**************************************
$email = trim(@$_POST['email']);
if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Musíte zadat platnou e-mailovou adresu.';
}


//konec kontorly udaju


if (empty($errors)) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
//do databaze UPDATE
    $query = $db->prepare('UPDATE uzivatel SET uz_jmeno=:uz_jmeno, email=:email, vid_jmeno=:vid_jmeno  WHERE user_id=:user_id LIMIT 1;');
    $query->execute([
        ':uz_jmeno' => $username,
        ':email' => $email,
        ':vid_jmeno' => $displayName,
        ':user_id' => $_SESSION['user_id']
    ]);


    $_SESSION['user_name']=$username;
    $_SESSION['displayName']=$displayName;
    $_SESSION['email']=$email;


    header('Location: useraccount.php');
    exit();

}
}
?>

<main>
    <div class="container">
        <div class="text-center">
        <h2>Upravit uživatelské informace</h2>
        </div>
        <div class="container form">
            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Uživatelské jméno</label>
                    <input type="text" class="form-control <?php echo (!empty($errors['username'])?'is-invalid':''); ?>" id="username" name="username" value="<?php if (empty($_POST)) { echo $_SESSION['user_name']; }else {echo htmlspecialchars(@$_POST['username']); } ?>">
                    <?php
                    echo (!empty($errors['username'])?'<div class="invalid-feedback">'.$errors['username'].'</div>':'');
                    ?>
                </div>
                <div class="mb-3">
                    <label for="displayName" class="form-label">Viditelné jméno</label>
                    <input type="text" class="form-control" id="displayName" name="displayName" placeholder="Jan Novák" value="<?php if (empty($_POST)) { echo $_SESSION['displayName']; }else {echo htmlspecialchars(@$_POST['displayName']); } ?>">

                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Emailová adresa</label>
                    <input type="email" class="form-control <?php echo (!empty($errors['email'])?'is-invalid':''); ?>" id="email" name="email" aria-describedby="emailHelp" placeholder="priklad@priklad.cz" required value="<?php if (empty($_POST)) { echo $_SESSION['email']; }else {echo htmlspecialchars(@$_POST['email']); } ?>">
                    <?php
                    echo (!empty($errors['email'])?'<div class="invalid-feedback">'.$errors['email'].'</div>':'');
                    ?>
                </div>

                <button type="submit" class="btn btn-primary">Upravit</button>
                <a role="button" href="useraccount.php"  class="btn btn-danger">
                    Zrušit
                </a>
            </form>

        </div>


    </div>

</main>
