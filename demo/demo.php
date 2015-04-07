<?php

require('../gocardless.php');

$client = new GoCardless\Client(array(
  'api_key' => '',
  'api_secret' => '',
  'environment' => 'https://api-sandbox.gocardless.com/'
));

$creditors = $client->creditors()->dolist();

print_r($creditors);


