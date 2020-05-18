<?php
require_once 'Card.php';
require_once 'Cards.php';

$cards = new Cards("");
// print_r($cards);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json; charset=UTF-8");
echo($cards->toJson());
