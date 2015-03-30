<?php

require(dirname(__FILE__) . '/../lib/init.php');

$apiUsername = "PK0000107KV3MJ";
$apiPassword = "12YD0wiFz3wgADIsV7xE-NqVCbzqSJZrEmGy3fEF";
$apiBase = "http://localhost:4454/";

$client = GoCardless::connect($apiUsername, $apiPassword, $apiBase);

$creditorList = $client->creditors()->dolist(array('limit' => 100));
print_r($creditorList);

