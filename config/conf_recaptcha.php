<?php
  require_once '../vendor/autoload.php';

  $clientID = '682277659949-921nbukvt3i42if1pv267cb4htb0nop4.apps.googleusercontent.com';
  $clientSecret = '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';
  $redirectUri = 'http://localhost/PRUEBA/hola.php';

  $client = new Google_Client();
  $client->setClientId($clientID);
  $client->setClientSecret($clientSecret);
  $client->setRedirectUri($redirectUri);
  $client->addScope("email");
  $client->addScope("profile");
?>