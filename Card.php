<?php
class Card
{
    public $number;
    public $filePath;
    public $isLocked;
    public $student;
    
    private $lockFile;
    private $fileName;

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
        $this->number = $file->getBasename('.' . Cards::CARD_EXT);
        $this->fileName = $file->getFilename();
        $this->filePath = $file->getPath() . DIRECTORY_SEPARATOR . $this->fileName;
        $this->lockFile = $file->getPath() . DIRECTORY_SEPARATOR . $this->number . '.' . Cards::LOCK_CARD_EXT;
        $this->isLocked = file_exists($this->lockFile);
        $this->student = $this->getStudentForCard($this->lockFile);
    }
}

