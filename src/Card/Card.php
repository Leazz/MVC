<?php

namespace App\Card;

class Card
{
    public $suit;
    public $value;

    public function __construct($suit, $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }

    public function getTheValue(): string
    {
        return $this->value;
    }

    public function getTheSuit(): string
    {
        return $this->suit;
    }

}
