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

class Cards
{
    const CARDS_DIR = 'files';
    const CARD_EXT = 'docx';
    const LOCK_CARD_EXT = 'lock';

    public $cardList = []; 

    function __construct()
    {
        $this->setCardList();
    }

    private function setCardList()
    {
        $this->cardList = [];
        foreach (new DirectoryIterator(self::CARDS_DIR) as $file) {
            if ($file->isFile() && (! $file->isDot()) && ($file->getExtension() == self::CARD_EXT)) {

                $cardNumber = $file->getBasename('.' . self::CARD_EXT);
                $cardFilename = $file->getFilename();
                $cardFilepath = $file->getPath() . DIRECTORY_SEPARATOR . $cardFilename;
                $lockFile = $file->getPath() . DIRECTORY_SEPARATOR . $cardNumber . '.' . self::LOCK_CARD_EXT;
                $isCardLocked = file_exists($lockFile);

                $card = new Card($cardNumber, $cardFilename, $cardFilepath, $lockFile, $isCardLocked);

                $this->cardList[$cardNumber] = $card;
            }
        }
        ksort($this->cardList);
    }

    public function toJson()
    {
        return json_encode($this->cardList);
    }
}

$cards = new Cards("");

echo($cards->toJson());
