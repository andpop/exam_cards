<?php
class Card
{
    public $number;
    public $fileName;
    public $filePath;
    public $lockFile;
    public $isLocked;
    
    public function __construct($number, $fileName, $filePath, $lockFile, $isLocked)
    {
        $this->number = $number;
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->lockFile = $lockFile;
        $this->isLocked = $isLocked;
    }
}

