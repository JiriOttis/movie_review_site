<?php
require 'db.php';

session_start(); //spustíme session


//kontorla zda je prihlaseny uzivatel platny
if (!empty($_SESSION['user_id'])){
    $userQuery=$db->prepare('SELECT user_id FROM uzivatel WHERE user_id=:id LIMIT 1;');
    $userQuery->execute([
        ':id'=>$_SESSION['user_id']
    ]);
    if ($userQuery->rowCount()!=1){
        //uživatel už není v DB, nebo není aktivní => musíme ho odhlásit
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['displayName']);
        unset($_SESSION['email']);
        unset($_SESSION['role']);
        header('Location: index.php');
        exit();
    }
}