<?php
require_once './Card.php';
require_once './Cards.php';
require_once './CardsController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $cards = new Cards("");
    echo($cards->toJson());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // file_put_contents( 'debug' . time() . '.log', var_export( $_POST, true));
    if (isset($_POST['number']) && isset($_POST['student'])) {
        
        if (!CardsController::lockCard($_POST['number'], $_POST['student'])) {
            $data = array('message' => 'При бронировании билета произошла ошибка');
            // Ошибка при записи lock-файла 
        } else {
            $data = array('message' => 'ok');
            // lock-файл создан
        };
        echo(json_encode($data));
    }
}
