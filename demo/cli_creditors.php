<?php

require('../lib/loader.php');

error_reporting(E_ALL | E_STRICT);

$client = new GoCardlessPro\Client(array(
    'access_token' => '<no value>',
    'environment'  => GoCardlessPro\Environment::SANDBOX
));


function get_input()
{
    return trim(fgets(STDIN));
}

$creditors = $client->creditors()->list();

foreach ($creditors as $num => $creditor) {
    echo '[' . $num . '] ' . $creditor->name() . "\n";
}

echo 'Please select a creditor by number: ';

$num = intval(get_input());

echo($creditors[$num]);

echo "\nNow, type the creditor's new address3: ";

$client->creditors()->update($creditors[$num]->id(), array('address_line3' => get_input()));

echo "\n";

$creditor = $client->creditors()->get($creditors[$num]->id());

echo $creditor;

