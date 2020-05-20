<?php
class Card
{
    public $fileName;
    public $number;
    public $downloadPath;
    public $isLocked;
    public $student;
    
    private $filePath;
    private $lockFile;

    // Штатная getBaseName не срабатывала
    private function getBasename($fileName)
    {
        $position = strripos($fileName, '.');
        return $position ? substr($fileName, 0, $position) : $fileName;
    }

    private function getStudentForCard($lockFile)
    {
        try {
            $student = @file_get_contents($lockFile);
            return $student;
        } catch (Exception $e) {
            return '';
        }
    }

    public function __construct($file)
    {
        $this->fileName = $file->getFilename();
        $this->number = $this->getBasename($this->fileName);
        $this->filePath = $file->getPath() . DIRECTORY_SEPARATOR . $this->fileName;
        $this->downloadPath = CardsController::DOWNLOAD_DIR . DIRECTORY_SEPARATOR . $this->fileName;
        $this->lockFile = CardsController::LOCKED_DIR . DIRECTORY_SEPARATOR . $this->number . '.' . CardsController::LOCK_CARD_EXT;
        $this->isLocked = file_exists($this->lockFile);

        $this->student = $this->getStudentForCard($this->lockFile);
    }
}

