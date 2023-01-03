<?php

session_start();

require 'includes/db.php';
require_once "Gconfig.php";

if (isset($_GET["code"])){
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET["code"]);
}
else {
    header('Location: login.php');
    exit();
}


if(!isset($token["error"])){

$oAuth = new Google_Service_Oauth2($gClient);
$userData = $oAuth->userinfo_v2_me->get();


//hledame uzivatele podle Google ID**************************
    $query = $db->prepare('SELECT * FROM uzivatel WHERE google_id=:googleId LIMIT 1;');
    $query->execute([
       ':googleId'=>$userData["id"]
    ]);

    if ($query->rowCount()>0){
        $user = $query->fetch(PDO::FETCH_ASSOC);
    }
    else{ //hledame podle emailu***********************************
        $query = $db->prepare('SELECT * FROM uzivatel WHERE email=:email LIMIT 1;');
        $query->execute([
            ':email'=>$userData["email"]
        ]);

        if ($query->rowCount()>0){
            $user = $query->fetch(PDO::FETCH_ASSOC);

            $updateQuery = $db->prepare('UPDATE uzivatel SET google_id=:googleId WHERE user_id=:id LIMIT 1;');
            $updateQuery->execute([
               ':googleId'=>$userData["id"],
                ':id'=>$user['user_id']
            ]);
        }else{//ulozeni do databaze***************************
            $query = $db->prepare('INSERT INTO uzivatel (uz_jmeno, email, vid_jmeno, google_id) VALUES (:uz_jmeno, :email, :displayName, :googleId);');
            $query->execute([
                ':uz_jmeno' => $userData["givenName"] . ' ' . $userData["familyName"],
                ':email' => $userData["email"],
                ':displayName' => $userData["givenName"] . ' ' . $userData["familyName"],
                ':googleId'=>$userData["id"]
            ]);

            //zpetne nacteni uzivatele z DB*****************
            $query = $db->prepare('SELECT * FROM uzivatel WHERE google_id=:googleId LIMIT 1;');
            $query->execute([
                ':googleId'=>$userData["id"]
            ]);
            $user=$query->fetch(PDO::FETCH_ASSOC);
        }

    }
//prihlaseni uzivatele
    if (!empty($user)){
        $_SESSION['user_id']=$user['user_id'];
        $_SESSION['user_name']=$user['uz_jmeno'];
        $_SESSION['displayName']=$user['vid_jmeno'];
        $_SESSION['email']=$user['email'];
        $_SESSION['role']=$user['role'];
        header('Location: index.php');
        exit();
    }

}
else {
    header('Location: login.php');
    exit();
}
