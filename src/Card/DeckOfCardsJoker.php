<?php
namespace App\Card;

class DeckOfCardsJoker extends DeckOfCards
{
    private $jokers;

    public function __construct()
    {
        parent::__construct();
        $this->jokers = [new Card('JOK', 'JOK'), new Card('JOKER', 'JOKER')];
        $this->cards = array_merge($this->cards, $this->jokers);
    }

    public function getJokers(): array
    {
        return $this->jokers;
    }

    public function getCardsNum(): int
    {
        return count($this->cards) - count($this->jokers);
    }
}
