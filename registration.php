<?php
$page_title = "Ohodnoť film! - Registrace";
include('includes/header.php');



//uživatel už je přihlášený, nemá smysl, aby se registroval
if (!empty($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}


$errors=[];

if (!empty($_POST)) {

    //USERNAME**************************************
    $username = trim(@$_POST['username']);
    if (empty($username)){
        $errors['username']='Musíte zadat uživatelské jméno.';
    }
    else{
        //kontrola, jestli již není e-mail registrovaný
        $mailQuery=$db->prepare('SELECT * FROM uzivatel WHERE uz_jmeno=:uz_jmeno LIMIT 1;');
        $mailQuery->execute([
            ':uz_jmeno'=>$username
        ]);
        if ($mailQuery->rowCount()>0){
            $errors['username']='Uživatelský účet s tímto uživatelským jménem již existuje.';
        }
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
    else{
            //kontrola, jestli již není e-mail registrovaný
            $mailQuery=$db->prepare('SELECT * FROM uzivatel WHERE email=:email LIMIT 1;');
            $mailQuery->execute([
                ':email'=>$email
            ]);
            if ($mailQuery->rowCount()>0){
                $errors['email']='Uživatelský účet s touto e-mailovou adresou již existuje.';
            }
        }

    //PASSWORD**************************************

    if (empty($_POST['password']) || (strlen($_POST['password'])<5)){
        $errors['password']='Musíte zadat heslo o délce alespoň 5 znaků.';
    }
    if ($_POST['password']!=$_POST['password2']){
        $errors['password2']='Zadaná hesla se neshodují.';
    }

    //konec kontorly udaju


    if (empty($errors)) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
//do databaze ulozeni
        $query = $db->prepare('INSERT INTO uzivatel (uz_jmeno, email, heslo, vid_jmeno) VALUES (:uz_jmeno, :email, :heslo, :vid_jmeno);');
        $query->execute([
            ':uz_jmeno' => $username,
            ':email' => $email,
            ':heslo' => $password,
            ':vid_jmeno' => $displayName
        ]);

        //prihlaseni uzivatele
        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['user_name']=$username;
        $_SESSION['displayName']=$displayName;
        $_SESSION['email']=$email;
        $_SESSION['role']="uzivatel";

        //přesměrování na homepage
        header('Location: index.php');
        exit();
    }
}
//konec prace s formularem



?>
    <main>

    <div class="container form">
        <div class="d-flex justify-content-center flex-column" align="center">
            <h2>Zaregistruj se!</h2>
            <p>Prosím zaregistruj svůj účet pro přidávání hodnocení a recenzí</p>
        </div>
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Uživatelské jméno</label>
                <input type="text" class="form-control <?php echo (!empty($errors['username'])?'is-invalid':''); ?>" id="username" name="username" value="<?php echo htmlspecialchars(@$_POST['username']);?>">
                <?php
                echo (!empty($errors['username'])?'<div class="invalid-feedback">'.$errors['username'].'</div>':'');
                ?>
            </div>
            <div class="mb-3">
                <label for="displayName" class="form-label">Viditelné jméno</label>
                <input type="text" class="form-control" id="displayName" name="displayName" placeholder="Jan Novák" value="<?php echo htmlspecialchars(@$_POST['displayName']);?>">

            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Emailová adresa</label>
                <input type="email" class="form-control <?php echo (!empty($errors['email'])?'is-invalid':''); ?>" id="email" name="email" aria-describedby="emailHelp" placeholder="priklad@priklad.cz" required value="<?php echo htmlspecialchars(@$_POST['email']);?>">
                <?php
                echo (!empty($errors['email'])?'<div class="invalid-feedback">'.$errors['email'].'</div>':'');
                ?>
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">Heslo</label>
                <input type="password" class="form-control <?php echo (!empty($errors['password'])?'is-invalid':''); ?>" id="Password" name="password" required value="">
                <?php
                echo (!empty($errors['password'])?'<div class="invalid-feedback">'.$errors['password'].'</div>':'');
                ?>
            </div>
            <div class="mb-3">
                <label for="Password2" class="form-label">Heslo pro kontorlu</label>
                <input type="password" class="form-control <?php echo (!empty($errors['password2'])?'is-invalid':''); ?>" id="Password2" name="password2" required value="">
                <?php
                echo (!empty($errors['password2'])?'<div class="invalid-feedback">'.$errors['password2'].'</div>':'');
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Zaregistrovat</button>
        </form>
    </div>

<?php
include('includes/footer.php');
