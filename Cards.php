<?php
class Cards
{
    const CARDS_DIR = 'files';
    const DOWNLOAD_DIR = 'download';
    const CARD_EXT = 'docx';
    const LOCK_CARD_EXT = 'lock';

    public $cardList = []; 

    function __construct()
    {
        $this->setCardList();
    }

    private function isCardFile($file)
    {
        return ($file->isFile() && (! $file->isDot()) && ($file->getExtension() == self::CARD_EXT));
    }

    private function setCardList()
    {
        $this->cardList = [];
        foreach (new DirectoryIterator(self::CARDS_DIR) as $file) {
            if ($this->isCardFile($file)) {
                $card = new Card($file);
                $this->cardList[$card->number] = $card;
            }
        }
        ksort($this->cardList);
        $this->cardList = array_values($this->cardList);
    }

    public function toJson()
    {
        return json_encode($this->cardList);
    }
}
