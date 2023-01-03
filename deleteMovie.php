<?php

require 'includes/user.php';
require 'includes/admin_required.php';

$stmt = $db->prepare("SELECT img FROM film WHERE film_id=:film_id");
$stmt->execute([
    ':film_id'=>$_GET['id']
]);

$picturePath = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("DELETE FROM film WHERE film_id=:film_id");
$stmt->execute([
    ':film_id'=>$_GET['id']
]);

unlink($picturePath["img"]);

header('Location: adminaccount.php?page=2');




