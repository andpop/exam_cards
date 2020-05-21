<?php
class Cards
{
    public $cardList = []; 

    function __construct()
    {
        $this->setCardList();
    }

    private function isCardFile($file)
    {
        $result = ($file->isFile() && (! $file->isDot()));
        $result = $result && (!in_array($file->getFilename(), CardsController::EXCLUDE_CARDS));
        
        return $result;
    }

    private function setCardList()
    {
        $this->cardList = [];
        foreach (new DirectoryIterator(CardsController::CARDS_DIR) as $file) {
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
