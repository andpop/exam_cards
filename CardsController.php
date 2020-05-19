<?php
class CardsController
{
    public static function lockCard($number, $student)
    {
        $lockFilePath = Cards::CARDS_DIR . DIRECTORY_SEPARATOR . $number . '.' . Cards::LOCK_CARD_EXT;
        return file_put_contents($lockFilePath, $student);
    }
}