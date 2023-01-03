<?php
$page_title = "Ohodnoť film! - Přihlášení";
include('includes/header.php');

if (!empty($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}

require_once 'Gconfig.php';

$errors=false;
if (!empty($_POST)){

    $userQuery=$db->prepare('SELECT * FROM uzivatel WHERE uz_jmeno=:uz_jmeno LIMIT 1;');
    $userQuery->execute([
        ':uz_jmeno'=>trim($_POST['username'])
    ]);
    if ($user=$userQuery->fetch(PDO::FETCH_ASSOC)){

        if (password_verify($_POST['password'],$user['heslo'])){
            //heslo je platné => přihlásíme uživatele
            $_SESSION['user_id']=$user['user_id'];
            $_SESSION['user_name']=$user['uz_jmeno'];
            $_SESSION['displayName']=$user['vid_jmeno'];
            $_SESSION['email']=$user['email'];
            $_SESSION['role']=$user['role'];
            header('Location: index.php');
            exit();
        }else{
            $errors=true;
        }

    }else{
        $errors=true;
    }

}







?>

<main>

    <div class="container form">
        <div class="d-flex justify-content-center flex-column" align="center">
            <h2>Přihlášení</h2>
            <p>Přihlas se k svému účtu prostřednictvím vytvořeného účtu nebo Google účtu</p>
        </div>
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Uživatelské jméno</label>
                <input type="text" class="form-control <?php echo ($errors?'is-invalid':''); ?>" required id="username" name="username" value="<?php echo htmlspecialchars(@$_POST['username']);?>">
                <?php
                echo ($errors?'<div class="invalid-feedback">Neplatná kombinace přihlašovacího e-mailu a hesla.</div>':'');
                ?>
            </div>

            <div class="mb-3">
                <label for="Password" class="form-label">Heslo</label>
                <input type="password" class="form-control <?php echo (!empty($errors['password'])?'is-invalid':''); ?>" id="Password" name="password" required value="">

            </div>

            <button type="submit" class="btn btn-primary">Přihlásit se</button>
            <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo $login_url; ?>'">Přihlásit se pomocí Google Účtu</button>
        </form>
    </div>



<?php
include('includes/footer.php');