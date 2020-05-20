<?php
class CardsController
{
    private static function copyCardForDownload($number) 
    {
        $cardFile = $number . '.' . Cards::CARD_EXT;
        $sourceFile = Cards::CARDS_DIR . DIRECTORY_SEPARATOR . $cardFile;
        $targetFile = Cards::DOWNLOAD_DIR . DIRECTORY_SEPARATOR . $cardFile;
        copy($sourceFile, $targetFile);
    }

    private static function createLockFile($number, $student)
    {
        $lockFilePath = Cards::CARDS_DIR . DIRECTORY_SEPARATOR . $number . '.' . Cards::LOCK_CARD_EXT;
        if (!file_exists($lockFilePath)) {
            return file_put_contents($lockFilePath, $student);
        } else {
            return false;
        }
    }

    public static function lockCard($number, $student)
    {
        if (CardsController::createLockFile($number, $student)) {
            CardsController::copyCardForDownload($number);
            return true;
        } else {
            return false;
        }
    }
}