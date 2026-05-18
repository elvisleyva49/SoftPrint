<?php
  require_once '../vendor/autoload.php';

  $config = require __DIR__ . '/config.php';

  $clientID = $config['GOOGLE_CLIENT_ID'];
  $clientSecret = $config['GOOGLE_CLIENT_SECRET'];
  $redirectUri = $config['GOOGLE_REDIRECT_URI'];

  $client = new Google_Client();
  $client->setClientId($clientID);
  $client->setClientSecret($clientSecret);
  $client->setRedirectUri($redirectUri);
  $client->addScope("email");
  $client->addScope("profile");
?>