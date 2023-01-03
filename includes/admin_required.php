<?php


if(empty($_SESSION) || ($_SESSION['role']!='admin')){
    die('Tato stránka je dostupná pouze administrátorům.');
}