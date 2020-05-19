<?php
class CardsController
{
    public static function lockCard($number, $student)
    {
        $lockFilePath = Cards::CARDS_DIR . DIRECTORY_SEPARATOR . $number . '.' . Cards::LOCK_CARD_EXT;
        if (!file_exists($lockFilePath)) {
            return file_put_contents($lockFilePath, $student);
        } else {
            return false;
        }
    }
}