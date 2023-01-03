<?php
//pripojeni do db na serveru eso.vse.cz
$db = new PDO('mysql:host=localhost;dbname=ottj01;charset=utf8', 'ottj01', 'Hokejista720');

//vyhazuje vyjimky v pripade neplatneho SQL vyrazu
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);