<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\DeckOfCards;
use App\Card\cardsSet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class cardsController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function card(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set('deck', $deck);
        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "deck")]
    public function deck(
        SessionInterface $session
    ): Response {
        $deck = $session->get('deck');
        $cards = $deck->sortedCards();

        $data = [
            'cards' => $cards
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "deck_shuffle")]
    public function deck_shuffle(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $session->set('deck', $deck);

        $cards = $deck->shuffle();

        $data = [
            'cards' => $cards
        ];

        return $this->render('card/deck_shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "deck_draw")]
    public function deck_draw(SessionInterface $session): Response
    {
        $deck = $session->get('deck');

        $card = $deck->draw();
        $numCards = $deck->numCards();

        $data = [
            'card' => $card,
            'numCards' => $numCards
        ];

        return $this->render('card/deck_draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{number<\d+>}", name: "deck_draw_num")]
    public function deck_draw_num(
        int $number,
        SessionInterface $session
    ): Response {
        $deck = $session->get('deck');
        $deck->shuffle();

        if ($number < 1 || $number > $deck->numCards()) {
            throw new \Exception("The number of cards to draw is invalid.");
        }


        $cards = [];
        for ($i = 0; $i < $number; $i++) {
            $cards[] = array_pop($deck->cards);
        }

        $numCards = $deck->numCards();

        $data = [
            'cards' => $cards,
            'numCards' => $numCards
        ];

        return $this->render('card/deck_draw_num.html.twig', $data);
    }
}
