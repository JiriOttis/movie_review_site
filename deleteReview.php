<?php

require_once 'includes/user.php';


$stmt = $db->prepare("DELETE FROM recenze WHERE film_id=:film_id AND user_id=:user_id");
$stmt->execute([
    ':user_id'=>$_SESSION['user_id'],
    ':film_id'=>$_GET['id']
]);


//znovunačtení
header('Location: moviedetails.php?id='.$_REQUEST['id']);


