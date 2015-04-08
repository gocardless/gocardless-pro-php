<?php

require('../gocardless.php');

$client = new GoCardless\Client(array(
  'api_key'     => '<no value>',
  'api_secret'  => '<no value>',
  'environment' => GoCardless\Environment::SANDBOX
));

$creditors = $client->creditors()->list();

print_r($creditors);


