<?php

namespace App\Card;

class DeckOfCards
{
    public $cards;

    public function __construct()
    {
        $this->initDeck();
    }

    private function initDeck()
    {
        $this->cards = [];

        $suits = ['♥', '♦', '♣', '♠'];
        $values = ['A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'K', 'J', 'Q'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new Card($suit, $value);
            }
        }
    }

    public function draw($number = 1)
    {
        return array_pop($this->cards);
    }

    public function shuffle()
    {
        shuffle($this->cards);
        return $this->cards;
    }

    public function sortedCards()
    {
        $cards = $this->cards;
        usort($cards, function ($a, $b) {
            $suitSet = ['♥', '♦', '♣', '♠'];
            $suitDiff = array_search($a->getTheSuit(), $suitSet) - array_search($b->getTheSuit(), $suitSet);
            if ($suitDiff === 0) {
                $valueSet = ['A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'Q', 'J', 'K'];
                return array_search($a->getTheValue(), $valueSet) - array_search($b->getTheValue(), $valueSet);
            }
            return $suitDiff;
        });
        return $cards;
    }

    public function numCards(): int
    {
        return count($this->cards);
    }

    public function clearDeck()
    {
        $this->initDeck();
    }
}
