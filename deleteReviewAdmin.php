<?php

require 'includes/user.php';
require 'includes/admin_required.php';

$stmt = $db->prepare("DELETE FROM recenze WHERE film_id=:film_id AND user_id=:user_id LIMIT 1");
$stmt->execute([
    ':user_id'=>$_GET['user'],
    ':film_id'=>$_GET['id']
]);

header('Location: moviedetails.php?id='.$_REQUEST['id']);
