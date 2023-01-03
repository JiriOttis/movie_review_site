<?php

require_once 'google-api/vendor/autoload.php';

$gClient = new Google_Client();
$gClient->setClientId("258144232851-bfeginp5sm92rn56kdmamfhgonh53s0l.apps.googleusercontent.com");
$gClient->setClientSecret("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");
$gClient->setApplicationName("Login - Ohodnoť film!");
$gClient->setRedirectUri("http://localhost/ottj01/Gcontroller.php");
$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

$login_url = $gClient->createAuthUrl();

