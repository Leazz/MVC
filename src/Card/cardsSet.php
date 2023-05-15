<?php

namespace App\Card;

use App\Card\Card;

class CardsSet
{
    private $cards = [];


    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    public function getCard(): array
    {
        return $this->cards;
    }


     public function getString(): array
     {
         $value = [];
         foreach ($this->cards as $card) {
             $value[] = $card->getAsString();
         }
         return $value;
     }


    public function getCardValues(): array
    {
        $value = [];
        foreach ($this->cards as $card) {
            $value[] = $card->getValue();
        }
        return $value;
    }
}
