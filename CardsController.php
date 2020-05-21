<?php
class CardsController
{
    const CARDS_DIR = 'cards';
    const LOCKED_DIR = 'locked_cards';
    const DOWNLOAD_DIR = 'download';
    const LOCK_CARD_EXT = 'lock';
    const EXCLUDE_CARDS = ['.htaccess'];

    private static function copyCardForDownload($cardFile) 
    {
        $sourceFile = self::CARDS_DIR . DIRECTORY_SEPARATOR . $cardFile;
        $targetFile = self::DOWNLOAD_DIR . DIRECTORY_SEPARATOR . $cardFile;
        copy($sourceFile, $targetFile);
    }

    private static function createLockFile($number, $student)
    {
        $lockFilePath = self::LOCKED_DIR . DIRECTORY_SEPARATOR . $number . '.' . self::LOCK_CARD_EXT;
        if (!file_exists($lockFilePath)) {
            return file_put_contents($lockFilePath, $student);
        } else {
            return false;
        }
    }

    public static function lockCard($number, $file, $student)
    {
        if (CardsController::createLockFile($number, $student)) {
            CardsController::copyCardForDownload($file);
            return true;
        } else {
            return false;
        }
    }
}