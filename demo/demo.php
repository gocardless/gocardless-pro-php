<?php

require('../lib/loader.php');

$client = new GoCardlessPro\Client(array(
  'access_token' => '<no value>',
  'environment'  => GoCardlessPro\Environment::SANDBOX
));

$creditors = $client->creditors()->list();

print_r($creditors);


